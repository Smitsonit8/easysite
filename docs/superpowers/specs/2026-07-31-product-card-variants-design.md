# Product card variants: ladybug and fireant

## Scope

Add two selectable `bitrix:news.list` templates under
`install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-tovari-cards/bitrix/news.list/`.
They extend the existing product-card family without changing existing templates.

## Templates

### `ladybug`

A dark, graphic product card inspired by the Kagamiie reference: bold outline,
high-contrast surface, image zoom on hover, and a price block visually attached
to the lower edge of the image. The layout uses a three-column grid on wide
screens and collapses to two and one columns at responsive breakpoints.

### `fireant`

A light, softly elevated product card inspired by the vinodjangid07 reference:
rounded media area, restrained shadows, a warm accent price chip, and a smooth
lift on hover. The layout uses four columns on large screens, then three, two,
and one columns as space narrows.

## Shared behaviour and data

Each template keeps the established contract: preview image, optional gallery
property (default `GALLERY`), gallery previous/next buttons, image counter,
`PRICE` property, detail-page URL, title, preview text, editor actions,
bottom pager, and existing Russian and English UI labels. Image URLs and text
are escaped before rendering. The gallery script is initialized on regular and
Bitrix AJAX renders.

## Accessibility and resilience

Navigation buttons receive localized `aria-label` values; images receive a
product-name fallback for alternative text; cards retain a placeholder when no
image is configured. Motion is disabled for users requesting reduced motion.

## Verification

Per request, automated tests will not be run. A subagent will perform a static
markup and CSS review after the files are created; any findings will be fixed
before handoff.
