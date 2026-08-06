# Техническое задание для Codex
## Настройка размеров заголовков и текста через панель сайта

## Цель

Добавить в существующую панель настройки сайта две настройки:

1. **Размер текста**
2. **Размер заголовков**

От этих двух значений должна автоматически рассчитываться вся типографическая шкала сайта:

- основной текст;
- мелкий текст;
- подписи и метаданные;
- кнопки и формы;
- заголовки `H1–H6`;
- заголовки карточек;
- заголовки секций;
- заголовки баннеров;
- подзаголовки;
- контакты и подвал.

Пользователь не должен отдельно настраивать каждый размер.

## Исходные данные

В проекте уже используется файл:

```text
typography.css
```

Также существует панель настройки сайта и компонент:

```text
system.settings
```

> **Важно:** адаптация шаблонов компонентов к `typography.css` уже выполнена. Повторно перерабатывать шаблоны компонентов не требуется. Задача ограничена настройками панели, хранением значений, их применением и обновлением центральной типографической шкалы.

Перед изменениями необходимо:

1. Найти место объявления параметров панели.
2. Найти место хранения выбранных значений.
3. Найти код применения настроек к шаблону сайта.
4. Проверить, как другие параметры передаются в CSS или HTML.
5. Использовать существующую архитектуру проекта.

## Новые настройки

### Размер текста

```text
small  — Маленький
medium — Стандартный
large  — Крупный
```

Значение по умолчанию:

```text
medium
```

Рекомендуемые значения:

```text
small  = 15px
medium = 16px
large  = 18px
```

### Размер заголовков

```text
small  — Компактный
medium — Стандартный
large  — Крупный
```

Значение по умолчанию:

```text
medium
```

Рекомендуемые коэффициенты:

```text
small  = 0.90
medium = 1.00
large  = 1.12
```

Не использовать свободный ввод размера или произвольный ползунок.

## Имена параметров

Предпочтительно:

```text
typography-text-size
typography-heading-size
```

В PHP допустимо:

```php
TYPOGRAPHY_TEXT_SIZE
TYPOGRAPHY_HEADING_SIZE
```

Если в проекте принято другое именование, использовать текущий стиль.

## Передача настроек на страницу

Предпочтительный вариант:

```html
<html
    data-text-size="medium"
    data-heading-size="medium"
>
```

Пример PHP:

```php
<?php
$textSize = $properties->get('typography-text-size');
$headingSize = $properties->get('typography-heading-size');

$allowedTextSizes = ['small', 'medium', 'large'];
$allowedHeadingSizes = ['small', 'medium', 'large'];

if (!in_array($textSize, $allowedTextSizes, true)) {
    $textSize = 'medium';
}

if (!in_array($headingSize, $allowedHeadingSizes, true)) {
    $headingSize = 'medium';
}
?>

<html
    data-text-size="<?=htmlspecialcharsbx($textSize)?>"
    data-heading-size="<?=htmlspecialcharsbx($headingSize)?>"
>
```

Если проект уже использует классы на `body`, inline CSS-переменные или генерируемый CSS, применять существующий механизм.

## Базовые CSS-переменные

В `typography.css` добавить:

```css
:root {
    --typography-text-base: 16px;
    --typography-heading-scale: 1;
}
```

Настройки текста:

```css
html[data-text-size="small"] {
    --typography-text-base: 15px;
}

html[data-text-size="medium"] {
    --typography-text-base: 16px;
}

html[data-text-size="large"] {
    --typography-text-base: 18px;
}
```

Настройки заголовков:

```css
html[data-heading-size="small"] {
    --typography-heading-scale: 0.9;
}

html[data-heading-size="medium"] {
    --typography-heading-scale: 1;
}

html[data-heading-size="large"] {
    --typography-heading-scale: 1.12;
}
```

## Расчёт текстовой шкалы

```css
:root {
    --font-size-base: var(--typography-text-base);
    --font-size-xs: calc(var(--font-size-base) * 0.8125);
    --font-size-sm: calc(var(--font-size-base) * 0.875);
    --font-size-md: calc(var(--font-size-base) * 1.125);
    --font-size-lg: calc(var(--font-size-base) * 1.25);
}
```

От этой шкалы должны зависеть:

