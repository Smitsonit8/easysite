# Product Card Variants Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add `ladybug` and `fireant` selectable Bitrix news-list templates for product cards.

**Architecture:** Each variant is a self-contained Bitrix template directory with its own PHP markup, CSS, gallery JavaScript, and localized interface labels. Both use the established `smoothness` template data contract while styling cards independently.

**Tech Stack:** Bitrix PHP templates, CSS, vanilla JavaScript.

## Global Constraints

- Do not alter `layering`, `smoothness`, or `stand`.
- Do not run automated tests, per user request.
- Do not use Git commands, per user request.
- Preserve the `GALLERY` and `PRICE` property contract and escape dynamic attributes.
- Support responsive grids, image fallbacks, keyboard-accessible gallery buttons, and reduced motion.

---

### Task 1: Create the `ladybug` template

**Files:**
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/ladybug/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/ladybug/style.css`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/ladybug/script.js`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/ladybug/lang/en/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/ladybug/lang/ru/template.php`

**Interfaces:**
- Consumes: `$arResult['ITEMS']`, optional `$arParams['GALLERY_PROPERTY_CODE']`, `PRICE` item property, and standard Bitrix edit/delete links.
- Produces: `.sporina-ladybug-list` markup with gallery hooks `data-product-gallery`, `data-product-slide`, `data-product-prev`, `data-product-next`, and `data-product-counter`.

- [ ] **Step 1: Add PHP markup based on the existing news-list data contract.**

  Render each item as a card with an image/gallery region, price, title, preview text, detail link, optional pager, placeholder, and localized navigation labels. Use `ladybug` as the variant class and keep all dynamic output escaped except existing preview HTML.

- [ ] **Step 2: Add the `ladybug` visual layer.**

  Define a dark high-contrast card with a warm accent price cutout, sharp outline, hover image zoom, responsive three/two/one-column grid, and a `prefers-reduced-motion` override.

- [ ] **Step 3: Add the gallery initializer.**

  Initialize each uninitialized gallery once, cycle its active slide from previous/next buttons, update the counter, and rerun after Bitrix AJAX success.

- [ ] **Step 4: Add English and Russian interface labels.**

  Define `SPORINA_PRODUCT_DETAILS`, `SPORINA_PRODUCT_PREVIOUS`, `SPORINA_PRODUCT_NEXT`, and `CT_BNL_ELEMENT_DELETE_CONFIRM` in both language files.

### Task 2: Create the `fireant` template

**Files:**
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/fireant/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/fireant/style.css`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/fireant/script.js`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/fireant/lang/en/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/fireant/lang/ru/template.php`

**Interfaces:**
- Consumes: `$arResult['ITEMS']`, optional `$arParams['GALLERY_PROPERTY_CODE']`, `PRICE` item property, and standard Bitrix edit/delete links.
- Produces: `.sporina-fireant-list` markup using the same gallery data attributes as Task 1.

- [ ] **Step 1: Add PHP markup for the soft-card variant.**

  Render the same Bitrix data and interaction contract as Task 1, while using `fireant`-scoped classes and localized labels.

- [ ] **Step 2: Add the `fireant` visual layer.**

  Define a light rounded card with a softly elevated shadow, rounded media area, warm price chip, hover lift, responsive four/three/two/one-column grid, and a reduced-motion override.

- [ ] **Step 3: Add the gallery initializer.**

  Use the same data attributes and behavior as Task 1, scoped to the new template’s card list.

- [ ] **Step 4: Add English and Russian interface labels.**

  Define the four labels specified in Task 1 in both language files.

### Task 3: Static markup and CSS review

**Files:**
- Review: all ten files created in Tasks 1–2.

**Interfaces:**
- Consumes: complete `ladybug` and `fireant` template directories.
- Produces: an itemized review of malformed PHP/HTML, unscoped selectors, responsive or accessibility gaps, and deviations from the data contract.

- [ ] **Step 1: Ask a subagent to inspect the two variants without changing files.**

  The review must compare the code with `smoothness` and `layering`, specifically checking output escaping, localized strings, gallery hooks, mobile breakpoints, motion handling, and selector isolation.

- [ ] **Step 2: Address actionable review findings in the affected template files.**

  Apply only fixes that preserve the agreed visual direction and existing Bitrix data contract.

- [ ] **Step 3: Inspect the final file tree and report the created templates.**

  Do not run automated tests or Git commands.
