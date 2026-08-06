# Button Effects Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Allow an administrator to choose one global visual effect for every `<button>` and `<a class="button">` element.

**Architecture:** Add the allowlisted selection to `Settings::DEFINITIONS`, which already drives the configuration panel, persistence, validation and reset behavior. In the site header, validate the returned setting and use an inline, idempotent DOM function to replace effect classes on matching elements both initially and after Bitrix AJAX updates.

**Tech Stack:** PHP 7-compatible Bitrix module/template code; browser JavaScript; Node.js built-in test runner.

## Global Constraints

- Valid values are `''`, `btn-effect-1`, `btn-effect-2`, and `btn-effect-3`; the default is `''`.
- The effect applies only to `<button>` and `<a class="button">` elements.
- An invalid stored value must produce no effect class.
- Existing user changes outside the named files must remain untouched.

---

### Task 1: Expose and validate the setting in the system-settings catalogue

**Files:**
- Modify: `install/lib/settings.php:30-45`
- Modify: `tests/system-settings.test.mjs:11-121`

**Interfaces:**
- Consumes: `Settings::DEFINITIONS`, whose `select` entries are validated by `Settings::normalize()` and rendered by `Settings::getPanel()`.
- Produces: `Settings::getAll()['template-button-effect']` as one of `''`, `btn-effect-1`, `btn-effect-2`, or `btn-effect-3`.

- [ ] **Step 1: Extend the catalogue test with the new key and value contract**

  Add `template-button-effect` immediately after the other template appearance keys and assert its default and allowlisted values:

  ```js
  'template-button-effect',

  'template-button-effect': '',

  const buttonEffectDefinition = source.match(
    /\['key'\s*=>\s*'template-button-effect'[\s\S]*?\],/,
  )?.[0] ?? '';
  for (const value of ['', 'btn-effect-1', 'btn-effect-2', 'btn-effect-3']) {
    assert.ok(buttonEffectDefinition.includes(`'${value}'`));
  }
  ```

  Update the pre-existing key/default assertions in this test to match the current settings catalogue (`typography-text-size` and `typography-heading-size`) so the suite describes the source it verifies.

- [ ] **Step 2: Run the test to verify the new assertion fails**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: FAIL because `template-button-effect` has not yet been declared.

- [ ] **Step 3: Add the select definition**

  Insert this declaration in the `template` category of `Settings::DEFINITIONS`:

  ```php
  ['key' => 'template-button-effect', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Эффект кнопок', 'type' => 'select', 'default' => '', 'values' => ['' => 'Без эффекта', 'btn-effect-1' => 'Эффект 1', 'btn-effect-2' => 'Эффект 2', 'btn-effect-3' => 'Эффект 3']],
  ```

  Do not special-case persistence: the existing `getAll()`, `getPanel()`, `apply()` and `reset()` implementations derive their behavior from this definition.

- [ ] **Step 4: Run the settings tests**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: PASS.

- [ ] **Step 5: Commit the catalogue change**

  ```bash
  git add install/lib/settings.php tests/system-settings.test.mjs
  git commit -m "feat: add button effect setting"
  ```

### Task 2: Apply the selected effect globally in the site header

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php:28-90`
- Modify: `tests/system-settings.test.mjs:after settings-catalogue tests`

**Interfaces:**
- Consumes: `$sporinaSettings['template-button-effect']` from Task 1.
- Produces: each matching DOM element has zero or one class from `btn-effect-1`, `btn-effect-2`, `btn-effect-3`.

- [ ] **Step 1: Write a header-source test for the target selector, allowlist, and AJAX reapplication**

  Add a Node test that reads `header.php` and checks for all three details:

  ```js
  test('header applies the configured button effect to global button targets', () => {
    const header = read('install', 'wizards', 'sporina', 'easy_site', 'site', 'templates', 'sporina_easy_site', 'header.php');
    assert.match(header, /button, a\\.button/);
    assert.match(header, /btn-effect-1[\\s\\S]*btn-effect-2[\\s\\S]*btn-effect-3/);
    assert.match(header, /onAjaxSuccess/);
  });
  ```

- [ ] **Step 2: Run the test to verify it fails**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: FAIL because the header has no button-effect application code.

- [ ] **Step 3: Validate the setting and add the idempotent script**

  Before the closing `?>` preceding `<!DOCTYPE html>`, derive `$buttonEffect` from a strict allowlist:

  ```php
  $buttonEffect = in_array($sporinaSettings['template-button-effect'] ?? '', ['', 'btn-effect-1', 'btn-effect-2', 'btn-effect-3'], true)
      ? $sporinaSettings['template-button-effect']
      : '';
  ```

  In the page `<head>`, add an inline script that embeds the value with `json_encode($buttonEffect)`, defines `applyButtonEffect()`, and uses this body exactly:

  ```js
  var targets = document.querySelectorAll('button, a.button');
  var effectClasses = ['btn-effect-1', 'btn-effect-2', 'btn-effect-3'];
  targets.forEach(function (element) {
    element.classList.remove.apply(element.classList, effectClasses);
    if (effect) element.classList.add(effect);
  });
  ```

  Register it on `DOMContentLoaded`, invoke it immediately when the document is already ready, and subscribe with `BX.addCustomEvent('onAjaxSuccess', applyButtonEffect)` only when `window.BX` and `BX.addCustomEvent` exist. This makes reruns safe and preserves pages where the Bitrix JS object is absent.

- [ ] **Step 4: Run the settings tests**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: PASS.

- [ ] **Step 5: Manually verify the rendered behavior in Bitrix**

  As an administrator, choose each of «Без эффекта», «Эффект 1», «Эффект 2», and «Эффект 3» in the site settings panel and save. Inspect a native `<button>`, an `<a class="button">`, and a non-button link: the first two must have only the selected effect class; the ordinary link must have none. Trigger an AJAX component refresh and confirm the selected class is also applied to newly rendered targets.

- [ ] **Step 6: Commit the header behavior**

  ```bash
  git add install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php tests/system-settings.test.mjs
  git commit -m "feat: apply selected button effect globally"
  ```

### Task 3: Verify the completed feature

**Files:**
- Verify: `install/lib/settings.php`
- Verify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php`
- Verify: `tests/system-settings.test.mjs`

**Interfaces:**
- Consumes: the setting catalogue and header behavior from Tasks 1–2.
- Produces: evidence that the configured class is allowlisted, globally applied, and dynamically re-applied.

- [ ] **Step 1: Run the complete automated suite**

  Run: `node --test tests/system-settings.test.mjs`

  Expected: PASS with no failing subtests.

- [ ] **Step 2: Inspect the working-tree patch for scope**

  Run: `git diff --check && git status --short`

  Expected: no whitespace errors; only the files from Tasks 1–2 are changed or committed by this feature, aside from pre-existing user changes.

- [ ] **Step 3: Report the verification result**

  State the automated test command and result, and note whether manual Bitrix-panel/AJAX verification was performed in a running installation.
