
# Шаблон `staff` для `bitrix:news` — план реализации

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Добавить шаблон `staff` для `bitrix:news` с вариантами списка `blocks.1` и `list.1` и детальной страницей сотрудника.

**Architecture:** Корневой шаблон организован как `sporina-column-news-company`: его параметр выбирает дочерний `bitrix:news.list` по белому списку. Вложенные шаблоны повторяют разметку исходного `intec.prom/staff.1`, заменяя все зависимости штатным PHP и API Битрикс.

**Tech Stack:** PHP 7.4+, 1С-Битрикс, CSS, inline SVG.

## Global Constraints

- Изменять только `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/` и тест `tests/staff_template_structure_test.php`.
- Не использовать `intec`, `FORM_ASK`, проекты или отзывы.
- Разрешать только `NEWS_LIST_TEMPLATE=blocks.1|list.1`; fallback — `blocks.1`.
- Сохранить DOM, CSS-геометрию, адаптивность и SVG исходных шаблонов.

---

### Task 1: Корневой шаблон и его контракт

**Files:**

- Create: `tests/staff_template_structure_test.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/.parameters.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/news.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/detail.php`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/lang/ru/.parameters.php`

**Interfaces:**

- Consumes: параметры `bitrix:news`, `NEWS_LIST_TEMPLATE` и восемь кодов свойств сотрудника.
- Produces: `news.php` вызывает `bitrix:news.list` с `blocks.1` или `list.1`; `detail.php` вызывает `bitrix:news.detail/staff.1`.

- [ ] **Step 1: Write the failing test**

```php
<?php
$root = dirname(__DIR__).'/install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff';
$news = file_get_contents($root.'/news.php');
$parameters = file_get_contents($root.'/.parameters.php');
foreach (['blocks.1', 'list.1', 'bitrix:news.list'] as $expected) {
    if (strpos($news, $expected) === false && strpos($parameters, $expected) === false) {
        throw new RuntimeException('Missing contract: '.$expected);
    }
}
foreach (['intec', 'FORM_ASK', 'PROJECTS_', 'REVIEWS_'] as $forbidden) {
    if (stripos($news, $forbidden) !== false || stripos($parameters, $forbidden) !== false) {
        throw new RuntimeException('Forbidden feature: '.$forbidden);
    }
}
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `php tests/staff_template_structure_test.php`

Expected: failure because `staff/news.php` and `.parameters.php` do not exist.

- [ ] **Step 3: Implement root configuration and routing**

Create native Bitrix property selectors for `PROPERTY_POSITION`, `PROPERTY_PHONE`, `PROPERTY_EMAIL`, `PROPERTY_SOCIAL_VK`, `PROPERTY_SOCIAL_FB`, `PROPERTY_SOCIAL_INST`, `PROPERTY_SOCIAL_TW` and `PROPERTY_SOCIAL_SKYPE`, plus:

```php
'NEWS_LIST_TEMPLATE' => array(
    'PARENT' => 'BASE',
    'TYPE' => 'LIST',
    'VALUES' => array('blocks.1' => 'Блоки', 'list.1' => 'Список'),
    'DEFAULT' => 'blocks.1',
)
```

Implement the exact whitelist in `news.php`:

```php
$availableNewsListTemplates = array('blocks.1', 'list.1');
$newsListTemplate = isset($arParams['NEWS_LIST_TEMPLATE']) ? (string)$arParams['NEWS_LIST_TEMPLATE'] : 'blocks.1';
if (!in_array($newsListTemplate, $availableNewsListTemplates, true)) {
    $newsListTemplate = 'blocks.1';
}
$APPLICATION->IncludeComponent('bitrix:news.list', $newsListTemplate, $listParameters, $component);
```

Append the configured employee properties to `LIST_PROPERTY_CODE` and `DETAIL_PROPERTY_CODE` without duplicates. `detail.php` must additionally request `PREVIEW_PICTURE` and `DETAIL_PICTURE`, then include `bitrix:news.detail` with template `staff.1`, forwarding standard URL/cache/pager/404 parameters only.

- [ ] **Step 4: Run the test to verify it passes**

Run: `php tests/staff_template_structure_test.php`

Expected: exit code 0.

- [ ] **Step 5: Commit**

```bash
git add tests/staff_template_structure_test.php install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff
git commit -m "feat: add staff news template shell"
```

### Task 2: Представления списка `blocks.1` и `list.1`

**Files:**

- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/blocks.1/**`
- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list/list.1/**`
- Modify: `tests/staff_template_structure_test.php`

**Interfaces:**

- Consumes: массив `$arResult['ITEMS']`, восемь свойств сотрудника и `SOCIAL_SHOW`.
- Produces: две адаптивные карточки/строки сотрудника с детализацией, контактами и SVG-иконками.

- [ ] **Step 1: Write failing checks for both directories**

```php
foreach (['blocks.1', 'list.1'] as $view) {
    $template = $root.'/bitrix/news.list/'.$view.'/template.php';
    if (!is_file($template)) throw new RuntimeException('Missing list view: '.$view);
    $source = file_get_contents($template);
    foreach (['PROPERTY_POSITION', 'PROPERTY_PHONE', 'PROPERTY_EMAIL', 'SOCIAL'] as $expected) {
        if (strpos($source, $expected) === false) throw new RuntimeException($view.' misses '.$expected);
    }
    if (stripos($source, 'intec') !== false || stripos($source, 'FORM_ASK') !== false) {
        throw new RuntimeException($view.' contains a forbidden dependency');
    }
}
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `php tests/staff_template_structure_test.php`

Expected: failure with `Missing list view: blocks.1`.

- [ ] **Step 3: Implement both source-compatible list views**

Port `staff.blocks.1` and `staff.list.1` from `intec.prom`, including template, item/section parts, localisation, CSS and the seven contact/social SVGs. Replace `intec` HTML, file and collection helpers with `htmlspecialcharsbx()`, `CFile::GetPath()`, `file_get_contents()`, `array_filter()` and strict `in_array()`. Rename all `intec-*` CSS classes to `sporina-staff-*` in both markup and styles. Omit `parameters/base.php`, `parameters/lite.php`, `parts/script.php` and every message-form path. Keep Skype `chat`/`call` handling as a direct `skype:` URL.

- [ ] **Step 4: Run the test to verify it passes**

Run: `php tests/staff_template_structure_test.php`

Expected: exit code 0.

- [ ] **Step 5: Commit**

```bash
git add tests/staff_template_structure_test.php install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.list
git commit -m "feat: add staff list views"
```

### Task 3: Детальная страница и полная валидация

**Files:**

- Create: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/bitrix/news.detail/staff.1/**`
- Modify: `tests/staff_template_structure_test.php`

**Interfaces:**

- Consumes: поля элемента, восемь кодов свойств сотрудника, `SOCIAL_SHOW` и `LIST_PAGE_URL`.
- Produces: фотографию, имя, должность, описание, контакты, соцсети и ссылку назад к списку.

- [ ] **Step 1: Write the failing detail check**

```php
$detail = $root.'/bitrix/news.detail/staff.1/template.php';
if (!is_file($detail)) throw new RuntimeException('Missing staff detail template');
$source = file_get_contents($detail);
foreach (['PROPERTY_POSITION', 'PROPERTY_PHONE', 'PROPERTY_EMAIL', 'LIST_PAGE_URL'] as $expected) {
    if (strpos($source, $expected) === false) throw new RuntimeException('Detail misses '.$expected);
}
foreach (['intec', 'PROJECTS', 'REVIEWS', 'FORM_ASK'] as $forbidden) {
    if (stripos($source, $forbidden) !== false) throw new RuntimeException('Detail contains '.$forbidden);
}
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `php tests/staff_template_structure_test.php`

Expected: failure with `Missing staff detail template`.

- [ ] **Step 3: Implement the detail presentation**

Port `news.detail/staff.default.1` markup, CSS, contacts parts, localisation and SVGs. Preserve only image, name, position, preview/detail text, phone, e-mail, socials and back link. Use `htmlspecialcharsbx()`, `CFile::GetPath()` and `file_get_contents()`; rename `intec-*` CSS to `sporina-staff-*`. Do not create project/review modifiers, parameters or parts, nor JavaScript/form-message files.

- [ ] **Step 4: Verify all requirements**

Run:

```powershell
php tests/staff_template_structure_test.php
Get-ChildItem -Recurse install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff -Filter *.php | ForEach-Object { php -l $_.FullName }
rg -n "intec|FORM_ASK|PROJECTS_|REVIEWS_" install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff
```

Expected: test and every PHP lint succeed; `rg` prints no matches.

- [ ] **Step 5: Commit**

```bash
git add tests/staff_template_structure_test.php install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff
git commit -m "feat: add staff detail view"
```

### Task 4: Локальные социальные сети и интерактивность `blocks.1`

**Files:**

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff/{news.php,detail.php,lang/ru/.parameters.php}`
- Modify: both `bitrix/news.list/*/template.php` and `style.css`
- Create: both `bitrix/news.list/*/lang/ru/{.parameters.php,template.php}` and the SVGs for Max, Одноклассники, Rutube and Дзен.

- [ ] **Step 1: Replace social-property parameters**

Expose exactly `PROPERTY_SOCIAL_VK`, `PROPERTY_SOCIAL_MAX`, `PROPERTY_SOCIAL_OK`, `PROPERTY_SOCIAL_RUTUBE` and `PROPERTY_SOCIAL_DZEN`; remove all other social-network properties.

- [ ] **Step 2: Normalize and render social links**

Accept `http://` and `https://`; prepend `https://` to a hostname without a scheme; reject every other URI scheme. Pass the five selected properties from the root `bitrix:news` template to each child component.

- [ ] **Step 3: Add localisation and blocks animation**

Add Russian labels in both list-template `lang/ru` directories. Implement a `max-height`, `opacity` and `transform` transition for the contacts/social container in `blocks.1`; reveal it on `.sporina-staff__card:hover` and `.sporina-staff__card:focus-within`.

- [ ] **Step 4: Static validation only**

Run: `rg -n -i "twitter|skype|facebook|instagram" install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff`

Expected: no matches. Do not run PHP tests or PHP linting.
