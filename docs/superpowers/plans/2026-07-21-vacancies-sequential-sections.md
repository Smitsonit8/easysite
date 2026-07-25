# Последовательный вывод разделов вакансий Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Заменить вкладки вакансий последовательным выводом разделов с их элементами.

**Architecture:** Шаблон использует уже сгруппированный `SPORINA_SECTIONS`; CSS отображает все группы, а JavaScript обслуживает только аккордеон элемента.

**Tech Stack:** PHP, CSS, vanilla JavaScript, Bitrix component templates.

## Global Constraints

- Группировка в `result_modifier.php` не меняется.
- Git и тесты не используются по указанию пользователя.

---

### Task 1: Убрать вкладки и вывести секции подряд

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/bitrix/news.list/accordion/template.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.1/bitrix/news.list/accordion/style.css`

- [ ] Remove tab buttons and their click handler.
- [ ] Add `<h2 class="sporina-vacancies__section-title">` before each section's items.
- [ ] Render all `.sporina-vacancies__section` blocks visible, one after another.
- [ ] Keep the existing toggle handler and item markup unchanged.
