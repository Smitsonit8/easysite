# Staff Name Wrapping Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ensure staff names remain fully visible when they wrap across multiple lines.

**Architecture:** Split the card overlay into a natural-height summary and a CSS-Grid details region. The details region collapses independently, while the summary always renders its full content.

**Tech Stack:** PHP templates, CSS Grid, Node.js built-in test runner.

## Global Constraints

- Keep position and name visible in the collapsed card.
- Reveal contacts and social links on hover and focus.
- Keep mobile details permanently visible.

---

### Task 1: Separate summary from expandable details

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/blocks.1/template.php:23-33`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/blocks.1/style.css:54-76,184-215`
- Create: `tests/staff-name-wrap.test.mjs`

**Interfaces:**

- Consumes: `.sporina-staff__summary` with position/name and `.sporina-staff__details-content` with contacts/social links.
- Produces: a body without fixed `translateY(calc(100% - 100px))` and details that transition grid rows from `0fr` to `1fr`.

- [ ] **Step 1: Write a failing static test**

```js
assert.match(template, /class="sporina-staff__summary"/);
assert.match(template, /class="sporina-staff__details-content"/);
assert.doesNotMatch(style, /translateY\(calc\(100% - 100px\)\)/);
assert.match(style, /grid-template-rows:\s*0fr/);
assert.match(style, /grid-template-rows:\s*1fr/);
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `node --test tests/staff-name-wrap.test.mjs`

Expected: FAIL because no summary/details structure exists and the body has the fixed 100px shift.

- [ ] **Step 3: Implement the split overlay**

```php
<div class="sporina-staff__summary">…position and name…</div>
<div class="sporina-staff__details"><div class="sporina-staff__details-content">…contacts and social…</div></div>
```

```css
.sporina-staff__details { display: grid; grid-template-rows: 0fr; }
.sporina-staff__details-content { overflow: hidden; }
.sporina-staff__card:hover .sporina-staff__details { grid-template-rows: 1fr; }
```

- [ ] **Step 4: Run verification**

Run: `node --test tests/staff-name-wrap.test.mjs`

Expected: PASS.

- [ ] **Step 5: Commit**

Run: `git add install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/blocks.1/template.php install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/blocks.1/style.css tests/staff-name-wrap.test.mjs && git commit -m "fix: keep wrapped staff names visible"`