- абзацы;
- списки;
- описания;
- меню;
- кнопки;
- формы;
- карточки;
- подписи;
- даты;
- метаданные;
- контакты;
- подвал;
- хлебные крошки;
- пагинация;
- таблицы.

## Расчёт заголовков

```css
:root {
    --heading-size-h6-base: 14px;
    --heading-size-h5-base: 16px;
    --heading-size-h4-base: 18px;
    --heading-size-h3-base: 24px;
    --heading-size-h2-base: 34px;
    --heading-size-h1-base: 46px;
    --heading-size-hero-base: 50px;

    --font-size-h6: calc(var(--heading-size-h6-base) * var(--typography-heading-scale));
    --font-size-h5: calc(var(--heading-size-h5-base) * var(--typography-heading-scale));
    --font-size-h4: calc(var(--heading-size-h4-base) * var(--typography-heading-scale));
    --font-size-h3: calc(var(--heading-size-h3-base) * var(--typography-heading-scale));
    --font-size-h2: calc(var(--heading-size-h2-base) * var(--typography-heading-scale));
    --font-size-h1: calc(var(--heading-size-h1-base) * var(--typography-heading-scale));
    --font-size-hero: calc(var(--heading-size-hero-base) * var(--typography-heading-scale));
}
```

От этой шкалы должны зависеть:

- `H1–H6`;
- заголовки баннеров;
- заголовки секций;
- названия услуг;
- названия товаров;
- названия новостей;
- заголовки карточек;
- имена сотрудников, если они являются заголовками;
- акцентные заголовки рекламных блоков.

## Адаптивность

Выбранный размер не должен отключать адаптивность.

Использовать `clamp()` для крупных заголовков:

```css
h1 {
    font-size: clamp(
        2rem,
        calc(var(--font-size-h1) * 0.72 + 1.2vw),
        var(--font-size-h1)
    );
}

h2 {
    font-size: clamp(
        1.625rem,
        calc(var(--font-size-h2) * 0.76 + 0.8vw),
        var(--font-size-h2)
    );
}

h3 {
    font-size: clamp(
        1.25rem,
        calc(var(--font-size-h3) * 0.84 + 0.35vw),
        var(--font-size-h3)
    );
}

h4 {
    font-size: clamp(
        1rem,
        calc(var(--font-size-h4) * 0.9 + 0.15vw),
        var(--font-size-h4)
    );
}
```

Для баннеров:

```css
.hero-title,
.banner-title,
.main-banner h1 {
    font-size: clamp(
        2rem,
        calc(var(--font-size-hero) * 0.7 + 1.35vw),
        var(--font-size-hero)
    );
}
```

Проверить ширины:

```text
1440px
1200px
992px
768px
576px
375px
320px
```

## Ограничения для мобильных устройств

Даже при крупных размерах:

- текст не должен выходить за пределы блоков;
- карточки не должны ломаться;
- меню не должно переполняться;
- кнопки не должны становиться чрезмерно высокими;
- длинные заголовки должны переноситься;
- телефон и контакты не должны выходить за пределы подвала;
- не должно быть горизонтального скролла.

Для форм сохранить минимум:

```css
input,
textarea,
select {
    font-size: max(1rem, var(--font-size-sm));
}
```

## Семантические переменные

Сохранить существующие алиасы:

```css
:root {
    --font-size-header-meta: var(--font-size-xs);
    --font-size-navigation: var(--font-size-sm);
    --font-size-form-label: var(--font-size-sm);

    --font-size-card-meta: var(--font-size-sm);
    --font-size-card-body: var(--font-size-base);
    --font-size-card-title: var(--font-size-md);

    --font-size-page-lead: var(--font-size-lg);
    --font-size-button: var(--font-size-base);

    --font-size-template-h1: var(--font-size-h1);
    --font-size-template-h2: var(--font-size-h2);
    --font-size-template-h3: var(--font-size-h3);
    --font-size-template-h4: var(--font-size-h4);

    --font-size-banner-default-title: var(--font-size-hero);
    --font-size-banner-centered-title: var(--font-size-hero);
    --font-size-banner-default-body: var(--font-size-base);
    --font-size-banner-body: var(--font-size-base);

    --font-size-footer-contact: var(--font-size-md);
}
```

Не удалять используемые переменные, пока все ссылки на них не найдены.

## Панель настройки

Добавить группу:

```text
Типографика
```

Добавить поля:

