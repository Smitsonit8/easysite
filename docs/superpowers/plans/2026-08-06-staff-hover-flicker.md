# Staff Hover Flicker Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Eliminate the visual seam beneath the expanding staff-card panel.

**Architecture:** Keep the card as a fixed clipping container while its body translates upward. The card continues animating only `box-shadow`, so the browser no longer recomposes an overflowing child while its clipping parent is transformed.

**Tech Stack:** CSS, Node.js built-in test runner.

## Global Constraints

- Do not change the panel, photo or contact-content animations.
- Retain the hover shadow.
- Remove the card hover transform for both hover and focus-within states.

---

### Task 1: Keep the clipping card stationary

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/blocks.1/style.css:29-33`
- Create: `tests/staff-hover-flicker.test.mjs`

**Interfaces:**

- Consumes: `.sporina-staff__card` as the `overflow: hidden` container and `.sporina-staff__body` as the translating panel.
- Produces: a hover/focus card rule with `box-shadow` but without a `transform` declaration.

- [ ] **Step 1: Write a failing static test**

```js
assert.doesNotMatch(cardHoverRule, /transform\s*:/);
assert.match(bodyHoverRule, /transform:\s*translateY\(0\)/);
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `node --test tests/staff-hover-flicker.test.mjs`

Expected: FAIL because the card hover rule currently contains `transform: translateY(-4px)`.

- [ ] **Step 3: Remove only the card transform**

```css
.sporina-staff__card:hover,
.sporina-staff__card:focus-within {
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.14);
}
```

- [ ] **Step 4: Run verification**

Run: `node --test tests/staff-hover-flicker.test.mjs`

Expected: PASS.

- [ ] **Step 5: Commit**

Run: `git add install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/blocks.1/style.css tests/staff-hover-flicker.test.mjs && git commit -m "fix: prevent staff panel hover flicker"`
