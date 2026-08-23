<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

$preview = $this->GetFolder() . '/images/properties/';
$yesNo = [
    ['value' => 'Y', 'name' => Loc::getMessage('SPORINA_SETTINGS_YES')],
    ['value' => 'N', 'name' => Loc::getMessage('SPORINA_SETTINGS_NO')],
];
$columnTemplates = [
    ['value' => 'sporina-column-news-cards', 'name' => Loc::getMessage('SPORINA_SETTINGS_TEMPLATE_CARDS'), 'image' => $preview . 'news_and_articles/sporina-column-news-cards.png'],
    ['value' => 'sporina-column-news-company', 'name' => Loc::getMessage('SPORINA_SETTINGS_TEMPLATE_COMPANY'), 'image' => $preview . 'news_and_articles/sporina-column-news-company.png'],
    ['value' => 'sporina-column-news-timeline', 'name' => Loc::getMessage('SPORINA_SETTINGS_TEMPLATE_TIMELINE'), 'image' => $preview . 'news_and_articles/sporina-column-news-timeline.png'],
];

return [
    'common' => [
        ['key' => 'template-color-theme', 'view' => 'list', 'name' => Loc::getMessage('SPORINA_SETTINGS_THEME'), 'values' => [
            ['value' => 'blue', 'name' => Loc::getMessage('SPORINA_SETTINGS_THEME_BLUE')],
            ['value' => 'green', 'name' => Loc::getMessage('SPORINA_SETTINGS_THEME_GREEN')],
            ['value' => 'orange', 'name' => Loc::getMessage('SPORINA_SETTINGS_THEME_ORANGE')],
        ]],
        ['key' => 'template-background-use', 'view' => 'boolean', 'name' => Loc::getMessage('SPORINA_SETTINGS_BACKGROUND_USE')],
        ['key' => 'template-background-color', 'view' => 'color', 'name' => Loc::getMessage('SPORINA_SETTINGS_BACKGROUND_COLOR'), 'palette' => ['#f8fbff', '#ffffff', '#f1f5ff', '#f5f5f5']],
        ['key' => 'template-width', 'view' => 'list', 'name' => Loc::getMessage('SPORINA_SETTINGS_WIDTH'), 'values' => [
            ['value' => '1600', 'name' => '1600 px'],
            ['value' => '1920', 'name' => '1920 px'],
            ['value' => '2560', 'name' => '2560 px'],
        ]],
        ['key' => 'template-font', 'view' => 'list', 'name' => Loc::getMessage('SPORINA_SETTINGS_FONT'), 'values' => [
            ['value' => 'ibm-plex-sans', 'name' => 'IBM Plex Sans'],
            ['value' => 'arial', 'name' => 'Arial'],
            ['value' => 'georgia', 'name' => 'Georgia'],
        ]],
        ['key' => 'template-headings-size', 'view' => 'list', 'name' => Loc::getMessage('SPORINA_SETTINGS_HEADINGS'), 'values' => [
            ['value' => 'compact', 'name' => Loc::getMessage('SPORINA_SETTINGS_SIZE_COMPACT')],
            ['value' => 'normal', 'name' => Loc::getMessage('SPORINA_SETTINGS_SIZE_NORMAL')],
            ['value' => 'large', 'name' => Loc::getMessage('SPORINA_SETTINGS_SIZE_LARGE')],
        ]],
        ['key' => 'template-images-lazyload-use', 'view' => 'boolean', 'name' => Loc::getMessage('SPORINA_SETTINGS_LAZYLOAD')],
    ],
    'header' => [
        ['key' => 'header-template', 'view' => 'list.template', 'name' => Loc::getMessage('SPORINA_SETTINGS_HEADER_TEMPLATE'), 'values' => [
            ['value' => 'default', 'name' => Loc::getMessage('SPORINA_SETTINGS_HEADER_DEFAULT'), 'image' => $preview . 'header/default.png'],
            ['value' => 'overlay', 'name' => Loc::getMessage('SPORINA_SETTINGS_HEADER_OVERLAY'), 'image' => $preview . 'header/overlay.png'],
            ['value' => 'sticky', 'name' => Loc::getMessage('SPORINA_SETTINGS_HEADER_STICKY'), 'image' => $preview . 'header/sticky.png'],
        ]],
    ],
    'footer' => [
        ['key' => 'footer-template', 'view' => 'list.template', 'name' => Loc::getMessage('SPORINA_SETTINGS_FOOTER_TEMPLATE'), 'values' => [
            ['value' => 'big', 'name' => Loc::getMessage('SPORINA_SETTINGS_FOOTER_BIG'), 'image' => $preview . 'footer/big.png'],
            ['value' => 'compact', 'name' => Loc::getMessage('SPORINA_SETTINGS_FOOTER_COMPACT'), 'image' => $preview . 'footer/compact.png'],
        ]],
    ],
    'main' => [
        ['view' => 'blocks', 'name' => Loc::getMessage('SPORINA_SETTINGS_BANNER'), 'use_key' => 'pages-main-banner-use', 'template_key' => 'pages-main-banner-template', 'values' => [
            ['value' => '.default', 'name' => 'Default', 'image' => $preview . 'banner/default.png'],
            ['value' => 'centered', 'name' => 'Centered', 'image' => $preview . 'banner/centered.png'],
            ['value' => 'compact', 'name' => 'Compact', 'image' => $preview . 'banner/compact.png'],
        ]],
        ['view' => 'blocks', 'name' => Loc::getMessage('SPORINA_SETTINGS_INFOCARDS'), 'use_key' => 'pages-main-infocards-use', 'template_key' => 'pages-main-infocards-template', 'values' => [
            ['value' => 'sporina-cards-bayinfo', 'name' => Loc::getMessage('SPORINA_SETTINGS_TEMPLATE_DEFAULT'), 'image' => $preview . 'infocards/sporina-cards-bayinfo.png'],
            ['value' => 'sporina-cards-bayinfo-stack', 'name' => Loc::getMessage('SPORINA_SETTINGS_TEMPLATE_STACK'), 'image' => $preview . 'infocards/sporina-cards-bayinfo-stack.png'],
            ['value' => 'sporina-cards-bayinfo-tiles', 'name' => Loc::getMessage('SPORINA_SETTINGS_TEMPLATE_TILES'), 'image' => $preview . 'infocards/sporina-cards-bayinfo-tiles.png'],
        ]],
        ['key' => 'pages-main-subscribe-use', 'view' => 'boolean', 'name' => Loc::getMessage('SPORINA_SETTINGS_SUBSCRIBE')],
        ['key' => 'pages-main-columns-use', 'view' => 'boolean', 'name' => Loc::getMessage('SPORINA_SETTINGS_COLUMNS_USE')],
        ['key' => 'pages-main-columns-layout', 'view' => 'list', 'name' => Loc::getMessage('SPORINA_SETTINGS_COLUMNS_LAYOUT'), 'values' => [
            ['value' => 'two', 'name' => Loc::getMessage('SPORINA_SETTINGS_COLUMNS_TWO')],
            ['value' => 'stacked', 'name' => Loc::getMessage('SPORINA_SETTINGS_COLUMNS_STACKED')],
        ]],
        ['key' => 'pages-main-articles-template', 'view' => 'list.template', 'name' => Loc::getMessage('SPORINA_SETTINGS_ARTICLES_TEMPLATE'), 'values' => $columnTemplates],
        ['key' => 'pages-main-news-template', 'view' => 'list.template', 'name' => Loc::getMessage('SPORINA_SETTINGS_NEWS_TEMPLATE'), 'values' => $columnTemplates],
        ['key' => 'pages-main-advertising-use', 'view' => 'boolean', 'name' => Loc::getMessage('SPORINA_SETTINGS_ADVERTISING')],
        ['view' => 'blocks', 'name' => Loc::getMessage('SPORINA_SETTINGS_CURRENT_NEWS'), 'use_key' => 'pages-main-current-news-use', 'template_key' => 'pages-main-current-news-template', 'values' => [
            ['value' => 'sporina-news-all', 'name' => 'Sporina News All', 'image' => $preview . 'current_news/sporina-news-all.png'],
            ['value' => 'sporina-news-all-modern', 'name' => 'Sporina News All Modern', 'image' => $preview . 'current_news/sporina-news-all-modern.png'],
        ]],
    ],
    'news' => [],
    'articles' => [],
    'services' => [],
    'products' => [],
    'staff' => [],
    'jobs' => [],
    'contacts' => [],
    'mobile' => [],
];
