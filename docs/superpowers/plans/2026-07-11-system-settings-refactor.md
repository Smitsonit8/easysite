# System Settings Refactor Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace duplicated component settings with one D7-backed declarative catalogue that supplies defaults, validation, template availability and a generated administration panel.

**Architecture:** `Sporina\EasySite\Settings` owns the catalogue and all persistence/normalization. The Bitrix component retains its public modes and AJAX actions, acting only as the authorization and HTTP adapter. The configuration template renders the categories and fields supplied by the service instead of hard-coding them.

**Tech Stack:** PHP 7-compatible Bitrix D7 (`Bitrix\Main\Config\Option`, `Application`, `Localization`), Bitrix components, Node.js built-in test runner.

## Global Constraints

- Preserve all 21 setting keys, their current defaults, `render`/`configure`, and `apply`/`reset`/`remember-section`.
- Store all Options by `SITE_ID` and read with `SITE_ID`.
- A setting is declared only in `Settings::getDefinitions()`; no second defaults or allowlist table is permitted.
- Missing, invalid, or unavailable-template values must resolve to the definition default without mutating stored data during a read.
- Write operations remain admin-only and protected by `check_bitrix_sessid()`.
- Do not change the version asserted by the existing test.

---

### Task 1: Create the single declarative settings service

**Files:**

- Create: `lib/settings.php`
- Modify: `include.php`
- Modify: `tests/system-settings.test.mjs`

**Interfaces:**

- Consumes: `Bitrix\Main\Config\Option`, `SITE_ID`, `SITE_TEMPLATE_PATH`.
- Produces: `Sporina\EasySite\Settings::getAll(): array`, `getPanel(): array`, `apply(array $settings): void`, `reset(): void`.

