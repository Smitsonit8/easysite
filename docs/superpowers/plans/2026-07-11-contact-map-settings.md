# Contact Map Settings Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add contact-map settings to the central site-settings panel while preserving component parameters as fallbacks.

**Architecture:** The `Settings` catalogue declares, validates and renders the five map fields. It also exposes whether an individual value has been saved in module options. The contacts page uses its component-call parameter unless an explicit site setting exists for that same field.

**Tech Stack:** PHP, Bitrix D7 `Option`, Bitrix component parameters.

## Global Constraints

- Do not create or run automated tests.
- Do not use Git commands or create commits.
- Add map settings only in `Sporina\EasySite\Settings::DEFINITIONS`.

---

### Task 1: Extend the settings catalogue and input renderer

**Files:**
- Modify: `lib/settings.php`
- Modify: `install/components/sporina/system.settings/templates/.default/template.php`

**Interfaces:**
- Produces: `Settings::hasStoredValue(string $key): bool`.
- Produces: support for `text`, `number`, `latitude`, and `longitude` field types in settings normalization and the generic form.

- [ ] Add the `contacts` category with these definitions and defaults:

```php
['key' => 'contacts-map-use', 'type' => 'checkbox', 'default' => 'Y'],
['key' => 'contacts-map-lat', 'type' => 'latitude', 'default' => '51.533338'],
['key' => 'contacts-map-lon', 'type' => 'longitude', 'default' => '46.034176'],
['key' => 'contacts-map-title', 'type' => 'text', 'default' => 'Местоположение офиса'],
['key' => 'contacts-map-height', 'type' => 'number', 'default' => '420'],
```

- [ ] Implement normalization: latitude is decimal from `-90` to `90`, longitude is decimal from `-180` to `180`, height is a positive integer, title is a trimmed non-empty string no longer than 255 characters.

- [ ] Add `hasStoredValue()` using a private, non-empty sentinel default supplied to `Option::get()`. It returns `true` only when the module option exists for the current site.

- [ ] Render `latitude`, `longitude`, and `number` as numeric inputs; render `text` as a text input. Retain the generic checkbox, color and select rendering.

### Task 2: Use central values only when explicitly saved

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/public/ru/contacts/index.php`

**Interfaces:**
- Consumes: `Settings::hasStoredValue()` and `$GLOBALS['SPORINA_EASY_SITE_SETTINGS']`.
- Produces: `sporina:contacts` receives central values only for options saved in the site-settings panel.

- [ ] Before the `IncludeComponent` call, load `Sporina\EasySite\Settings` only when the module is available and prepare a small resolver closure:

```php
$mapSetting = static function (string $settingKey, string $componentDefault) use ($sporinaSettings): string {
    if (Settings::hasStoredValue($settingKey)) {
        return (string) $sporinaSettings[$settingKey];
    }

    return $componentDefault;
};
```

- [ ] Replace only `SHOW_MAP`, `YANDEX_MAP_LAT`, `YANDEX_MAP_LON`, `MAP_TITLE`, and `MAP_HEIGHT` literals in the component call with the resolver values.

- [ ] Keep all other `sporina:contacts` parameters untouched so they remain editable by the Bitrix component-parameter editor.

### Task 3: Re-enable the configuration component edit icon

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php`

**Interfaces:**
- Produces: Bitrix visual editing icon for the `MODE => configure` instance only.

- [ ] Remove the fifth `IncludeComponent` argument containing `HIDE_ICONS => Y` from the `sporina:system.settings` call with `MODE => configure`.

- [ ] Keep `HIDE_ICONS => Y` on the `MODE => render` instance because it is a non-visual service call.

### Task 4: Static handoff review

**Files:**
- Inspect: `lib/settings.php`
- Inspect: `install/components/sporina/system.settings/templates/.default/template.php`
- Inspect: `install/wizards/sporina/easy_site/site/public/ru/contacts/index.php`
- Inspect: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php`

- [ ] Confirm every declared map key is consumed by the contacts page.
- [ ] Confirm every new form type has a matching normalization rule.
- [ ] Confirm only the configure instance exposes editing icons.
- [ ] Do not run tests or PHP linting, per the project instruction.
