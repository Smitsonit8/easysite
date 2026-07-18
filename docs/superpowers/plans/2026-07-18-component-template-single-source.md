# Component Template Single Source Implementation Plan

> **For agentic workers:** Execute inline with review checkpoints. Do not run tests, linters or Git commands unless the user explicitly asks.

**Goal:** Make direct Bitrix component template editing and the site settings panel operate on the same source value for every template setting exposed in the panel.

**Architecture:** Each template definition declares its source file, marker and component parameter in `Settings::DEFINITIONS`. The settings service reads that marked parameter for panel display and rewrites only its value on Apply or Reset. Page and template sources use literal component-template values inside markers, rather than runtime module-option overrides.

**Tech Stack:** Bitrix PHP components, module options, PHP file read/write with `LOCK_EX`.

## Global Constraints

- Do not edit `install/components/sporina/system.settings/**` except the existing action adapter when it must return a source-write error.
- Do not edit vendor/minified assets or `system.settings` styles.
- Do not run tests, PHP linting, CSS linting or Git commands.

---

### Task 1: Generalize source bindings

**Files:**

- Modify: `lib/settings.php`

**Interfaces:**

- Every bound setting uses `sourceBinding: ['scope' => 'site'|'template', 'file' => '<relative file>', 'marker' => '<marker>', 'parameter' => 'COMPONENT_TEMPLATE'|'NEWS_LIST_TEMPLATE']`.
- `getPanel()` resolves a binding before an option value.
- `apply()` and `reset()` write only the marked parameter value.

- [ ] Add bindings for `header-template`, `footer-template`, `pages-main-banner-template`, `pages-main-infocards-template`, `pages-main-articles-template`, `pages-main-news-template`, `pages-main-advertising-template` and `pages-main-current-news-template`.
- [ ] Replace the index-only reader with a resolver for `SITE_DIR` page files and `SITE_TEMPLATE_PATH` template files.
- [ ] Match a marker plus its declared parameter, validate the source value through the existing definition, and update only that parameter with an exclusive lock.
- [ ] Keep module options as panel persistence, but never let them override a marked component parameter at render time.

### Task 2: Mark every exposed component-template parameter

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/footer.php`
- Modify: `install/wizards/sporina/easy_site/site/public/ru/index_inc.php`
- Modify: `install/wizards/sporina/easy_site/site/public/ru/_index.php`

**Interfaces:**

- Each configured component has a `SPORINA:EASYSITE:<MARKER>` comment immediately before a literal `COMPONENT_TEMPLATE` or `NEWS_LIST_TEMPLATE` value.

- [ ] Replace module-option derived header and footer template values with marked literals.
- [ ] Replace module-option derived banner, infocard, advertising and current-news template values with marked literals.
- [ ] Retain the already marked article/news column list parameters.
- [ ] Keep non-template settings and component data unchanged.

### Task 3: Static handoff review

**Files:**

- Inspect: files from Tasks 1–2.

- [ ] Confirm every panel template definition has exactly one matching source binding.
- [ ] Confirm every binding marker exists in its declared wizard source file.
- [ ] Confirm no template setting remains dynamically read from `$sporinaSettings` in the affected component invocation.
- [ ] Do not run tests or linting.
