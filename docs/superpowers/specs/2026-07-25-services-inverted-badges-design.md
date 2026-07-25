# Services inverted: section badges and motion

## Scope

Update the `sporina_services_inverted` `bitrix:news.list` template used by
`sporina-uslugi-cards`.

## Data flow

`result_modifier.php` will collect the non-empty `IBLOCK_SECTION_ID` values
from the list items, retrieve the corresponding active section names in one
query, and add `SECTION_NAME` to each matching item. Items with no section or
with an unavailable section remain valid and render without a badge.

## Component settings

The template will expose two settings:

- `SHOW_SECTION_BADGE`: enables or disables all section badges without editing
  the template; default `Y`.
- `SECTION_BADGE_POSITION`: places the badge at the left or right upper corner;
  default `left`.

## Rendering and appearance

The template will render a badge only when the setting is enabled and
`SECTION_NAME` is available. The badge will use a position modifier class and
will truncate to one line with ellipsis.

Cards will reveal in list order when entering the viewport. The badge is part
of the card reveal and therefore appears smoothly with it. Image scaling and
the existing card action will have hover transitions. All colors will derive
from the theme CSS variables, including `--primary`, `--primary-hover`,
`--surface`, `--text-primary`, and `--text-secondary`.

The action uses the project's reusable inline arrow SVG so its color follows
the surrounding control through `currentColor`. Reduced-motion users receive
the fully visible content without transitions.

## Verification

Run PHP syntax checks for the template and result modifier. Inspect the final
diff to confirm that no unrelated files are changed.
