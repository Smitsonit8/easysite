<?php

namespace Sporina\EasySite;

use Bitrix\Main\Config\Option;
use InvalidArgumentException;

/**
 * Single source of truth for the installed module's site settings catalogue.
 *
 * Add a new setting only to DEFINITIONS. Reading, validation, reset and the
 * configuration-panel data are derived from this declaration.
 */
final class Settings
{
    private const MODULE_ID = 'sporina.easysite';
    private const OPTION_NOT_FOUND = '__sporina_easysite_option_not_found__';
    private const CATEGORIES = [
        'template' => 'Оформление',
        'header' => 'Шапка',
        'footer' => 'Подвал',
        'main-page' => 'Главная',
        'contacts' => 'Контакты',
        'news-articles' => 'Новости и Статьи',
        'services-products' => 'Услуги и Товары',
        'sections' => 'Разделы',
        'mobile' => 'Мобильная версия',
    ];

    private const DEFINITIONS = [
        ['key' => 'template-color-theme', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Цветовая тема', 'type' => 'select', 'default' => 'blue', 'values' => ['blue' => 'Синяя', 'green' => 'Зелёная', 'orange' => 'Оранжевая']],
        ['key' => 'template-background-use', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Показывать фон', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'template-background-color', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Цвет фона', 'type' => 'color', 'default' => '#f8fbff'],
        ['key' => 'template-width', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Максимальная ширина', 'type' => 'select', 'default' => '1920', 'values' => ['1200' => '1200 px', '1440' => '1440 px', '1920' => '1920 px']],
        ['key' => 'template-font', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Шрифт', 'type' => 'select', 'default' => 'ibm-plex-sans', 'values' => ['ibm-plex-sans' => ['label' => 'IBM Plex Sans', 'appearance' => '"IBM Plex Sans", Arial, sans-serif'], 'arial' => ['label' => 'Arial', 'appearance' => 'Arial, sans-serif'], 'georgia' => ['label' => 'Georgia', 'appearance' => 'Georgia, serif']]],
        ['key' => 'template-headings-size', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Размер заголовков', 'type' => 'select', 'default' => 'normal', 'values' => ['compact' => ['label' => 'Компактный', 'appearance' => '0.88'], 'normal' => ['label' => 'Обычный', 'appearance' => '1'], 'large' => ['label' => 'Крупный', 'appearance' => '1.14']]],
        ['key' => 'template-images-lazyload-use', 'category' => 'template', 'categoryTitle' => 'Оформление', 'label' => 'Ленивая загрузка изображений', 'type' => 'checkbox', 'default' => 'N', 'values' => ['Y' => 'Да', 'N' => 'Нет']],

        ['key' => 'header-template', 'category' => 'header', 'categoryTitle' => 'Шапка', 'label' => 'Шаблон шапки', 'type' => 'select', 'default' => 'overlay', 'values' => ['default' => 'Обычный', 'overlay' => 'Наложение', 'sticky' => 'Закреплённый'], 'templatePath' => 'sporina/header/templates', 'sourceBinding' => ['scope' => 'template', 'file' => 'header.php', 'component' => 'sporina:header', 'parameter' => 'COMPONENT_TEMPLATE', 'target' => 'component-template'], 'previewRatio' => '16 / 1', 'previews' => ['default' => 'images/properties/header/default.webp', 'overlay' => 'images/properties/header/overlay.webp', 'sticky' => 'images/properties/header/sticky.webp']],
        ['key' => 'footer-template', 'category' => 'footer', 'categoryTitle' => 'Подвал', 'label' => 'Шаблон подвала', 'type' => 'select', 'default' => 'big', 'values' => ['big' => 'Большой', 'compact' => 'Компактный'], 'templatePath' => 'sporina/footer/templates', 'sourceBinding' => ['scope' => 'template', 'file' => 'footer.php', 'component' => 'sporina:footer', 'parameter' => 'COMPONENT_TEMPLATE', 'target' => 'component-template'], 'previewRatio' => '14 / 4', 'previews' => ['big' => 'images/properties/footer/big.webp', 'compact' => 'images/properties/footer/compact.webp']],

        ['key' => 'contacts-map-use', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Показывать карту', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет'], 'componentFallback' => true],
        ['key' => 'contacts-map-lat', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Широта (lat)', 'type' => 'latitude', 'default' => '51.533338', 'componentFallback' => true],
        ['key' => 'contacts-map-lon', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Долгота (lon)', 'type' => 'longitude', 'default' => '46.034176', 'componentFallback' => true],
        ['key' => 'contacts-map-title', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Заголовок карты', 'type' => 'text', 'default' => 'Местоположение офиса', 'componentFallback' => true],
        ['key' => 'contacts-map-height', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Высота карты, px', 'type' => 'number', 'default' => '420', 'componentFallback' => true],

        ['key' => 'news-list-template', 'category' => 'news-articles', 'categoryTitle' => 'Новости и статьи', 'label' => 'Новости: шаблон списка', 'type' => 'select', 'default' => 'paper', 'values' => ['circle' => 'Круг', 'paper' => 'Бумага', 'stand' => 'Стандартный'], 'templatePath' => 'bitrix/news/sporina-news/bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'novosti-kompanii/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => NEWS_IBLOCK_ID', 'parameter' => 'NEWS_LIST_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '4 / 3', 'previews' => ['circle' => 'images/properties/news/list/circle.webp', 'paper' => 'images/properties/news/list/paper.webp', 'stand' => 'images/properties/news/list/stand.webp']],
        ['key' => 'news-detail-template', 'category' => 'news-articles', 'categoryTitle' => 'Новости и статьи', 'label' => 'Новости: шаблон детальной страницы', 'type' => 'select', 'default' => 'paper', 'values' => ['circle' => 'Круг', 'paper' => 'Бумага', 'stand' => 'Стандартный'], 'templatePath' => 'bitrix/news/sporina-news/bitrix/news.detail', 'sourceBinding' => ['scope' => 'site', 'file' => 'novosti-kompanii/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => NEWS_IBLOCK_ID', 'parameter' => 'NEWS_DETAIL_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '4 / 3', 'previews' => ['circle' => 'images/properties/news/detail/circle.webp', 'paper' => 'images/properties/news/detail/paper.webp', 'stand' => 'images/properties/news/detail/stand.webp']],
        ['key' => 'articles-list-template', 'category' => 'news-articles', 'categoryTitle' => 'Новости и статьи', 'label' => 'Статьи: шаблон списка', 'type' => 'select', 'default' => 'circle', 'values' => ['circle' => 'Круг', 'paper' => 'Бумага', 'stand' => 'Стандартный'], 'templatePath' => 'bitrix/news/sporina-news/bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'izmeneniya-v-raspisanii/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => SCHEDULE_CHANGES_IBLOCK_ID', 'parameter' => 'NEWS_LIST_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '4 / 3', 'previews' => ['circle' => 'images/properties/articles/list/circle.webp', 'paper' => 'images/properties/articles/list/paper.webp', 'stand' => 'images/properties/articles/list/stand.webp']],
        ['key' => 'articles-detail-template', 'category' => 'news-articles', 'categoryTitle' => 'Новости и статьи', 'label' => 'Статьи: шаблон детальной страницы', 'type' => 'select', 'default' => 'paper', 'values' => ['circle' => 'Круг', 'paper' => 'Бумага', 'stand' => 'Стандартный'], 'templatePath' => 'bitrix/news/sporina-news/bitrix/news.detail', 'sourceBinding' => ['scope' => 'site', 'file' => 'izmeneniya-v-raspisanii/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => SCHEDULE_CHANGES_IBLOCK_ID', 'parameter' => 'NEWS_DETAIL_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '4 / 3', 'previews' => ['circle' => 'images/properties/articles/detail/circle.webp', 'paper' => 'images/properties/articles/detail/paper.webp', 'stand' => 'images/properties/articles/detail/stand.webp']],

        ['key' => 'services-list-template', 'category' => 'services-products', 'categoryTitle' => 'Услуги и товары', 'label' => 'Услуги: шаблон списка', 'type' => 'select', 'default' => 'stand', 'values' => ['stand' => 'Стандартный', 'layering' => 'Слойный', 'smoothness' => 'Сглаженный'], 'templatePath' => 'bitrix/news/sporina-uslugi-cards/bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'uslugi/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => SERVICES_IBLOCK_ID', 'parameter' => 'NEWS_LIST_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '7 / 4', 'previews' => ['stand' => 'images/properties/services/list/stand.webp', 'layering' => 'images/properties/services/list/layering.webp', 'smoothness' => 'images/properties/services/list/smoothness.webp']],
        //['key' => 'services-detail-template', 'category' => 'services-products', 'categoryTitle' => 'Услуги и товары', 'label' => 'Услуги: шаблон детальной страницы', 'type' => 'select', 'default' => '.default', 'values' => ['default' => 'Стандартный', 'layering' => 'Слои', 'smoothness' => 'Сглаженный'], 'templatePath' => 'bitrix/news/sporina-uslugi-cards/bitrix/news.detail', 'sourceBinding' => ['scope' => 'site', 'file' => 'uslugi/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => SERVICES_IBLOCK_ID', 'parameter' => 'NEWS_DETAIL_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '4 / 3', 'previews' => ['.default' => 'images/properties/services/detail/default.webp', 'paper' => 'images/properties/news/detail/paper.webp', 'stand' => 'images/properties/news/detail/stand.webp']],
        ['key' => 'products-list-template', 'category' => 'services-products', 'categoryTitle' => 'Услуги и товары', 'label' => 'Товары: шаблон списка', 'type' => 'select', 'default' => 'stand', 'values' => ['stand' => 'Стандартный', 'layering' => 'Слойный', 'smoothness' => 'Сглаженный', 'fireant' => 'Выплывающий'], 'templatePath' => 'bitrix/news/sporina-tovari-cards/bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'tovary/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => PRODUCTS_IBLOCK_ID', 'parameter' => 'NEWS_LIST_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '7 / 4', 'previews' => ['stand' => 'images/properties/products/list/stand.webp', 'layering' => 'images/properties/products/list/layering.webp', 'smoothness' => 'images/properties/products/list/smoothness.webp', 'fireant' => 'images/properties/products/list/fireant.webp']],

        ['key' => 'staff-list-template', 'category' => 'sections', 'categoryTitle' => 'Разделы', 'label' => 'Сотрудники: шаблон списка', 'type' => 'select', 'default' => 'blocks.1', 'values' => ['blocks.1' => 'Блоки', 'list.1' => 'Список'], 'templatePath' => 'bitrix/news/staff/bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'about/management/index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => "444"', 'parameter' => 'NEWS_LIST_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '6 / 3', 'previews' => ['blocks.1' => 'images/properties/staff/blocks.webp', 'list.1' => 'images/properties/staff/list.webp']],
        ['key' => 'jobs-list-template', 'category' => 'sections', 'categoryTitle' => 'Разделы', 'label' => 'Вакансии: шаблон списка', 'type' => 'select', 'default' => 'vacancies.1', 'values' => ['vacancies.1' => 'Аккардион', 'vacancies.2' => 'Список'], 'templatePath' => 'bitrix/news', 'sourceBinding' => ['scope' => 'site', 'file' => 'about/jobs/index.php', 'component' => 'bitrix:news', 'parameter' => 'COMPONENT_TEMPLATE', 'target' => 'component-template'], 'previewRatio' => '8 / 3', 'previews' => ['vacancies.1' => 'images/properties/jobs/accordion.webp', 'vacancies.2' => 'images/properties/jobs/list.webp']],

        ['key' => 'pages-main-banner-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать баннер', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-banner-template', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Шаблон баннера', 'type' => 'select', 'default' => '.default', 'values' => ['.default' => 'Стандартный', 'centered' => 'По центру', 'compact' => 'Компактный'], 'templatePath' => 'sporina/banner/templates', 'sourceBinding' => ['scope' => 'site', 'file' => 'index_inc.php', 'component' => 'sporina:banner', 'parameter' => 'COMPONENT_TEMPLATE', 'target' => 'component-template'], 'previewRatio' => '7 / 2', 'previews' => ['.default' => 'images/properties/banner/default.webp', 'centered' => 'images/properties/banner/centered.webp', 'compact' => 'images/properties/banner/compact.webp']],
        ['key' => 'pages-main-infocards-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать информационные карточки', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-infocards-template', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Шаблон информационных карточек', 'type' => 'select', 'default' => 'sporina-cards-bayinfo-stack', 'values' => ['sporina-cards-bayinfo' => 'Карточки', 'sporina-cards-bayinfo-stack' => 'Стопка карточек', 'sporina-cards-bayinfo-tiles' => 'Плитка карточек'], 'templatePath' => 'bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'index.php', 'component' => 'bitrix:news.list', 'anchor' => '"IBLOCK_ID" => "cards_info"', 'parameter' => 'COMPONENT_TEMPLATE', 'target' => 'component-template'], 'previewRatio' => '8 / 3', 'previews' => ['sporina-cards-bayinfo' => 'images/properties/infocards/sporina-cards-bayinfo.webp', 'sporina-cards-bayinfo-stack' => 'images/properties/infocards/sporina-cards-bayinfo-stack.webp', 'sporina-cards-bayinfo-tiles' => 'images/properties/infocards/sporina-cards-bayinfo-tiles.webp']],
        ['key' => 'pages-main-subscribe-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать подписку', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-columns-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать колонки', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-columns-layout', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Расположение колонок', 'type' => 'select', 'default' => 'two', 'values' => ['two' => 'Две колонки', 'stacked' => 'Одна под другой']],
        ['key' => 'pages-main-articles-template','category' => 'main-page','categoryTitle' => 'Главная', 'label' => 'Шаблон статей', 'type' => 'select', 'default' => '.default', 'values' => ['.default' => 'Стандартный', 'cards' => 'Карточки', 'timeline' => 'Лента времени'],'legacyValues' => ['sporina-column-news-company' => '.default', 'sporina-column-news-cards' => 'cards', 'sporina-column-news-timeline' => 'timeline'], 'templatePath' => 'bitrix/news/sporina-column-news-company/bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => SCHEDULE_CHANGES_IBLOCK_ID', 'parameter' => 'NEWS_LIST_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '0 / 1', 'previews' => ['.default' => 'images/properties/news_and_articles/sporina-column-news-company.webp', 'cards' => 'images/properties/news_and_articles/sporina-column-news-cards.webp', 'timeline' => 'images/properties/news_and_articles/sporina-column-news-timeline.webp'],'layoutClasses' => ['.default' => ['two' => 'news--default-two','stacked' => 'news--default-stacked'],'cards' => ['two' => 'sporina-news-cards--two','stacked' => 'sporina-news-cards--stacked'],'timeline' => ['two' => 'sporina-news-timeline--two','stacked' => 'sporina-news-timeline--stacked'],]],
        ['key' => 'pages-main-news-template', 'category' => 'main-page', 'categoryTitle' => 'Главная', 'label' => 'Шаблон новостей', 'type' => 'select', 'default' => '.default', 'values' => ['.default' => 'Стандартный', 'cards' => 'Карточки', 'timeline' => 'Лента времени'], 'legacyValues' => ['sporina-column-news-company' => '.default', 'sporina-column-news-cards' => 'cards', 'sporina-column-news-timeline' => 'timeline'], 'templatePath' => 'bitrix/news/sporina-column-news-company/bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'index.php', 'component' => 'bitrix:news', 'anchor' => '"IBLOCK_ID" => NEWS_IBLOCK_ID', 'parameter' => 'NEWS_LIST_TEMPLATE', 'target' => 'parameter'], 'previewRatio' => '0 / 1', 'previews' => ['.default' => 'images/properties/news_and_articles/sporina-column-news-company.webp', 'cards' => 'images/properties/news_and_articles/sporina-column-news-cards.webp', 'timeline' => 'images/properties/news_and_articles/sporina-column-news-timeline.webp'],'layoutClasses' => ['.default' => ['two' => 'news--default-two','stacked' => 'news--default-stacked'],'cards' => ['two' => 'sporina-news-cards--two','stacked' => 'sporina-news-cards--stacked'],'timeline' => ['two' => 'sporina-news-timeline--two','stacked' => 'sporina-news-timeline--stacked'],]],
        ['key' => 'pages-main-advertising-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать рекламу', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-advertising-template', 'category' => 'main-page', 'categoryTitle' => 'Главная', 'label' => 'Шаблон рекламного баннера', 'type' => 'select', 'default' => 'sporina-banner-app', 'values' => ['sporina-banner-app' => 'Sporina Banner App'], 'templatePath' => 'bitrix/news.list', 'sourceBinding' => ['scope' => 'site', 'file' => 'index.php', 'component' => 'bitrix:news.list', 'anchor' => '"IBLOCK_ID" => "advertising_bannerss"', 'parameter' => 'COMPONENT_TEMPLATE', 'target' => 'component-template']],
        ['key' => 'pages-main-current-news-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать актуальные новости', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-current-news-template', 'category' => 'main-page', 'categoryTitle' => 'Главная', 'label' => 'Шаблон актуальных новостей', 'type' => 'select', 'default' => 'sporina-news-all-modern', 'values' => ['sporina-news-all' => 'Обычный', 'sporina-news-all-modern' => 'Современный'], 'templatePath' => 'bitrix/news.index', 'sourceBinding' => ['scope' => 'site', 'file' => 'index.php', 'component' => 'bitrix:news.index', 'parameter' => 'COMPONENT_TEMPLATE', 'target' => 'component-template'], 'previewRatio' => '16 / 3', 'previews' => ['sporina-news-all' => 'images/properties/current_news/sporina-news-all.webp', 'sporina-news-all-modern' => 'images/properties/current_news/sporina-news-all-modern.webp']],
    ];

    public static function getDefinitions(): array
    {
        return self::DEFINITIONS;
    }

    /** Returns safe values: invalid stored options fall back to declared defaults. */
    public static function getAll(): array
    {
        $settings = [];

        foreach (self::DEFINITIONS as $definition) {
            $value = Option::get(self::MODULE_ID, $definition['key'], $definition['default'], SITE_ID);
            $settings[$definition['key']] = self::getBoundSourceValue($definition)
                ?? self::normalize($definition, (string) $value)
                ?? $definition['default'];
        }

        return $settings;
    }

    /** Returns true only when a value was explicitly saved for the current site. */
    public static function hasStoredValue(string $key): bool
    {
        if (self::getDefinition($key) === null) {
            return false;
        }

        return Option::get(self::MODULE_ID, $key, self::OPTION_NOT_FOUND, SITE_ID) !== self::OPTION_NOT_FOUND;
    }

    /** Builds category and field data consumed by the generic configuration template. */
    public static function getPanel(): array
    {
        $settings = self::getAll();
        $panel = [];

        foreach (self::CATEGORIES as $category => $title) {
            $panel[$category] = [
                'title' => $title,
                'fields' => [],
            ];
        }

        foreach (self::DEFINITIONS as $definition) {
            $category = $definition['category'];
            if (!isset($panel[$category])) {
                $panel[$category] = [
                    'title' => $definition['categoryTitle'],
                    'fields' => [],
                ];
            }

            $definition['value'] = $settings[$definition['key']];
            $definition['values'] = self::getAllowedValues($definition);
            $definition['stored'] = self::hasStoredValue($definition['key']);
            $panel[$category]['fields'][] = $definition;
        }

        return $panel;
    }

    /**
     * Template-ready values derived from the same catalogue as saved options.
     * No template-level defaults or lookup tables are required.
     */
    public static function getAppearance(): array
    {
        $settings = self::getAll();
        $font = self::getDefinition('template-font');
        $headings = self::getDefinition('template-headings-size');

        return [
            'theme' => $settings['template-color-theme'],
            'backgroundUse' => $settings['template-background-use'],
            'backgroundColor' => $settings['template-background-color'],
            'width' => $settings['template-width'],
            'fontFamily' => $font['values'][$settings['template-font']]['appearance'],
            'headingScale' => $headings['values'][$settings['template-headings-size']]['appearance'],
            'lazyloadUse' => $settings['template-images-lazyload-use'],
            'headerTemplate' => $settings['header-template'],
        ];
    }

    public static function apply(array $postedSettings): void
    {
        $normalizedSettings = [];

        foreach ($postedSettings as $key => $value) {
            if (!is_string($key) || !is_scalar($value)) {
                continue;
            }

            $definition = self::getDefinition($key);
            if ($definition === null) {
                continue;
            }

            if ($definition['type'] === 'select' && $value === '') {
                $value = $definition['default'];
            }

            $normalized = self::normalize($definition, (string) $value);
            if ($normalized === null) {
                throw new InvalidArgumentException('Invalid setting: ' . $key);
            }

            $normalizedSettings[$key] = $normalized;
        }

        self::synchronizeBoundSources($normalizedSettings);

        foreach ($normalizedSettings as $key => $normalized) {
            Option::set(self::MODULE_ID, $key, $normalized, SITE_ID);
        }
    }

    public static function reset(): void
    {
        $defaultSettings = [];
        foreach (self::DEFINITIONS as $definition) {
            $defaultSettings[$definition['key']] = $definition['default'];
        }
        self::synchronizeBoundSources($defaultSettings);

        foreach (self::DEFINITIONS as $definition) {
            if (empty($definition['componentFallback'])) {
                Option::set(self::MODULE_ID, $definition['key'], $definition['default'], SITE_ID);

                continue;
            }

            Option::delete(self::MODULE_ID, [
                'name' => $definition['key'],
                'site_id' => SITE_ID,
            ]);
        }
    }

    private static function getDefinition(string $key): ?array
    {
        foreach (self::DEFINITIONS as $definition) {
            if ($definition['key'] === $key) {
                return $definition;
            }
        }

        return null;
    }

    /** Reads a template value edited directly through the Bitrix component form. */
    private static function getBoundSourceValue(array $definition): ?string
    {
        $binding = $definition['sourceBinding'] ?? [];
        if (empty($binding['component']) || empty($binding['parameter'])) {
            return null;
        }

        $source = self::getBoundSource($binding);
        if ($source === null) {
            return null;
        }

        $componentBlock = self::getBoundComponentBlock($source['contents'], $binding);
        if ($componentBlock === null) {
            return null;
        }

        return self::normalize($definition, self::getComponentParameterValue($componentBlock, $binding) ?? '');
    }

    /** Keeps the settings panel and component editor bound to the same page parameter. */
    private static function synchronizeBoundSources(array $settings): void
    {
        foreach (self::DEFINITIONS as $definition) {
            $key = $definition['key'];
            if (empty($definition['sourceBinding']) || !isset($settings[$key])) {
                continue;
            }

            self::writeBoundSourceValue($definition, $settings[$key]);
        }
    }

    private static function writeBoundSourceValue(array $definition, string $value): void
    {
        $binding = $definition['sourceBinding'];
        $source = self::getBoundSource($binding);
        if ($source === null) {
            throw new \RuntimeException('Главная страница сайта недоступна для изменения.');
        }

        $componentBlock = self::getBoundComponentBlock($source['contents'], $binding);
        if ($componentBlock === null) {
            throw new \RuntimeException('Component call was not found.');
        }

        $updatedBlock = self::replaceComponentParameterValue($componentBlock, $binding, $value);
        if ($updatedBlock === null) {
            throw new \RuntimeException('Component template parameter was not found.');
        }

        $contents = substr_replace($source['contents'], $updatedBlock, $componentBlock['offset'], $componentBlock['length']);
        if ($contents === null) {
            throw new \RuntimeException('Не найден параметр шаблона компонента на главной странице.');
        }

        if (file_put_contents($source['path'], $contents, LOCK_EX) === false) {
            throw new \RuntimeException('Не удалось сохранить параметр шаблона на главной странице.');
        }
    }

    private static function getBoundComponentBlock(string $contents, array $binding): ?array
    {
        $component = preg_quote((string)($binding['component'] ?? ''), '/');
        if ($component === '') {
            return null;
        }

        $pattern = '/\$APPLICATION->IncludeComponent\(\s*"' . $component . '"\s*,.*?\n\s*false\s*\n?\s*\);/s';
        if (!preg_match_all($pattern, $contents, $matches, PREG_OFFSET_CAPTURE)) {
            return null;
        }

        $anchor = (string)($binding['anchor'] ?? '');
        $normalizedAnchor = preg_replace('/\s+/', '', $anchor);
        foreach ($matches[0] as $match) {
            $normalizedBlock = preg_replace('/\s+/', '', $match[0]);
            if ($anchor === '' || ($normalizedAnchor !== null && $normalizedBlock !== null
                && strpos($normalizedBlock, $normalizedAnchor) !== false)) {
                return ['contents' => $match[0], 'offset' => $match[1], 'length' => strlen($match[0])];
            }
        }

        return null;
    }

    private static function getComponentParameterValue(array $componentBlock, array $binding): ?string
    {
        $parameter = preg_quote((string)$binding['parameter'], '/');
        if (preg_match('/"' . $parameter . '"\s*=>\s*"([^"]+)"/', $componentBlock['contents'], $matches)) {
            return $matches[1];
        }

        if (($binding['target'] ?? '') === 'component-template'
            && preg_match('/IncludeComponent\(\s*"[^"]+"\s*,\s*"([^"]+)"\s*,/s', $componentBlock['contents'], $matches)) {
            return $matches[1];
        }

        return null;
    }

    private static function replaceComponentParameterValue(array $componentBlock, array $binding, string $value): ?string
    {
        $parameter = preg_quote((string)$binding['parameter'], '/');
        $contents = preg_replace(
            '/("' . $parameter . '"\s*=>\s*)"[^"]+"/',
            '$1"' . $value . '"',
            $componentBlock['contents'],
            1,
            $parameterCount
        );
        if ($contents === null || $parameterCount !== 1) {
            return null;
        }

        if (($binding['target'] ?? '') === 'component-template') {
            $contents = preg_replace(
                '/(IncludeComponent\(\s*"[^"]+"\s*,\s*)"[^"]+"/',
                '$1"' . $value . '"',
                $contents,
                1,
                $templateCount
            );
            if ($contents === null || $templateCount !== 1) {
                return null;
            }
        }

        return $contents;
    }

    private static function getBoundSource(array $binding): ?array
    {
        $documentRoot = realpath((string)($_SERVER['DOCUMENT_ROOT'] ?? ''));
        if ($documentRoot === false || empty($binding['file'])) {
            return null;
        }

        $file = trim((string)$binding['file'], '/\\');
        if ($file === '' || strpos($file, '..') !== false) {
            return null;
        }

        if (($binding['scope'] ?? '') === 'site') {
            $siteDirectory = trim((string)SITE_DIR, '/\\');
            $relativePath = ($siteDirectory !== '' ? $siteDirectory . DIRECTORY_SEPARATOR : '') . $file;
        } elseif (($binding['scope'] ?? '') === 'template') {
            $relativePath = trim((string)SITE_TEMPLATE_PATH, '/\\') . DIRECTORY_SEPARATOR . $file;
        } else {
            return null;
        }

        $path = $documentRoot . DIRECTORY_SEPARATOR . $relativePath;
        if (!is_file($path) || !is_readable($path)) {
            return null;
        }

        $contents = file_get_contents($path);

        return $contents === false ? null : ['path' => $path, 'contents' => $contents];
    }

    private static function normalize(array $definition, string $value): ?string
    {
		if (isset($definition['legacyValues'][$value])) {
			$value = $definition['legacyValues'][$value];
		}

        if ($definition['type'] === 'color') {
            return preg_match('/^#[0-9a-fA-F]{6}$/', $value) ? $value : null;
        }

        if ($definition['type'] === 'latitude' || $definition['type'] === 'longitude') {
            $value = trim($value);
            if (!preg_match('/^-?(?:\d+|\d*\.\d+)$/', $value)) {
                return null;
            }

            $coordinate = (float) $value;
            $limit = $definition['type'] === 'latitude' ? 90 : 180;

            return $coordinate >= -$limit && $coordinate <= $limit ? $value : null;
        }

        if ($definition['type'] === 'number') {
            return preg_match('/^[1-9]\d*$/', $value) ? $value : null;
        }

        if ($definition['type'] === 'text') {
            $value = trim($value);
            $length = function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);

            return $value !== '' && $length <= 255 ? $value : null;
        }

        return array_key_exists($value, $definition['values'] ?? []) ? $value : null;
    }

    private static function getAllowedValues(array $definition): array
    {
        $values = $definition['values'] ?? [];
        if (isset($definition['templatePath'])) {
            $declaredValues = $values;
            foreach ($values as $value => $label) {
                if (!self::isTemplateAvailable($definition, $value)) {
                    unset($values[$value]);
                }
            }

            if (empty($values)) {
                $values = $declaredValues;
            }
        }

        foreach ($values as $value => $metadata) {
            if (is_array($metadata)) {
                $values[$value] = $metadata['label'];
            }
        }

        return $values;
    }

    private static function isTemplateAvailable(array $definition, string $value): bool
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/components/' . $definition['templatePath'] . '/' . $value . '/template.php';

        return is_file($path);
    }
}
