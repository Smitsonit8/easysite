# Banner Background Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Permit each `sporina:banner` call to display a supplied CSS color or gradient when no background image is configured.

**Architecture:** The component passes trimmed `BACKGROUND_COLOR` through `$arResult`. All three templates add an escaped inline `background` declaration only if `BACKGROUND_IMAGE_SRC` is empty, otherwise their current image branch remains authoritative.

**Tech Stack:** PHP, 1C-Bitrix component templates, Node.js built-in test runner.

## Global Constraints

- Support colors, gradients, `var(--banner-gradient-1)` and `var(--banner-gradient-2)`.
- Cover `.default`, `centered` and `compact`.
- Keep `BACKGROUND_IMAGE_SRC` as the higher-priority source.
- Keep the current CSS background when no parameter is set.
- Localize the parameter label in Russian and English through component language files.

---

### Task 1: Custom background parameter

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner/component.php:28-48`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner/templates/.default/template.php:10-20`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner/templates/centered/template.php:10-20`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner/templates/compact/template.php:10-20`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner/lang/ru/.parameters.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner/lang/en/.parameters.php`
- Create: `tests/banner-background.test.mjs`

**Interfaces:**

- Consumes: string parameter `BACKGROUND_COLOR`.
- Produces: `$arResult['BACKGROUND_COLOR']`, containing the trimmed custom CSS value or an empty string.

- [ ] **Step 1: Write a failing static test**

```js
assert.match(component, /BACKGROUND_COLOR/);
assert.match(parameters, /Loc::getMessage\("BACKGROUND_COLOR"\)/);
assert.match(ruLanguage, /Цвет фона/);
assert.match(enLanguage, /Background color/);
assert.match(template, /elseif \(\$arResult\["BACKGROUND_COLOR"\] !== ""\)/);
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `node --test tests/banner-background.test.mjs`

Expected: FAIL because `BACKGROUND_COLOR` is not read, returned or rendered.

- [ ] **Step 3: Implement the minimum parameter flow**

```php
$backgroundColor = trim((string)($arParams["BACKGROUND_COLOR"] ?? ""));
"BACKGROUND_COLOR" => $backgroundColor,

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
"NAME" => Loc::getMessage("BACKGROUND_COLOR"),

elseif ($arResult["BACKGROUND_COLOR"] !== "")
{
    $bannerStyle = "background: ".htmlspecialcharsbx($arResult["BACKGROUND_COLOR"]).";";
}
```

- [ ] **Step 4: Run focused and existing tests**

Run: `node --test tests/banner-background.test.mjs tests/system-settings.test.mjs`

Expected: PASS.

- [ ] **Step 5: Commit the feature**

Run: `git add install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/banner tests/banner-background.test.mjs && git commit -m "feat: add custom banner background"`
