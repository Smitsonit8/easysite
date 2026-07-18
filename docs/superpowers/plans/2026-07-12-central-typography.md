# Central Typography Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Move site and component typography to `style/typography.css` while retaining visual roles and excluding system settings and third-party assets.

**Architecture:** `typography.css` owns semantic typography tokens. Site and component CSS consume those tokens instead of declaring numeric font sizes, line heights or weights. The site header loads the typography stylesheet after its base stylesheet.

**Tech Stack:** CSS custom properties, Bitrix site template assets.

## Global Constraints

- Do not edit `install/components/sporina/system.settings/**`.
- Do not edit `dist/assets/**`, `*.min.css`, or backup files with the `_` suffix.
- Do not create or run automated tests, PHP linting or CSS linting.
- Do not use Git commands or create commits.

---

### Task 1: Expose shared typography to the full site

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/typography.css`

**Interfaces:**
- Produces: semantic CSS variables for all reused text roles.

- [ ] Load `style/typography.css` immediately after `style/style.css` in the template header.
- [ ] Add semantic component tokens only for roles present in component source CSS, for example header metadata, navigation text, card metadata, card title, card body and form labels.
- [ ] Keep `typography.css` as the sole location for numeric typography values introduced by this refactor.

### Task 2: Replace site-template typography literals

**Files:**
- Modify: source CSS under `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/`, excluding `style_.css`.
- Modify: `template_styles.css`, `styles.css` and other non-vendor root CSS only when they contain typography literals.

**Interfaces:**
- Consumes: tokens from `style/typography.css`.
- Produces: site CSS without numeric `font-size`, `line-height` or `font-weight` declarations.

- [ ] Replace each typography declaration with the semantic token matching its existing visual role.
- [ ] Preserve selectors, responsive breakpoints, spacing, dimensions and colors.

### Task 3: Replace component-template typography literals

**Files:**
- Modify: non-vendor, non-minified source CSS below `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/`.
- Exclude: `components/sporina/system.settings/**`, `*.min.css`, files ending in `_`, and third-party nested component assets such as `bitrix/iblock.vote/ajax`.

**Interfaces:**
- Consumes: tokens from `style/typography.css`.
- Produces: component styles sharing the same font-size, line-height and weight scale as the site template.

- [ ] Replace typography literals in banner, header, footer, cards, news and form source styles.
- [ ] Add a semantic token before replacing a value that does not match an existing role.

### Task 4: Static handoff review

**Files:**
- Inspect: all modified CSS and `header.php`.

- [ ] Confirm `typography.css` is loaded after the base template stylesheet.
- [ ] Confirm no excluded path was modified.
- [ ] Search the in-scope CSS for remaining numeric `font-size`, `line-height` and `font-weight` declarations; allow only typography-token definitions in `typography.css`.
- [ ] Do not run tests or linting.