- [ ] **Step 1: Write the failing catalogue and D7 persistence test**

  Replace the tests that inspect `DEFAULTS` and `ALLOWED_VALUES` with the following assertions, while preserving the shared `keys` and `expectedDefaults` data.

  ```js
  test('settings service is the single catalogue of keys, defaults and validation metadata', () => {
    const source = read('install', 'lib', 'settings.php');
    assert.ok(existsSync(join(root, 'install', 'lib', 'settings.php')));
    assert.match(source, /namespace Sporina\\EasySite;/);
    assert.match(source, /final class Settings/);
    assert.match(source, /private const DEFINITIONS\s*=\s*\[/);
    assert.doesNotMatch(source, /DEFAULTS|ALLOWED_VALUES/);
    for (const key of keys) assert.match(source, new RegExp(`'key'\\s*=>\\s*'${key}'`));
    for (const [key, value] of Object.entries(expectedDefaults)) {
      const definition = new RegExp(`'key'\\s*=>\\s*'${key}'[\\s\\S]*?'default'\\s*=>\\s*'${value}'`);
      assert.match(source, definition);
    }
  });

  test('settings service uses site-scoped D7 options and provides defaults, templates and panel data', () => {
    const source = read('install', 'lib', 'settings.php');
    for (const method of ['getAll', 'getPanel', 'apply', 'reset', 'getDefinitions']) {
      assert.match(source, new RegExp(`function ${method}\\(`));
    }
    assert.match(source, /Option::get\(self::MODULE_ID,[\s\S]*?SITE_ID\)/);
    assert.match(source, /Option::set\(self::MODULE_ID,[\s\S]*?SITE_ID\)/);
    assert.match(source, /Option::delete\(self::MODULE_ID,[\s\S]*?SITE_ID\)/);
    assert.match(source, /SITE_TEMPLATE_PATH/);
    assert.match(source, /template\.php/);
    assert.match(source, /\^#\[0-9a-fA-F\]\{6\}\$/);
  });

  test('module include registers the settings service autoloader', () => {
    const source = read('include.php');
    assert.match(source, /registerAutoLoadClasses/);
    assert.match(source, /Sporina\\\\EasySite\\\\Settings/);
    assert.match(source, /lib\/settings\.php/);
  });
  ```

- [ ] **Step 2: Run the focused test and verify that it fails**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: FAIL because `lib/settings.php` and the `Settings` class do not exist.

- [ ] **Step 3: Add the autoload registration and the settings service**

  Replace `include.php` with:

  ```php
  <?php

  use Bitrix\Main\Loader;

  Loader::registerAutoLoadClasses('sporina.easysite', [
      'Sporina\\EasySite\\Settings' => 'lib/settings.php',
  ]);
  ```

  Create `lib/settings.php` with this public shape and implement the private helpers named below:

  ```php
  <?php

  namespace Sporina\EasySite;

  use Bitrix\Main\Config\Option;
  use Bitrix\Main\Localization\Loc;
  use InvalidArgumentException;

  final class Settings
  {
      private const MODULE_ID = 'sporina.easysite';
      private const DEFINITIONS = [
          // One entry per existing key: key, category, type, default, label, values.
          // Template-select entries additionally declare templatePath.
      ];

      public static function getDefinitions(): array {}
      public static function getAll(): array {}
      public static function getPanel(): array {}
      public static function apply(array $postedSettings): void {}
      public static function reset(): void {}
      private static function getDefinition(string $key): ?array {}
      private static function normalize(array $definition, string $value): ?string {}
      private static function getAllowedValues(array $definition): array {}
      private static function isTemplateAvailable(array $definition, string $value): bool {}
  }
  ```

  Populate `DEFINITIONS` with every element of the old `DEFAULTS` in the same order and with its exact current default. Use categories `template`, `header-footer`, and `main-page`; use `type => 'checkbox'` for `Y`/`N`, `type => 'color'` for `template-background-color`, and `type => 'select'` for the rest. Retain every existing allowed value inside that same definition's `values` array.

  For the seven template selectors, declare these `templatePath` values and filter them in `getAllowedValues()` with `SITE_TEMPLATE_PATH . '/components/' . $templatePath . '/' . $value . '/template.php'`:

  ```php
  'header-template' => 'sporina/header/templates',
  'footer-template' => 'sporina/footer/templates',
  'pages-main-banner-template' => 'sporina/banner/templates',
  'pages-main-infocards-template' => 'bitrix/news.list',
  'pages-main-articles-template' => 'bitrix/news.list',
  'pages-main-news-template' => 'bitrix/news.list',
  'pages-main-current-news-template' => 'bitrix/news.index',
  ```

  `getAll()` must call `Option::get(self::MODULE_ID, $key, $default, SITE_ID)`, return the normalized value or `default`; `apply()` must ignore unknown keys and throw `InvalidArgumentException('Invalid setting: ' . $key)` for an invalid known scalar; `reset()` must call `Option::delete(self::MODULE_ID, ['name' => $key, 'site_id' => SITE_ID])` for every declaration. `getPanel()` must group definitions by category, attach `value` from `getAll()`, `label` through `Loc::getMessage()`, and template-filtered `values`.

- [ ] **Step 4: Run the focused test and verify that it passes**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: new service tests PASS; legacy component tests may still FAIL until Task 2.

- [ ] **Step 5: Commit the service task**

  Run:

  ```bash
  git add include.php lib/settings.php tests/system-settings.test.mjs
  git commit -m "refactor: centralize system settings definitions"
  ```

### Task 2: Turn the component into the HTTP adapter

**Files:**

- Modify: `install/components/sporina/system.settings/class.php`
- Modify: `tests/system-settings.test.mjs`

**Interfaces:**

- Consumes: `Sporina\EasySite\Settings::{getAll,getPanel,apply,reset}`.
- Produces: unchanged render array; configure `arResult` gains `PANEL`.

- [ ] **Step 1: Write the failing adapter test**

  Add this test:

  ```js
  test('component delegates settings work to the D7 settings service while preserving its contract', () => {
    const source = read('install', 'components', 'sporina', 'system.settings', 'class.php');
    assert.match(source, /Loader::includeModule\('sporina\.easysite'\)/);
    assert.match(source, /Settings::getAll\(\)/);
    assert.match(source, /Settings::getPanel\(\)/);
    assert.match(source, /Settings::apply\(\$settings\)/);
    assert.match(source, /Settings::reset\(\)/);
    assert.doesNotMatch(source, /private const DEFAULTS|private const ALLOWED_VALUES|COption::/);
    assert.match(source, /\$USER->IsAdmin\(\)/);
    assert.match(source, /check_bitrix_sessid\(\)/);
    assert.match(source, /Application::getInstance\(\)->restartBuffer\(\)/);
    for (const action of ['apply', 'reset', 'remember-section']) assert.ok(source.includes(`'${action}'`));
  });
  ```

- [ ] **Step 2: Run the focused test and verify that it fails**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: FAIL because the component still owns constants and calls `COption`.

- [ ] **Step 3: Refactor `class.php` to delegate to `Settings`**

  Add imports and module initialization:

  ```php
  use Bitrix\Main\Loader;
  use Sporina\EasySite\Settings;

  if (!Loader::includeModule('sporina.easysite')) {
      throw new RuntimeException('Module sporina.easysite is not installed');
  }
  ```

  Remove `DEFAULTS`, `ALLOWED_VALUES`, `applySettings()`, `resetSettings()`, `loadSettings()` and `isValidValue()`. Replace their call sites with:

  ```php
  return Settings::getAll();
  ```

  ```php
  'SETTINGS' => Settings::getAll(),
  'PANEL' => Settings::getPanel(),
  ```

  ```php
  Settings::apply($settings);
  Settings::reset();
  ```

  Keep `processAction()`, its error handling, authorization, sessid check and session category behavior intact. Use `Application::getInstance()->restartBuffer()` and `Application::getInstance()->getContext()->getResponse()->setStatus($status)` in `sendJson()` before emitting the unchanged JSON payload.

- [ ] **Step 4: Run the focused test and PHP syntax check**

  Run:

  ```bash
  node --test tests/system-settings.test.mjs
  php -l install/components/sporina/system.settings/class.php
  php -l lib/settings.php
  ```

  Expected: all Node tests and both syntax checks PASS.

- [ ] **Step 5: Commit the adapter task**

  Run:

  ```bash
  git add install/components/sporina/system.settings/class.php tests/system-settings.test.mjs
  git commit -m "refactor: delegate settings component to service"
  ```

### Task 3: Add the catalogue-driven administration panel

**Files:**

- Create: `install/components/sporina/system.settings/templates/.default/template.php`
- Create: `install/components/sporina/system.settings/templates/.default/lang/ru/template.php`
- Modify: `tests/system-settings.test.mjs`

**Interfaces:**

- Consumes: `$arResult['PANEL']`, `SETTINGS`, `ACTIVE_CATEGORY`, `ACTION_VARIABLE`.
- Produces: an admin-only form whose field names are `settings[<definition key>]`.

- [ ] **Step 1: Write the failing generated-panel test**

  Add this test:

  ```js
  test('configuration template renders the panel from service definitions', () => {
    const template = read('install', 'components', 'sporina', 'system.settings', 'templates', '.default', 'template.php');
    assert.match(template, /\$arResult\['PANEL'\]/);
    assert.match(template, /foreach \(\$arResult\['PANEL'\]/);
    assert.match(template, /settings\[/);
    assert.match(template, /bitrix_sessid_post\(\)/);
    assert.match(template, /apply|reset|remember-section/);
    assert.ok(existsSync(join(component, 'templates', '.default', 'lang', 'ru', 'template.php')));
  });
  ```

- [ ] **Step 2: Run the focused test and verify that it fails**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: FAIL because the component has no default template.

- [ ] **Step 3: Create the safe generic template and its Russian messages**

  In `template.php`, check `B_PROLOG_INCLUDED`, load localized messages, and render only from `$arResult['PANEL']`:

  ```php
  <?php foreach ($arResult['PANEL'] as $category => $fields): ?>
      <section class="system-settings__category" data-category="<?=htmlspecialcharsbx($category)?>">
          <?php foreach ($fields as $field): ?>
              <label>
                  <span><?=htmlspecialcharsbx($field['label'])?></span>
                  <?php if ($field['type'] === 'checkbox'): ?>
                      <input type="hidden" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="N">
                      <input type="checkbox" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="Y"<?= $field['value'] === 'Y' ? ' checked' : '' ?>>
                  <?php elseif ($field['type'] === 'color'): ?>
                      <input type="color" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="<?=htmlspecialcharsbx($field['value'])?>">
                  <?php else: ?>
                      <select name="settings[<?=htmlspecialcharsbx($field['key'])?>]">
                          <?php foreach ($field['values'] as $value => $label): ?>
                              <option value="<?=htmlspecialcharsbx($value)?>"<?= $value === $field['value'] ? ' selected' : '' ?>><?=htmlspecialcharsbx($label)?></option>
                          <?php endforeach; ?>
                      </select>
                  <?php endif; ?>
              </label>
          <?php endforeach; ?>
      </section>
  <?php endforeach; ?>
  ```

  Wrap it in a `method="post"` form that includes `<?=bitrix_sessid_post()?>`, a hidden action field named with `ACTION_VARIABLE`, and submit buttons with `apply` and `reset`. Add a small inline script that sends `new FormData(form)` to `form.action || window.location.href` with `fetch()` and `credentials: 'same-origin'`; when JavaScript is unavailable, the form remains a regular POST. On category change, submit a second `FormData` with the same action field set to `remember-section` and the selected `section`. Escape every key, label, category and selected value with `htmlspecialcharsbx`.

  Add Russian messages for the three category headings and the Apply/Reset controls in `templates/.default/lang/ru/template.php`; use `Loc::getMessage()` in the template. Do not hard-code per-setting fields or option lists.

- [ ] **Step 4: Run all static and syntax checks**

  Run:

  ```bash
  node --test tests/system-settings.test.mjs
  php -l install/components/sporina/system.settings/templates/.default/template.php
  php -l install/components/sporina/system.settings/templates/.default/lang/ru/template.php
  ```

  Expected: all commands PASS.

- [ ] **Step 5: Commit the panel task**

  Run:

  ```bash
  git add install/components/sporina/system.settings/templates tests/system-settings.test.mjs
  git commit -m "feat: generate system settings administration panel"
  ```

### Task 4: Perform final regression verification

**Files:**

- Modify: `tests/system-settings.test.mjs` only if a test assertion needs correction to match the approved public contract.

**Interfaces:**

- Consumes: all files from Tasks 1–3.
- Produces: verified installable module sources.

- [ ] **Step 1: Verify every existing template selector against source files**

  Run:

  ```bash
  rg --files install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components | rg "(sporina/header/templates|sporina/footer/templates|sporina/banner/templates|bitrix/news.list|bitrix/news.index).*/template\.php$"
  ```

  Expected: each catalogue template value has a matching `template.php`; if a historical allowlisted value has no source template, retain it only when its declaration default is available and document its exclusion in the test name.

- [ ] **Step 2: Run the complete regression suite**

  Run:

  ```bash
  node --test tests/system-settings.test.mjs
  php -l include.php
  php -l lib/settings.php
  php -l install/components/sporina/system.settings/class.php
  php -l install/components/sporina/system.settings/templates/.default/template.php
  ```

  Expected: every command exits 0.

- [ ] **Step 3: Review the change set**

  Run: `git diff --check`

  Expected: no whitespace errors.

- [ ] **Step 4: Commit final test adjustments when Git metadata is repaired**

  Run:

  ```bash
  git add tests/system-settings.test.mjs
  git commit -m "test: cover declarative settings refactor"
  ```
