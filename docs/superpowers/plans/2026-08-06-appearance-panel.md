# Appearance Panel Implementation Plan

> **For agentic workers:** Execute the tasks in order and keep the existing, unrelated working-tree changes intact. The user explicitly requested no Git operations and no test runs.

**Goal:** Make the Appearance settings show selectable theme swatches and the active width, and add a safe upload/reset workflow for the site logo.

**Architecture:** Extend the declarative settings catalogue with presentation metadata and a site-scoped logo file ID. The settings component renders specialized controls, sends multipart form data through its existing authenticated endpoint, and delegates persistence/file lifecycle to `Settings`; the header and `include/logo.php` consume the same resolved logo URL.

**Tech Stack:** PHP/Bitrix (`Option`, `CFile`, session validation); HTML/CSS/vanilla JavaScript; existing `sporina:system.settings` component.

## Global Constraints

- Do not use Git commands or run automated tests.
- Theme values remain the current keys: `blue`, `green`, `orange`, `yellow`, `red`, and `grey`.
- The width control must display the exact saved site-scoped value: `1200`, `1440`, or `1920`.
- Logo uploads accept JPEG, PNG, WebP, and SVG only; a reset deletes the custom file and restores `img/logo.svg`.
- Only the existing administrator/session-protected settings endpoint may upload or reset a logo.

---

### Task 1: Render theme swatches and preserve current width selection

**Files:**
- Modify: `lib/settings.php:31-38`
- Modify: `install/components/sporina/system.settings/templates/.default/template.php:60-105`
- Modify: `install/components/sporina/system.settings/templates/.default/style.css:110-160`

**Interfaces:**
- Consumes: `Settings::getPanel()` field records with `key`, `value`, and `values`.
- Produces: a `theme-swatch` field with `swatches[value] = CSS colour`; a standard `template-width` select whose selected option compares to `$field['value']`.

- [ ] **Step 1: Add theme colour metadata to the catalogue**

  Add `presentation => 'theme-swatch'` and a `swatches` map to the existing
  `template-color-theme` definition. Use the primary colours below so the
  panel accurately represents the corresponding theme:

  ```php
  'presentation' => 'theme-swatch',
  'swatches' => [
      'blue' => '#0d20ad', 'green' => '#16803b', 'orange' => '#d66800',
      'yellow' => '#d69e00', 'red' => '#c53030', 'grey' => '#505050',
  ],
  ```

  Leave the `values` map unchanged: it remains the validation allowlist and
  supplies each swatch's accessible name.

- [ ] **Step 2: Add a radio-card renderer for `theme-swatch`**

  In `template.php`, insert a branch before the generic `<select>` branch:

  ```php
  <?php elseif (($field['presentation'] ?? '') === 'theme-swatch'): ?>
    <span class="system-settings-theme-swatches" role="radiogroup" aria-label="<?=htmlspecialcharsbx($field['label'])?>">
      <?php foreach ($field['values'] as $value => $label): ?>
        <label class="system-settings-theme-swatch" title="<?=htmlspecialcharsbx($label)?>">
          <input type="radio" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="<?=htmlspecialcharsbx($value)?>"<?= $value === $field['value'] ? ' checked' : '' ?>>
          <span style="--theme-swatch-color: <?=htmlspecialcharsbx($field['swatches'][$value])?>" aria-hidden="true"></span>
          <span class="visually-hidden"><?=htmlspecialcharsbx($label)?></span>
        </label>
      <?php endforeach; ?>
    </span>
  ```

  Continue rendering `template-width` through the existing select branch.
  Its `selected` attribute must remain exactly `$value === $field['value']`;
  do not add a client-side default or a hard-coded `1200` value.

- [ ] **Step 3: Style the swatches with selection and keyboard focus states**

  Add CSS for a wrapping flex row, 32×32px square colour tiles, a 2px visible
  selected outline, and a separate `:focus-visible` outline on the hidden
  radio's adjacent visible tile. Use `var(--theme-swatch-color)` only as the
  tile fill so colours come from the catalogue metadata.

- [ ] **Step 4: Manually verify the controls**

  Open «Оформление» as an administrator. Confirm that six coloured squares
  appear, the saved theme has the selected state, a click selects another
  theme, and reopening the panel keeps it selected. Save each width in turn
  and confirm the select shows that same saved value after page reload.

### Task 2: Add site-scoped logo persistence and protected upload/reset actions

**Files:**
- Modify: `lib/settings.php:31-38, 160-235, 415-445`
- Modify: `install/components/sporina/system.settings/class.php:53-94`

**Interfaces:**
- Consumes: POST field `settings[template-logo]` and `$_FILES['settings']` from the existing settings form.
- Produces: `Settings::getLogoUrl(): string`, returning a user logo URL or the fallback `SITE_TEMPLATE_PATH . '/img/logo.svg'`.
- Produces: `Settings::saveLogo(array $file): void` and `Settings::resetLogo(): void` for administrator-authenticated component actions.

- [ ] **Step 1: Define the logo setting and its default**

  Add a `template-logo` catalogue definition in the `template` category with
  `type => 'file'`, `default => ''`, and a label «Логотип». Do not route this
  value through the generic `normalize()` method: it is a Bitrix file ID whose
  lifecycle is handled by dedicated methods.

