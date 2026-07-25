# Vacancy News Templates Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add `vacancies.1` and `vacancies.2` `bitrix:news` templates to `sporina.easysite` with the source layouts reproduced through native Sporina code.

**Architecture:** Each target is a self-contained `bitrix:news` template that orchestrates standard `bitrix:news.list`, `bitrix:news.detail`, and, for `vacancies.2`, `bitrix:menu`. Nested list templates own presentation; parent files only validate and forward component parameters. No Intec library, namespace, CSS selector, or form integration is retained.

**Tech Stack:** PHP for 1C-Bitrix component templates; CSS; Bitrix template localization and component APIs.

## Global Constraints

- Do not run Git commands or create commits.
- Do not run project test suites or add automated tests.
- Preserve the source layouts and visible behaviour exactly for the paired template.
- Use only `sporina-*` names for new CSS/JS selectors; do not depend on `intec.core`, `intec\\core`, `ns-bitrix`, or `intec-*`.
- Exclude every form submission, form parameter, mail-event, consent, CAPTCHA and AJAX submission integration.
- Validate `NEWS_LIST_TEMPLATE` against an explicit allow-list and fall back to the default template.

---

### Task 1: Build the `vacancies.1` native template

**Files:**
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/.parameters.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/news.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/detail.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/bitrix/news.list/default/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/bitrix/news.list/default/style.css`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/bitrix/news.detail/default/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/bitrix/news.detail/default/style.css`

**Interfaces:**
- Consumes: standard `bitrix:news` `$arParams`, `$arResult`, `$APPLICATION` and `$component`.
- Produces: a list/detail view driven by standard Bitrix components and `NEWS_LIST_TEMPLATE`.

- [ ] **Step 1: Inspect the paired source template and target conventions**

Read all files from `intec.prom/.../news/vacancies/` and the target's existing
`sporina-column-news-company` parent and nested list templates. Record the
source DOM structure, fields and CSS rules to reproduce.

- [ ] **Step 2: Define native parent-template parameters and routing**

Create `.parameters.php`, `news.php` and `detail.php` using only the native
Bitrix component API. `news.php` must select the nested list template by
`NEWS_LIST_TEMPLATE` using an allow-list; both parent files forward standard
news/list/detail parameters and generated URL templates.

- [ ] **Step 3: Implement the nested list and detail presentation**

Create focused `bitrix:news.list` and `bitrix:news.detail` templates plus their
styles. Reproduce the source `vacancies` layout and behaviours using
`sporina-vacancies-*` selectors and Bitrix edit-area APIs.

- [ ] **Step 4: Perform static validation**

Run PHP syntax checks on every PHP file in `vacancies.1`. Search the directory
for forbidden Intec and form-integration identifiers. Expected result: each
file reports no syntax errors and the forbidden-identifier search has no
matches.

### Task 2: Build the `vacancies.2` native template

**Files:**
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/.parameters.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/news.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/detail.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/bitrix/menu/default/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/bitrix/news.list/default/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/bitrix/news.list/default/style.css`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/bitrix/news.detail/default/template.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/bitrix/news.detail/default/style.css`

**Interfaces:**
- Consumes: standard `bitrix:news` parameters plus `LIST_MENU_SHOW` and `DETAIL_MENU_SHOW`.
- Produces: native list/detail views that conditionally render the section menu and use `NEWS_LIST_TEMPLATE` safely.

- [ ] **Step 1: Inspect the paired source template and target menu patterns**

Read `intec.prom/.../news/vacancies.1/` and established Sporina menu/list
templates. Identify the exact source layout for the menu, content column,
cards and detail page.

- [ ] **Step 2: Implement parent routing and conditional menu integration**

Create `.parameters.php`, `news.php`, `detail.php` and the nested menu
template. Use `bitrix:menu` only when the corresponding standard display
parameter is enabled and render no menu wrapper when it has no items.

- [ ] **Step 3: Implement the nested list/detail views and styles**

Create the native nested templates and CSS that reproduce the paired
`vacancies.1` source design. Keep every selector within the `sporina-`
namespace and forward only non-form component data.

- [ ] **Step 4: Perform static validation**

Run PHP syntax checks on every PHP file in `vacancies.2`. Search both target
directories for forbidden Intec and form-integration identifiers. Expected
result: all files parse and the search has no forbidden matches.

### Task 3: Verify component contracts and hand off

**Files:**
- Verify: both template directories created in Tasks 1–2.

**Interfaces:**
- Consumes: completed target templates.
- Produces: a checked implementation ready for manual visual validation in a Bitrix installation.

- [ ] **Step 1: Verify component wiring**

Inspect both `news.php` files to confirm `NEWS_LIST_TEMPLATE` validation,
`bitrix:news.list` inclusion and URL forwarding. Inspect both `detail.php`
files to confirm `bitrix:news.detail` inclusion and no form component call.

- [ ] **Step 2: Verify scope boundaries**

Compare target source trees against their paired Intec trees: visual assets and
layout rules must be present; all Intec runtime dependencies and form-related
code must be absent.

- [ ] **Step 3: Report manual validation requirement**

Report that final pixel-level validation requires rendering the templates in a
configured Bitrix installation with representative vacancies and sections;
this is not executed because no running installation was supplied.
