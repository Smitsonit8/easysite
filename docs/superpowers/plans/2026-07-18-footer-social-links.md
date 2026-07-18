# Социальные ссылки footer — план реализации

**Goal:** Заменить устаревшие ссылки Telegram и магазинов приложений на настраиваемые социальные сети в `sporina:footer`.

### Task 1: Параметры и данные компонента

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/footer/.parameters.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/footer/component.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/footer/lang/{ru,en}/.parameters.php`

- [ ] Удалить `TELEGRAM_LINK`, `GOOGLE_PLAY_LINK`, `APP_STORE_LINK`.
- [ ] Добавить `SOCIAL_SHOW`; при `Y` показать `SOCIAL_VK`, `SOCIAL_MAX`, `SOCIAL_OK`, `SOCIAL_RUTUBE`, `SOCIAL_DZEN`.
- [ ] Передать новые значения в `$arResult` и удалить старые.

### Task 2: Шаблоны footer

- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/footer/templates/{big,compact}/template.php`
- Modify: `install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/sporina/footer/templates/{big,compact}/style.css`

- [ ] Заменить блок Telegram/магазинов на ссылки пяти соцсетей с inline-SVG из `../../svg`.
- [ ] Выводить блок только при `SOCIAL_SHOW=Y` и непустой ссылке; экранировать URL и добавить `target="_blank" rel="noopener noreferrer"`.
- [ ] Удалить неиспользуемые языковые строки старых ссылок и добавить подписи соцсетей.

### Task 3: Статическая проверка

- [ ] Убедиться поиском, что старых параметров и разметки нет, а все пять новых свойств присутствуют в параметрах, результате и обоих шаблонах.
- [ ] Не запускать PHP-тесты или lint.
