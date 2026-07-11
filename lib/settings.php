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
        'layout' => 'Шапка и подвал',
        'main-page' => 'Главная',
        'contacts' => 'Контакты',
        'news-articles' => 'Новости и Статьи',
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

        ['key' => 'header-template', 'category' => 'layout', 'categoryTitle' => 'Шапка и подвал', 'label' => 'Шаблон шапки', 'type' => 'select', 'default' => 'overlay', 'values' => ['default' => 'Обычный', 'overlay' => 'Наложение', 'sticky' => 'Закреплённый'], 'templatePath' => 'sporina/header/templates', 'previews' => ['default' => 'images/properties/header/default.png', 'overlay' => 'images/properties/header/overlay.png', 'sticky' => 'images/properties/header/sticky.png']],
        ['key' => 'footer-template', 'category' => 'layout', 'categoryTitle' => 'Шапка и подвал', 'label' => 'Шаблон подвала', 'type' => 'select', 'default' => 'big', 'values' => ['big' => 'Большой', 'compact' => 'Компактный'], 'templatePath' => 'sporina/footer/templates', 'previews' => ['big' => 'images/properties/footer/big.png', 'compact' => 'images/properties/footer/compact.png']],

        ['key' => 'contacts-map-use', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Показывать карту', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет'], 'componentFallback' => true],
        ['key' => 'contacts-map-lat', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Широта (lat)', 'type' => 'latitude', 'default' => '51.533338', 'componentFallback' => true],
        ['key' => 'contacts-map-lon', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Долгота (lon)', 'type' => 'longitude', 'default' => '46.034176', 'componentFallback' => true],
        ['key' => 'contacts-map-title', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Заголовок карты', 'type' => 'text', 'default' => 'Местоположение офиса', 'componentFallback' => true],
        ['key' => 'contacts-map-height', 'category' => 'contacts', 'categoryTitle' => 'Контакты', 'label' => 'Высота карты, px', 'type' => 'number', 'default' => '420', 'componentFallback' => true],

        ['key' => 'pages-main-banner-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать баннер', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-banner-template', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Шаблон баннера', 'type' => 'select', 'default' => '.default', 'values' => ['.default' => 'Стандартный', 'centered' => 'По центру', 'compact' => 'Компактный'], 'templatePath' => 'sporina/banner/templates', 'previews' => ['.default' => 'images/properties/banner/default.png', 'centered' => 'images/properties/banner/centered.png', 'compact' => 'images/properties/banner/compact.png']],
        ['key' => 'pages-main-infocards-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать информационные карточки', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-infocards-template', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Шаблон информационных карточек', 'type' => 'select', 'default' => 'sporina-cards-bayinfo-stack', 'values' => ['sporina-cards-bayinfo' => 'Карточки', 'sporina-cards-bayinfo-stack' => 'Стопка карточек', 'sporina-cards-bayinfo-tiles' => 'Плитка карточек'], 'templatePath' => 'bitrix/news.list', 'previews' => ['sporina-cards-bayinfo' => 'images/properties/infocards/sporina-cards-bayinfo.png', 'sporina-cards-bayinfo-stack' => 'images/properties/infocards/sporina-cards-bayinfo-stack.png', 'sporina-cards-bayinfo-tiles' => 'images/properties/infocards/sporina-cards-bayinfo-tiles.png']],
        ['key' => 'pages-main-subscribe-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать подписку', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-columns-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать колонки', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-columns-layout', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Расположение колонок', 'type' => 'select', 'default' => 'two', 'values' => ['two' => 'Две колонки', 'stacked' => 'Одна под другой']],
        ['key' => 'pages-main-articles-template', 'category' => 'main-page', 'categoryTitle' => 'Главная', 'label' => 'Шаблон статей', 'type' => 'select', 'default' => 'sporina-column-news-timeline', 'values' => ['sporina-column-news-cards' => 'Карточки', 'sporina-column-news-company' => 'Компания', 'sporina-column-news-timeline' => 'Лента времени'], 'templatePath' => 'bitrix/news', 'previews' => ['sporina-column-news-cards' => 'images/properties/news_and_articles/sporina-column-news-cards.png', 'sporina-column-news-company' => 'images/properties/news_and_articles/sporina-column-news-company.png', 'sporina-column-news-timeline' => 'images/properties/news_and_articles/sporina-column-news-timeline.png']],
        ['key' => 'pages-main-news-template', 'category' => 'main-page', 'categoryTitle' => 'Главная', 'label' => 'Шаблон новостей', 'type' => 'select', 'default' => 'sporina-column-news-company', 'values' => ['sporina-column-news-cards' => 'Карточки', 'sporina-column-news-company' => 'Компания', 'sporina-column-news-timeline' => 'Лента времени'], 'templatePath' => 'bitrix/news', 'previews' => ['sporina-column-news-cards' => 'images/properties/news_and_articles/sporina-column-news-cards.png', 'sporina-column-news-company' => 'images/properties/news_and_articles/sporina-column-news-company.png', 'sporina-column-news-timeline' => 'images/properties/news_and_articles/sporina-column-news-timeline.png']],
        ['key' => 'pages-main-advertising-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать рекламу', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-advertising-template', 'category' => 'main-page', 'categoryTitle' => 'Главная', 'label' => 'Шаблон рекламного баннера', 'type' => 'select', 'default' => 'sporina-banner-app', 'values' => ['sporina-banner-app' => 'Sporina Banner App'], 'templatePath' => 'bitrix/news.list'],
        ['key' => 'pages-main-current-news-use', 'category' => 'main-page', 'categoryTitle' => 'Главная страница', 'label' => 'Показывать актуальные новости', 'type' => 'checkbox', 'default' => 'Y', 'values' => ['Y' => 'Да', 'N' => 'Нет']],
        ['key' => 'pages-main-current-news-template', 'category' => 'main-page', 'categoryTitle' => 'Главная', 'label' => 'Шаблон актуальных новостей', 'type' => 'select', 'default' => 'sporina-news-all-modern', 'values' => ['sporina-news-all' => 'Обычный', 'sporina-news-all-modern' => 'Современный'], 'templatePath' => 'bitrix/news.index', 'previews' => ['sporina-news-all' => 'images/properties/current_news/sporina-news-all.png', 'sporina-news-all-modern' => 'images/properties/current_news/sporina-news-all-modern.png']],
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
            $settings[$definition['key']] = self::normalize($definition, (string) $value) ?? $definition['default'];
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

        foreach ($normalizedSettings as $key => $normalized) {
            Option::set(self::MODULE_ID, $key, $normalized, SITE_ID);
        }
    }

    public static function reset(): void
    {
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

    private static function normalize(array $definition, string $value): ?string
    {
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
