# Typography Panel Design

## Goal

Give site administrators two independent typography controls: body text size and heading size. The controls drive the existing central typography scale without changing already adapted component templates.

## Settings catalogue and storage

`Sporina\EasySite\Settings` remains the single catalogue for settings, validation, persistence, reset and panel rendering.

- Add the `typography` category titled `Типографика`.
- Add `typography-text-size` as a `select` with `small`, `medium`, and `large`; default `medium`.
- Add `typography-heading-size` as a `select` with `small`, `medium`, and `large`; default `medium`.
- Remove the non-working `template-headings-size` definition. It will no longer appear in the panel or participate in appearance calculation.
- Missing, invalid, and pre-existing installations without the new options resolve to each setting's declared default, `medium`.

## Page application

The template header receives the validated settings from `Settings::getAll()` and prints them on the root HTML element:

```html
<html lang="ru" data-text-size="medium" data-heading-size="medium">
```

The previous `--site-heading-scale` inline style and its `getAppearance()` output are removed. The current settings panel deliberately reloads after a successful save or reset, so no separate live-preview JavaScript is added.

## CSS scale

`style/typography.css` is the only typography implementation point.

- `--typography-text-base` maps `small`, `medium`, and `large` to `15px`, `16px`, and `18px`.
- `--typography-heading-scale` maps them to `0.9`, `1`, and `1.12`.
- Text tokens (`--font-size-xs` through `--font-size-lg`) derive from `--typography-text-base`.
- Heading tokens (`--font-size-h6` through `--font-size-h1` and `--font-size-hero`) derive from fixed base values multiplied by `--typography-heading-scale`.
- Existing semantic aliases remain defined and continue to point at the central tokens.
- `h1` through `h4` and banner titles retain responsive `clamp()` calculations; form fields retain `max(1rem, var(--font-size-sm))`.

No component-template PHP, business rules, content queries, or markup structure is changed.

## Testing

Extend the Node static tests to assert the exact keys, defaults, allowed values, removal of the legacy key, data attributes in the header, and central CSS rules. Run the Node tests and PHP syntax checks for changed PHP files. Manual browser checking remains required for the prescribed 3×3 setting matrix and responsive widths when a Bitrix runtime is available.
