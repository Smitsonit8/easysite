# Stand Product Gallery Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add an accessible image gallery and an emphasized price block to the `stand` product-detail template.

**Architecture:** `template.php` will build one normalized image list from the primary image and `GALLERY`, render the gallery and price property, and keep the selected product in the Bitrix session. `style.css` will make thumbnails a responsive, scrollable strip and price a clear callout; `script.js` will manage the active image and modal navigation.

**Tech Stack:** Bitrix PHP template, CSS, vanilla JavaScript.

## Global Constraints

- Modify only `bitrix:news.detail/stand`; do not change `smoothness` or `layering`.
- Read gallery files from the `GALLERY` property and the price from `PRICE`.
- Escape dynamic text and image URLs with `htmlspecialcharsbx`.
- Preserve keyboard navigation and localized labels.

---

### Task 1: Render product images and price in `stand`

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/template.php`
- Test: manual static check of the template source

**Interfaces:**
- Consumes: `$arResult['DETAIL_PICTURE']`, `$arResult['PREVIEW_PICTURE']`, `$arResult['PROPERTIES']['GALLERY']['VALUE']`, and `$arResult['PROPERTIES']['PRICE']['VALUE']`.
- Produces: `.sporina-product-detail`, `[data-detail-slide]`, `[data-detail-thumb]`, and `.sporina-product-detail__price` markup used by the style and script.

- [ ] **Step 1: Write the failing static check**

```powershell
$template = Get-Content -Raw 'install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/template.php'
if ($template -notmatch "PROPERTIES\]\['PRICE'\]" -or $template -notmatch 'data-detail-thumb') { throw 'PRICE block or gallery thumbnails are missing' }
```

- [ ] **Step 2: Run the check and confirm it fails**

Run: the command above.

Expected: it throws because the old template has neither a `PRICE` property block nor thumbnail gallery markup.

- [ ] **Step 3: Implement the template**

Replace the old detail-picture/preview layout with a normalized image array, slider buttons, thumbnail buttons, a modal, and a `PRICE` callout rendered after the description. Keep detail text and the `FORM_TOVAR_NAME` session behavior.

- [ ] **Step 4: Run the static check and PHP syntax validation**

```powershell
php -l 'install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/template.php'
```

Expected: the static check succeeds and PHP reports no syntax errors.

### Task 2: Style responsive thumbnails and price

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/style.css`
- Test: manual static check of the stylesheet source

**Interfaces:**
- Consumes: `.sporina-product-detail__thumbs`, `.sporina-product-detail__thumb`, `.sporina-product-detail__price` from Task 1.
- Produces: responsive visual treatment for the detail gallery.

- [ ] **Step 1: Write the failing static check**

```powershell
$style = Get-Content -Raw 'install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/style.css'
if ($style -notmatch 'overflow-x:auto' -or $style -notmatch 'sporina-product-detail__price-label') { throw 'Mobile gallery scrolling or price label styling is missing' }
```

- [ ] **Step 2: Run the check and confirm it fails**

Run: the command above.

Expected: it throws because the old stylesheet has no gallery strip or price label.

- [ ] **Step 3: Implement the styles**

Use a two-column grid at desktop width, a one-column layout below 900px, fixed-size thumbnail buttons with visible active/focus states, and horizontal thumbnail scrolling. Style the price block with `--accent`, `--primary`, and a larger numeric value.

- [ ] **Step 4: Run the static check**

Run: the command from Step 1.

Expected: it completes without throwing.

### Task 3: Add gallery interaction

**Files:**
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/script.js`
- Test: Node syntax validation when Node is available

**Interfaces:**
- Consumes: `[data-detail-gallery]`, `[data-detail-slide]`, `[data-detail-thumb]`, `[data-detail-prev]`, `[data-detail-next]`, and `[data-product-modal]` from Task 1.
- Produces: active-image changes, modal open/close, and Escape/arrow-key navigation.

- [ ] **Step 1: Write the failing static check**

```powershell
$scriptPath = 'install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/script.js'
if (-not (Test-Path $scriptPath)) { throw 'Gallery script is missing' }
```

- [ ] **Step 2: Run the check and confirm it fails**

Run: the command above.

Expected: it throws because `stand/script.js` does not exist.

- [ ] **Step 3: Implement the script**

Create an idempotent initializer that switches slides and selected thumbnails, opens the modal from the main image, restores focus on close, supports Escape and left/right keys, and initializes after Bitrix AJAX updates.

- [ ] **Step 4: Run static and syntax checks**

```powershell
node --check 'install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.detail/stand/script.js'
```

Expected: the file exists and Node reports no syntax errors.
