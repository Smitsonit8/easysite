# Заголовок инфоблока в колонках Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Добавить управляемый вывод названия инфоблока в каждый шаблон колонок главной страницы.

**Architecture:** Комплексный шаблон `bitrix:news` объявляет `SHOW_IBLOCK_TITLE` и передаёт его вложенному `bitrix:news.list`. Все три шаблона списка используют один и тот же флаг при выводе `$arResult['NAME']`.

**Tech Stack:** PHP, Bitrix Framework, шаблоны компонентов.

## Global Constraints

- Не запускать тесты.
- Не использовать Git.
- Значение по умолчанию: `Y`.

---

### Task 1: Параметр и передача во вложенный список

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/news.php`

**Interfaces:**
- Produces: параметр `SHOW_IBLOCK_TITLE` со строковым значением `Y` или `N` в `$arParams` вложенного `bitrix:news.list`.

- [x] Добавить флажок `SHOW_IBLOCK_TITLE` в группу `BASE` с `DEFAULT => "Y"`.
- [x] Передать параметр в массив параметров вложенного `bitrix:news.list`, используя безопасное значение по умолчанию `Y`.

### Task 2: Условный заголовок во всех вариантах списка

**Files:**
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/bitrix/news.list/.default/template.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/bitrix/news.list/cards/template.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/bitrix/news.list/timeline/template.php`

**Interfaces:**
- Consumes: `$arParams['SHOW_IBLOCK_TITLE']`.
- Produces: заголовок `$arResult['NAME']` только при значении `Y` и непустом названии.

- [x] Добавить заголовок в `.default` перед списком карточек, в его существующей разметке колонок.
- [x] Обернуть уже существующие заголовки `cards` и `timeline` в ту же проверку параметра.
- [x] Проверить статически наличие параметра в объявлении, передаче и трёх шаблонах; тесты и Git не запускать.
