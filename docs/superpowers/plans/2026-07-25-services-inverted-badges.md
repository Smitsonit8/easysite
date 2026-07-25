# Services inverted badges Implementation Plan

> **For agentic workers:** Execute inline in the current workspace. Do not run Git commands or automated tests at the user's request.

**Goal:** Add configurable section badges and polished card interactions to the `sporina_services_inverted` list template.

**Architecture:** `result_modifier.php` resolves section names once for all list items. Template parameters control whether a badge renders and which top corner it occupies. The template outputs the badge and inline reusable arrow; CSS and JavaScript provide visual behavior.

**Tech Stack:** Bitrix PHP templates, Bitrix `CIBlockSection`, CSS custom properties, vanilla JavaScript.

## Global Constraints

- Do not run Git commands or automated tests.
- Preserve unrelated working-tree changes.
- Use theme variables instead of literal brand colors.

---

### Task 1: Resolve section names and expose settings

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-uslugi-cards/result_modifier.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-uslugi-cards/bitrix/news.list/sporina_services_inverted/.parameters.php`

- [ ] Normalize `SHOW_SECTION_BADGE` and `SECTION_BADGE_POSITION` values.
- [ ] Collect section IDs from `$arResult['ITEMS']`, load their names with `CIBlockSection::GetList`, and add `SECTION_NAME` to each item.
- [ ] Register the show/hide and left/right template settings.

### Task 2: Render the badge and project arrow

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-uslugi-cards/bitrix/news.list/sporina_services_inverted/template.php`

- [ ] Remove the path-based arrow image.
- [ ] Render the section badge only when enabled and available.
- [ ] Render the reusable inline up-right arrow, controlled through `currentColor`.

### Task 3: Style interactions and accessibility behavior

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-uslugi-cards/bitrix/news.list/sporina_services_inverted/style.css`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-uslugi-cards/bitrix/news.list/sporina_services_inverted/script.js`

- [ ] Replace literal palette values with theme-variable fallbacks.
- [ ] Add positioned, animated and ellipsized badge styles.
- [ ] Keep sequential reveal and make it safe for repeated Bitrix AJAX initialization.
- [ ] Preserve hover image enlargement and honor `prefers-reduced-motion`.
