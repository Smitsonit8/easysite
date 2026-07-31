# Component Typography Adaptation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Bring each active component template under the shared `typography.css` scale, one template at a time, without altering Bitrix behavior.

**Architecture:** `style/typography.css` remains the sole provider of responsive type tokens. Each component stylesheet selects existing semantic tokens for its content role; markup changes are limited to safe semantic corrections and retain all Bitrix hooks. Every template is independently checked and explicitly presented to the user before continuing.

**Tech Stack:** PHP/1C-Bitrix component templates, CSS custom properties, PowerShell, PHP CLI, ripgrep.

## Global Constraints

- Work in the current checkout; do not overwrite existing uncommitted changes in `style/typography.css` or `style/typography_.css`.
- Do not modify Bitrix core, PHP logic, `$arParams`, `$arResult`, component caching, JavaScript, layout, colours, or CSS class names.
- `typography.css` is the shared source of typography variables and responsive scale.
- Do not add an `h1` on internal pages; the page banner already provides it.
- For every stylesheet, replace a declaration only after identifying its UI role; keep justified fixed values in the report.
- Stop after every single template for user review.

---

### Task 1: Inventory and establish a repeatable template acceptance gate

**Files:**
- Modify: `docs/superpowers/plans/2026-07-31-component-typography.md`
- Inspect: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/**/*.css`

**Interfaces:**
- Consumes: typography tokens defined in `style/typography.css`.
- Produces: an ordered queue of active component stylesheets with a baseline count of fixed typography declarations.

- [ ] **Step 1: Capture the baseline inventory**

Run:

```powershell
rg -l --glob '*.{css,php}' 'font-(size|weight)\s*:|line-height\s*:' install/wizards/sporina/easy_site/site/templates/sporina_easy_site
```

- [ ] **Step 2: Exclude obsolete and vendor copies from edits**

Treat `dist/`, `style-old.css`, `style_.css`, `typography_.css`, and minified duplicate files as read-only unless the active template explicitly loads them.

- [ ] **Step 3: Define the per-template validation commands**

Run after each stylesheet change:

```powershell
rg -n 'font-size\s*:\s*[0-9.]+(px|rem|em)|line-height\s*:\s*[0-9.]+(px|rem|em)?|font-(size|weight).*!important|line-height.*!important' <changed-template-directory>
git diff --check -- <changed-files>
```

Run `php -l <template.php>` when a PHP template changes.

- [ ] **Step 4: Present the reviewed template to the user**

Report the selector-to-token mapping, commands run, any retained fixed values, and the target page/viewport widths for visual approval. Do not start the next template before approval.

### Task 2: Adapt shared shell templates one at a time

**Files:**
- Modify only as needed: `components/sporina/banner/templates/*/style.css`, `components/sporina/header/templates/*/style.css`, `components/sporina/footer/templates/*/style.css`, `components/sporina/contacts/templates/.default/style.css`, and active top/left menu styles.

**Interfaces:**
- Consumes: `--font-size-hero`, banner compatibility tokens, `--font-size-header-meta`, `--font-size-navigation`, `--font-size-footer-contact`, `--font-size-sm`, `--font-size-form-label`, `--font-size-button`, and matching line-height/weight tokens.
- Produces: shell styles that contain no unjustified fixed typography values.

- [ ] **Step 1: Select exactly one active shell stylesheet**

Read its CSS and paired `template.php`; identify whether it is actually included by the corresponding component template.

- [ ] **Step 2: Write the expected selector mapping before editing**

Example: contact meta → `--font-size-header-meta`; navigation link → `--font-size-navigation`; button label → `--font-size-button` and `--line-height-button`.

- [ ] **Step 3: Apply the smallest CSS-only change**

Replace only typography declarations whose semantic token exists in `typography.css`. Preserve unrelated declarations in the selector.

- [ ] **Step 4: Run the per-template validation commands**

Confirm fixed values are eliminated or record why each remaining value is necessary.

- [ ] **Step 5: Request user review**

Provide changed files, mappings, remaining exceptions, and suggested responsive viewports; wait for approval.

### Task 3: Adapt service and product component templates one at a time

**Files:**
- Modify only as needed: active styles under `components/bitrix/news/sporina-uslugi-cards/`, `components/bitrix/news/sporina-uslugi-cards-hover/`, and `components/bitrix/news/sporina-tovari-cards/`.

**Interfaces:**
- Consumes: card title/body/meta/featured/title-tile tokens and their line-height and weight counterparts.
- Produces: service and product cards/details that use shared typography while preserving card markup and responsive layout.

- [ ] **Step 1: Select one active list or detail stylesheet and read its paired PHP template**

Verify the CSS file is loaded and identify title, body, metadata, price, and button selectors.

- [ ] **Step 2: Define and apply the role mapping**

Use `--font-size-card-title`, `--font-size-card-featured-title`, `--font-size-card-tile-title`, `--font-size-card-body`, `--font-size-card-meta`, `--font-size-button`, and matching line-height/weight tokens as applicable.

- [ ] **Step 3: Check heading semantics without adding an `h1`**

Only change a heading tag when the paired template proves it is ordinary text and all Bitrix edit-area identifiers remain unchanged.

- [ ] **Step 4: Validate and pause for user review**

Run Task 1 validation, PHP lint if relevant, report retained fixed values, and wait for explicit user approval.

### Task 4: Adapt news, schedule, staff, vacancies, contacts, and search templates one at a time

**Files:**
- Modify only as needed: active styles under `components/bitrix/news/`, `components/bitrix/search.page/`, `components/bitrix/main.share/`, and `components/sporina/contacts/`.

**Interfaces:**
- Consumes: generic heading/base/meta/button tokens plus existing news compatibility tokens from `typography.css`.
- Produces: content templates free of unjustified local typography scale.

- [ ] **Step 1: Select one active stylesheet and its paired PHP template**

Classify visible text as section heading, card title, body, metadata, button/link, or form field.

- [ ] **Step 2: Make the smallest semantic token substitution**

Use the corresponding generic or news compatibility token already defined by `typography.css`; do not introduce a new per-component variable or `clamp()`.

- [ ] **Step 3: Collapse only redundant typography media rules**

Remove a media override only when the base shared variable supplies the intended responsive behavior and no layout-specific constraint remains.

- [ ] **Step 4: Validate and pause for user review**

Run Task 1 validation, PHP lint if relevant, and wait for approval before selecting another template.

### Task 5: Final audit and report

**Files:**
- Inspect: all active files under `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/`
- Modify: `docs/superpowers/plans/2026-07-31-component-typography.md` only to mark completed tasks.

**Interfaces:**
- Consumes: all approved per-template changes.
- Produces: a complete audit report with fixed-value exceptions and manual visual-test risks.

- [ ] **Step 1: Re-run repository-wide typography searches**

```powershell
rg -n 'font-size\s*:\s*[0-9.]+(px|rem|em)' install/wizards/sporina/easy_site/site/templates/sporina_easy_site
rg -n 'line-height\s*:\s*[0-9.]+(px|rem|em)?' install/wizards/sporina/easy_site/site/templates/sporina_easy_site
rg -n 'font-(size|weight).*important|line-height.*important' install/wizards/sporina/easy_site/site/templates/sporina_easy_site
```

- [ ] **Step 2: Lint all changed PHP files**

```powershell
git diff --name-only -- '*.php' | ForEach-Object { php -l $_ }
```

- [ ] **Step 3: Deliver the final report**

List modified files, remaining fixed sizes and their rationale, semantic corrections, approved template/page checks, widths to verify (1440, 1200, 992, 768, 576, 375, 320), and any residual visual risks.