- [ ] **Step 2: Implement file-ID reading and URL resolution in `Settings`**

  Add `getLogoUrl()` that reads the `template-logo` option for `SITE_ID`, casts
  it to a positive integer, obtains its record with `CFile::GetFileArray()`,
  and returns its `SRC` only when it exists. In every other case return:

  ```php
  SITE_TEMPLATE_PATH . '/img/logo.svg'
  ```

- [ ] **Step 3: Implement upload validation and replacement**

  Add `saveLogo(array $file)`. Reject empty uploads, upload errors, files
  larger than 5 MiB, and any extension other than `jpg`, `jpeg`, `png`,
  `webp`, or `svg`. For raster formats, require `getimagesize($file['tmp_name'])`
  to return image dimensions. For SVG, require its contents to begin with an
  SVG root element and reject any content containing `<script`, `onload=`, or
  `javascript:`. Then set `$file['MODULE_ID'] = 'sporina.easysite'`, call
  `CFile::SaveFile($file, 'sporina.easysite/logos')`, store the returned ID
  with `Option::set(..., SITE_ID)`, and delete the previous file ID with
  `CFile::Delete()` only after the new ID has been stored successfully.

- [ ] **Step 4: Implement default-logo restoration**

  Add `resetLogo()`. Read the old file ID, delete it with `CFile::Delete()`
  when positive, then delete the `template-logo` option for the current site
  with `Option::delete()`. The next `getLogoUrl()` call must therefore return
  the standard SVG path.

- [ ] **Step 5: Extend the component action router**

  Add `upload-logo` and `reset-logo` cases to `processAction()`. In
  `upload-logo`, get the `template-logo` entry from
  `Context::getCurrent()->getRequest()->getFile('settings')`, validate that it
  is an array, then call `Settings::saveLogo($file)`. In `reset-logo`, call
  `Settings::resetLogo()`. Return JSON containing `success: true` and
  `logoUrl: Settings::getLogoUrl()` for either action. Reuse the existing
  admin and `check_bitrix_sessid()` gates before the switch.

- [ ] **Step 6: Manually verify upload and reset behavior**

  Upload valid JPEG, PNG, WebP, and SVG logos smaller than 5 MiB; confirm the
  API returns success. Attempt a non-image, an oversized file, and an SVG
  containing `<script>`; confirm each returns a validation error. Upload a
  second valid logo and confirm it replaces the first. Use reset and confirm
  the saved file ID is cleared and `getLogoUrl()` falls back to `img/logo.svg`.

### Task 3: Add the logo panel control and render the resolved logo in the site

**Files:**
- Modify: `install/components/sporina/system.settings/templates/.default/template.php:60-105`
- Modify: `install/components/sporina/system.settings/templates/.default/script.js:1-80`
- Modify: `install/components/sporina/system.settings/templates/.default/style.css:110-160`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header.php:20-40, 123-132`
- Modify: `install/wizards/sporina/easy_site/site/public/ru/include/logo.php:1`

**Interfaces:**
- Consumes: `Settings::getLogoUrl(): string` from Task 2 and JSON `{success, logoUrl}` from `upload-logo` / `reset-logo`.
- Produces: a file chooser with preview/reset controls and identical logo URLs in the header component and `include/logo.php`.

- [ ] **Step 1: Render the file control with current-logo preview**

  In the panel template, add a dedicated `file` branch that renders a preview
  image using `$field['logoUrl']`, a file input named `settings[template-logo]`
  with `accept="image/jpeg,image/png,image/webp,image/svg+xml"`, and a
  `type="button"` reset control with `data-role="logo.reset"`. Set
  `enctype="multipart/form-data"` on the form. Make `Settings::getPanel()`
  populate the logo field with `logoUrl => self::getLogoUrl()`.

- [ ] **Step 2: Add preview, upload, and reset handling in JavaScript**

  On file-input change, display the selected image locally with
  `URL.createObjectURL()`. On normal form submit, retain the untouched-field
  deletion logic but do not delete a chosen file input; the multipart
  `FormData` will carry the upload to the `apply` request. If the file is
  selected, send `upload-logo` first; after a successful response replace the
  preview `src` with `response.logoUrl`, then submit the remaining dirty
  non-file fields using `apply`. On reset button click, POST the existing
  session field and action `reset-logo`, update the preview from
  `response.logoUrl`, and clear the file input.

- [ ] **Step 3: Style the logo control**

  Add a compact flex layout with a 160×64px preview area, `object-fit: contain`,
  a visible «Загрузить файл» control, and a secondary «Вернуть стандартный»
  button. Keep the control usable below the existing 640px breakpoint by
  stacking its elements vertically.

- [ ] **Step 4: Use the shared URL in the header and include file**

  In the site template header, compute `$logoSrc =
  \Sporina\EasySite\Settings::getLogoUrl()` and replace the hard-coded
  `"LOGO_SRC" => "img/logo.svg"` parameter with `"LOGO_SRC" => $logoSrc`.
  In `site/public/ru/include/logo.php`, load the module when available, use
  `Settings::getLogoUrl()` for the image `src`, and fall back to
  `SITE_TEMPLATE_PATH . '/img/logo.svg'` when it is unavailable. Escape the
  final URL with `htmlspecialcharsbx()`.

- [ ] **Step 5: Manually verify the complete user flow**

  Upload a logo from «Оформление», reload the page, and confirm the panel
  preview, the `<img>` rendered by `include/logo.php`, and the header display
  the same file. Click «Вернуть стандартный», reload again, and confirm all
  three use the standard SVG.
