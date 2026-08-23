# Аудит неиспользуемых файлов

Дата проверки: 23 августа 2026 г.  
Область: все 1&nbsp;941 файла, отслеживаемые Git в модуле `sporina.easysite`.

## Итог

Найдено **50 файлов, которые можно удалить с высокой уверенностью**. Это резервные/черновые варианты с суффиксами `_`, `__` и `-old`: на них нет ссылок в исходниках, а их имена не распознаются Bitrix как соглашения автоподключения.

Удаление не выполнялось: этот документ только фиксирует результаты анализа.

## Методика и ограничения

Проверены:

- точки установки модуля: `install/index.php` и сервисы мастера;
- все текстовые ссылки на путь и имя файла через `rg`;
- текущие подключения шаблона: `header.php` и `footer.php`;
- соглашения Bitrix для `template.php`, `style.css`, `.parameters.php`, `lang/`, `description.php` и шаблонов компонентов;
- история Git для отличения актуальных файлов от старых вариантов.

Отсутствие прямого `include` **не считается** доказательством неиспользования для файлов, которые Bitrix загружает по соглашению, либо для содержимого мастера, копируемого рекурсивно. Поэтому в список не попали стандартно именованные варианты шаблонов, языковые файлы, XML-демоданные и `style.css`.

## Высокая уверенность: удалить

### Устаревшие файлы шаблона

- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/header_.php`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/footer_.php`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/js/my_js_.js`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/style-old.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/typography_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/style/typography___.css`

Доказательство: актуальные `header.php` и `footer.php` подключают соответственно только `style/style.css`, `style/typography.css` и `js/my_js.js`; внешних ссылок на перечисленные варианты нет. Bitrix не интерпретирует `header_.php`, `footer_.php`, `my_js_.js`, `style_.css` или `.parameters_.php` как служебные имена.

### Остаточные файлы компонентов и ассетов

- `install/wizards/sporina/easy_site/images/en/logo__.png`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.list/sporina-infocards.1/template_.php`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/.parameters_.php`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/detail_.php`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/news_.php`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/section_.php`

Для каждого есть обычный аналог без суффикса либо штатный файл соответствующего типа; текстовых ссылок на остаточный вариант нет.

### Черновые `style_.css` (43 файла)

Все перечисленные файлы имеют неслужебное имя `style_.css`, не подключаются из PHP/CSS/JS и лежат рядом со штатным `style.css` либо не имеют механизма Bitrix для автозагрузки.

- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.index/sporina-news-all.1/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.index/sporina-news-all.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.list/sporina-infocards.1/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.list/sporina-infocards.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news.list/sporina-infocards.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news/bitrix/news.list/list.1/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news/bitrix/news.list/list.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-column-news/bitrix/news.list/list.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.detail/detail.1/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.detail/detail.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.detail/detail.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.list/list.1/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.list/list.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/bitrix/news.list/list.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/sporina-news/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/bitrix/news.detail/default/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/vacancies.2/bitrix/news.list/cards/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/footer/big/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/footer/compact/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/header/default/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/header/overlay/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/header/sticky/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/bitrix/news.detail/detail.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/bitrix/news.detail/detail.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/bitrix/news.list/ladybug/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/bitrix/news.list/list.1/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/bitrix/news.list/list.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/bitrix/news.list/list.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/bitrix/news.list/list.4/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-products/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-services/bitrix/news.detail/detail.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-services/bitrix/news.detail/detail.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-services/bitrix/news.list/list.1/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-services/bitrix/news.list/list.2/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-services/bitrix/news.list/list.3/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-services/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-tovari-cards/bitrix/news.detail/layering/style_.css`
- `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/news/sporina-tovari-cards/bitrix/news.detail/smoothness/style_.css`

## Кандидаты, требующие решения владельца

Это файлы без активного подключения либо только со ссылкой в документации, но их назначение может быть осознанным: исходники/альтернативная тема внешней библиотеки.

| Файлы | Почему не включены в удаление |
| --- | --- |
| `dist/owl.carousel.js`, `dist/assets/owl.carousel.css`, `dist/assets/owl.theme.default.css`, `dist/assets/owl.theme.green.css` | Рабочий шаблон использует минифицированные варианты. Неминифицированные файлы и зелёная тема могут быть оставлены как поставляемые исходники Owl Carousel; README библиотеки упоминает первые два CSS-файла. |
| `style/style2.css`, `styles.css`, `template_styles.css` | Нет подтверждённого прямого подключения, но эти имена потенциально используются в ручных доработках или соглашениях шаблона. Нужен прогон на установленном сайте перед удалением. |
| Корневые `audit.md`, `FIXLIST.md`, `codex-adapt-component-templates-to-typography.md`, `codex-typography-panel-task-final.md` | Не участвуют в работе модуля. Это рабочая история аудитов/задач, а не неиспользуемый runtime-код; `FIXLIST.md` ссылается на `audit.md`. |

## Явно используемые файлы, которые легко ошибочно признать лишними

- `dist/owl.carousel.min.js`, `dist/assets/owl.carousel.min.css`, `dist/assets/owl.theme.default.min.css` подключаются из актуальных `header.php`/`footer.php`.
- `dist/assets/owl.video.play.png` используется из `owl.carousel.min.css` через `url()`.
- `js/slide.js` подключается из `footer.php`.
- `lang/**`, `description.php`, `colors.css`, `template.php`, `style.css`, `.parameters.php`, XML в сервисах мастера и содержимое `site/public/**` могут загружаться Bitrix или копироваться мастером без явной текстовой ссылки.

## Рекомендуемый порядок очистки

1. Удалить 50 файлов из раздела «Высокая уверенность» отдельным коммитом.
2. Установить модуль в чистый Bitrix-стенд и пройти ключевые страницы/мастер.
3. Только после этого принять отдельное решение по исходникам Owl Carousel и рабочей документации.

