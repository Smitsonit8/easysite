# Typography Panel Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add two saved typography controls that scale site text and headings from the existing settings panel.

**Architecture:** `Sporina\EasySite\Settings` declares, validates, persists, resets, and exposes the two controls. The header writes normalized values as HTML data attributes; `typography.css` maps them to the central tokens used by component styles.

**Tech Stack:** PHP/Bitrix, CSS custom properties, Node.js built-in test runner.

## Global Constraints

- Keys: `typography-text-size` and `typography-heading-size`; values: exactly `small`, `medium`, `large`; default: `medium`.
- Remove `template-headings-size` and `--site-heading-scale`; do not retain a duplicate control.
- Do not change component templates, content queries, caching, AJAX, or page H1 markup.
- Preserve existing semantic typography aliases; do not add `!important`.
- The existing successful-save reload applies settings; no live-preview JavaScript is needed.

---

## File Structure

- `lib/settings.php`: catalogue, validation, persistence, reset and panel categories.
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php`: root `data-*` attributes.
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/typography.css`: derived responsive scale and semantic aliases.
- `tests/system-settings.test.mjs`: regression coverage for settings and central CSS.

### Task 1: Replace the legacy catalogue entry

**Files:**
- Modify: `tests/system-settings.test.mjs`
- Modify: `lib/settings.php`

**Interfaces:**
- Consumes: `Settings::getAll()`, `Settings::getPanel()`, `Settings::getAppearance()`.
- Produces: two normalized select settings in the `typography` category.

- [ ] **Step 1: Write the failing test**

Change the expected `keys` list: remove `template-headings-size`, add the two typography keys. Add exact defaults and a test for the category and values:

```js
assert.match(source, /'key'\s*=>\s*'typography-text-size'[\s\S]*?'default'\s*=>\s*'medium'/);
assert.match(source, /'key'\s*=>\s*'typography-heading-size'[\s\S]*?'default'\s*=>\s*'medium'/);
assert.doesNotMatch(source, /'key'\s*=>\s*'template-headings-size'/);
```

- [ ] **Step 2: Run test to verify it fails**

Run: `node --test tests/system-settings.test.mjs`

Expected: FAIL because the legacy key remains and new definitions are absent.

- [ ] **Step 3: Write minimal implementation**

In `lib/settings.php`, add the `typography` category titled `Типографика`; replace the legacy definition with:

```php
['key' => 'typography-text-size', 'category' => 'typography', 'categoryTitle' => 'Типографика', 'label' => 'Размер текста', 'type' => 'select', 'default' => 'medium', 'values' => ['small' => 'Маленький', 'medium' => 'Стандартный', 'large' => 'Крупный']],
['key' => 'typography-heading-size', 'category' => 'typography', 'categoryTitle' => 'Типографика', 'label' => 'Размер заголовков', 'type' => 'select', 'default' => 'medium', 'values' => ['small' => 'Компактный', 'medium' => 'Стандартный', 'large' => 'Крупный']],
```

Delete the `headingScale` lookup and output from `getAppearance()`.

- [ ] **Step 4: Run test to verify it passes**

Run: `node --test tests/system-settings.test.mjs`

Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add lib/settings.php tests/system-settings.test.mjs
git commit -m "feat: add typography settings"
```

### Task 2: Apply attributes and central CSS scale

**Files:**
- Modify: `tests/system-settings.test.mjs`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/typography.css`

**Interfaces:**
- Consumes: `$sporinaSettings['typography-text-size']` and `$sporinaSettings['typography-heading-size']`.
- Produces: root attributes and `--typography-text-base`, `--typography-heading-scale`, `--font-size-base`, and heading tokens.

- [ ] **Step 1: Write the failing test**

Add checks:

```js
assert.match(header, /data-text-size=/);
assert.match(header, /data-heading-size=/);
assert.doesNotMatch(header, /--site-heading-scale/);
assert.match(css, /html\[data-text-size="small"\][\s\S]*?15px/);
assert.match(css, /html\[data-heading-size="large"\][\s\S]*?1\.12/);
assert.match(css, /--font-size-base:\s*var\(--typography-text-base\)/);
assert.match(css, /--font-size-h1:\s*calc\(var\(--heading-size-h1-base\) \* var\(--typography-heading-scale\)\)/);
```

- [ ] **Step 2: Run test to verify it fails**

Run: `node --test tests/system-settings.test.mjs`

Expected: FAIL because the header and CSS use the old scale.

- [ ] **Step 3: Write minimal implementation**

In `header.php`, use the two settings in this root element and remove its `--site-heading-scale` declaration:

```php
<html lang="ru" data-text-size="<?=htmlspecialcharsbx($textSize)?>" data-heading-size="<?=htmlspecialcharsbx($headingSize)?>">
```

In `typography.css`, map text values to `15px`, `16px`, `18px`, heading values to `0.9`, `1`, `1.12`; derive xs–lg from the text base and h6–hero from fixed heading bases times the heading scale. Retain aliases and make h1–h4 plus banners responsive with `clamp()`. Retain `font-size: max(1rem, var(--font-size-sm))` for form fields.

- [ ] **Step 4: Run tests and syntax checks**

Run: `php -l lib/settings.php; php -l install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php; node --test tests/system-settings.test.mjs`

Expected: no PHP syntax errors and zero Node failures.

- [ ] **Step 5: Commit**

```bash
git add install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/typography.css tests/system-settings.test.mjs
git commit -m "feat: apply configurable typography scale"
```

### Task 3: Runtime validation

**Files:**
- Inspect: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/typography.css`

**Interfaces:**
- Consumes: saved settings and root attributes.
- Produces: evidence for the 3×3 matrix and required widths.

- [ ] **Step 1: Check settings matrix**

Save every pair: `(small, small)`, `(small, medium)`, `(small, large)`, `(medium, small)`, `(medium, medium)`, `(medium, large)`, `(large, small)`, `(large, medium)`, `(large, large)`.

- [ ] **Step 2: Check pages and widths**

At `1440`, `1200`, `992`, `768`, `576`, `375`, `320` px inspect `/`, `/uslugi/`, `/tovary/`, `/news/`, `/about/`, `/about/jobs/`, `/about/statistics/`, `/contacts/`, a detail page, a form, long H1, cards, footer, mobile menu, and each banner template.

- [ ] **Step 3: Record acceptance evidence**

Confirm no horizontal overflow, duplicate H1, or PHP/JavaScript errors; confirm reset restores `medium`. If no Bitrix runtime is available, report that limitation without speculative component edits.
