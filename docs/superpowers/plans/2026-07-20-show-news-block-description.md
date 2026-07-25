# Управление описанием блока новостей Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Добавить флажок показа описания в `sporina-news-all-modern`.

**Architecture:** Параметр `SHOW_BLOCK_DESCRIPTION` задаёт доступность описания, а `template.php` проверяет его до вывода текста `BLOCK_DESCRIPTION`.

**Tech Stack:** PHP, Bitrix component templates.

## Global Constraints

- `SHOW_BLOCK_DESCRIPTION` имеет значение по умолчанию `Y`.
- Отсутствующий параметр трактуется как `Y`.
- Git и тесты не используются по указанию пользователя.

---

### Task 1: Добавить параметр и условие вывода

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.index/sporina-news-all-modern/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.index/sporina-news-all-modern/lang/ru/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.index/sporina-news-all-modern/lang/en/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.index/sporina-news-all-modern/template.php`

- [ ] Add the checkbox parameter with `DEFAULT => "Y"`.
- [ ] Add Russian and English labels for the checkbox.
- [ ] Guard the description markup with `($arParams["SHOW_BLOCK_DESCRIPTION"] ?? "Y") !== "N"`.
- [ ] Clear Bitrix cache before manually checking the setting in the component parameters.
