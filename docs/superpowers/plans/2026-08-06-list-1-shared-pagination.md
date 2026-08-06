# List 1 Shared Pagination Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Apply the existing `sporina-news-company__pager` styling to the `list.1` news-list pagination.

**Architecture:** Preserve `list.1`'s modifier class for its margins and add the shared pager class to each `NAV_STRING` wrapper. The existing parent-template stylesheet supplies all visual pagination rules.

**Tech Stack:** PHP, 1C-Bitrix templates, Node.js built-in test runner.

## Global Constraints

- Change both top and bottom pagination wrappers.
- Preserve `sporina-news-company-stand__pager`.
- Do not duplicate CSS from the common `sporina-news` stylesheet.

---

### Task 1: Reuse common pager class in list.1

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.list/list.1/template.php:8-92`
- Create: `tests/news-list-pagination.test.mjs`

**Interfaces:**

- Consumes: `NAV_STRING` and the common CSS selector `.sporina-news-company__pager`.
- Produces: top and bottom `list.1` pager wrappers with both the shared and stand-specific classes.

- [ ] **Step 1: Write the failing static test**

```js
assert.match(template, /class="sporina-news-company__pager sporina-news-company-stand__pager sporina-news-company-stand__pager--top"/);
assert.match(template, /class="sporina-news-company__pager sporina-news-company-stand__pager sporina-news-company-stand__pager--bottom"/);
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `node --test tests/news-list-pagination.test.mjs`

Expected: FAIL because both `list.1` wrappers currently lack the shared class.

- [ ] **Step 3: Add the shared class to both wrappers**

```php
<div class="sporina-news-company__pager sporina-news-company-stand__pager sporina-news-company-stand__pager--top">
```

Use the same class order with `--bottom` for the bottom wrapper.

- [ ] **Step 4: Run static verification**

Run: `node --test tests/news-list-pagination.test.mjs`

Expected: PASS.

- [ ] **Step 5: Commit**

Run: `git add install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.list/list.1/template.php tests/news-list-pagination.test.mjs && git commit -m "fix: share pager style with news list 1"`