```text
Размер текста
Размер заголовков
```

Тип поля:

```text
select
```

или текущий визуальный переключатель проекта.

## Динамический предпросмотр

Если панель применяет настройки без перезагрузки, новые настройки должны работать так же.

Пример:

```js
document.documentElement.dataset.textSize = value;
document.documentElement.dataset.headingSize = value;
```

Использовать этот подход только если он соответствует текущей архитектуре.

## Сохранение и сброс

Проверить:

- сохранение;
- восстановление после перезагрузки;
- сброс;
- отсутствие значения;
- неизвестное значение;
- старые установки без новых параметров;
- работу после очистки кеша.

Для некорректных значений использовать:

```text
medium
```

## Баннеры и H1

На внутренних страницах `H1` уже находится в баннере.

Не добавлять второй `H1`.

Не заменять `H1` баннера на `div`.

## Что нельзя менять

Без необходимости не менять:

- PHP-логику компонентов;
- запросы к инфоблокам;
- `$arResult`;
- параметры компонентов;
- кеширование;
- AJAX;
- ЧПУ;
- административные кнопки Битрикс;
- HTML-структуру карточек;
- цвета;
- отступы;
- изображения;
- анимации;
- бизнес-логику панели.

## Проверяемые страницы

Проверить минимум:

```text
/
 /uslugi/
 /tovary/
 /news/
 /about/
 /about/jobs/
 /about/statistics/
 /contacts/
```

Также проверить:

- детальную страницу услуги;
- детальную страницу товара;
- детальную страницу новости;
- страницу с формой;
- страницу с длинным `H1`;
- карточки с длинными названиями;
- подвал;
- мобильное меню;
- все шаблоны баннеров.

## Матрица тестирования

| Размер текста | Размер заголовков |
|---|---|
| small | small |
| small | medium |
| small | large |
| medium | small |
| medium | medium |
| medium | large |
| large | small |
| large | medium |
| large | large |

Для каждого сочетания проверить десктоп, планшет и телефон.

## Критерии готовности

1. В панели есть две настройки.
2. Настройки сохраняются.
3. Настройки применяются после загрузки.
4. Предпросмотр работает как у других параметров.
5. Текстовая шкала зависит от размера текста.
6. Заголовки зависят от размера заголовков.
7. На мобильных сохраняется адаптивность.
8. Не появляется второй `H1`.
9. Нет горизонтального скролла.
10. Стандартный вариант близок к текущему дизайну.
11. Уже адаптированные шаблоны компонентов продолжают использовать существующие CSS-переменные.
12. Нет PHP- и JavaScript-ошибок.
13. Не нарушена работа Битрикс.
14. Нет массового использования `!important`.
15. Не добавлены дублирующие правила типографики.

## Порядок выполнения

1. Изучить `system.settings`.
2. Найти механизм хранения настроек.
3. Найти подключение `typography.css`.
4. Найти переменные типографики.
5. Добавить два параметра.
6. Добавить значения по умолчанию.
7. Передать настройки в HTML или CSS.
8. Перестроить базовую шкалу.
9. Сохранить все существующие семантические алиасы.
10. Не изменять уже адаптированные шаблоны компонентов без необходимости.
11. Проверить девять сочетаний настроек.
12. Проверить контрольные ширины.
13. Исправить только проблемы, вызванные новой системой масштабирования.
14. Проверить отсутствие конфликтов с существующими стилями компонентов.
15. Подготовить отчёт.

## Финальный отчёт Codex

Вывести:

### Изменённые файлы

```text
путь
краткое описание изменений
```

### Добавленные параметры

```text
имя
допустимые значения
значение по умолчанию
место хранения
место применения
```

### Совместимость с шаблонами компонентов

Подтвердить, что уже адаптированные шаблоны компонентов не изменялись без необходимости и продолжают получать размеры через существующие CSS-переменные.

### Проверка

Указать:

- страницы;
- ширины;
- сочетания настроек;
- найденные переполнения;
- PHP- и JavaScript-ошибки.

### Оставшиеся фиксированные размеры

Перечислить намеренно оставленные значения и объяснить причину.

## Итог

Владелец сайта должен управлять типографикой двумя настройками:

```text
Размер текста
Размер заголовков
```

Все остальные размеры рассчитываются автоматически с сохранением адаптивности, читаемости и совместимости с компонентами.
