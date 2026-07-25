# Настройка кнопки «Еще» Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Добавить общий параметр, включающий и отключающий кнопку «Еще» в `cards` и `timeline` компонента `sporina-column-news-company`.

**Architecture:** `SHOW_MORE_BUTTON` объявляется как параметр шаблона и передаётся во вложенный `bitrix:news.list`. Оба шаблона показывают кнопку, если значение не `N` и доступен URL списка.

**Tech Stack:** PHP, шаблоны Bitrix, PowerShell.

## Global Constraints

- Имя параметра: `SHOW_MORE_BUTTON`; значение по умолчанию: `Y`.
- Отсутствующий параметр считается равным `Y`.
- Затрагивается только `sporina-column-news-company`.

---

### Task 1: Объявить параметр и передать его в `news.list`

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/lang/ru/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/news.php`

- [ ] Add a checkbox definition:

```php
"SHOW_MORE_BUTTON" => array(
	"PARENT" => "BASE",
	"NAME" => GetMessage("SPORINA_COLUMN_NEWS_SHOW_MORE_BUTTON"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
),
```

- [ ] Add the Russian text:

```php
$MESS["SPORINA_COLUMN_NEWS_SHOW_MORE_BUTTON"] = "Показывать кнопку «Еще»";
```

- [ ] Add these adjacent to `IBLOCK_URL` in `news.php`:

```php
"LIST_PAGE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
"SHOW_MORE_BUTTON" => isset($arParams["SHOW_MORE_BUTTON"]) ? $arParams["SHOW_MORE_BUTTON"] : "Y",
```

### Task 2: Использовать флажок в обоих шаблонах

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/bitrix/news.list/cards/template.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/bitrix/news.list/timeline/template.php`

- [ ] In both files, replace the actions condition with:

```php
<?if($arParams["SHOW_MORE_BUTTON"] !== "N" && $listPageUrl !== ""):?>
```

- [ ] Run syntax checks:

```powershell
php -l install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/.parameters.php
php -l install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/news.php
php -l install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/bitrix/news.list/cards/template.php
php -l install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news-company/bitrix/news.list/timeline/template.php
```

- [ ] Manually verify `Y` shows the button and `N` hides it in both list layouts after clearing Bitrix cache.
