# Component Typography Adaptation Design

## Goal

Adapt all current site-template component styles to the shared typography system in `typography.css`, while preserving Bitrix component behavior and the current visual layout.

## Scope

- Inspect `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/` and all nested component templates.
- Replace local fixed `font-size`, `line-height`, and `font-weight` declarations with the semantic variables already defined in `style/typography.css` where the element role permits it.
- Review component markup only to correct clearly incorrect typography semantics. Do not add a second `h1` to internal pages; their banner already owns the page `h1`.
- Preserve PHP logic, Bitrix edit-area hooks, parameters, markup structure, grids, colours, effects, and JavaScript.

## Design

Each typography declaration will be classified by its UI role before editing:

- Body copy inherits the shared base scale where possible; explicit values use `--font-size-base` and `--line-height-body` only when needed.
- Cards, banners, controls, navigation, forms, and footer content use their corresponding existing component variables.
- Heading-like non-heading elements use the appropriate heading variables without changing the document outline unless a semantic correction is safe.
- Fixed typography values remain only when a component has a documented layout constraint that the shared scale cannot express. Such exceptions will be listed in the completion report.

Local media-query typography overrides will be removed or consolidated only when the shared responsive variables make them redundant. No per-component `clamp()` values or one-off custom variables will be introduced.

## Validation

- Build an inventory of typography declarations in every component CSS source, including CSS embedded in PHP and inline styles.
- Re-run repository searches for fixed sizes, fixed line heights, and typography `!important` usage after edits.
- Run `php -l` on every changed PHP template.
- Run existing project CSS validation if it is available; no new tooling dependencies will be added.
- Manually inspect changed selectors and identify pages/components that still need browser-based review at the required responsive widths.

## Constraints

- `typography.css` is the sole shared source of typography scale and responsive `clamp()` values.
- Existing uncommitted files, including `typography.css`, are user work and must not be overwritten or reverted.
- No Bitrix core files will be changed.
- The work is intentionally limited to typography and safe semantic corrections.
