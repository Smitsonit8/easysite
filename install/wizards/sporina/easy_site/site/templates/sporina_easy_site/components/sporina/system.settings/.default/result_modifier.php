<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__DIR__ . '/template.php');

$arResult['CATEGORIES'] = [
    'common' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_COMMON'),
    'header' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_HEADER'),
    'footer' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_FOOTER'),
    'main' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_MAIN'),
    'news' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_NEWS'),
    'articles' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_ARTICLES'),
    'services' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_SERVICES'),
    'products' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_PRODUCTS'),
    'staff' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_STAFF'),
    'jobs' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_JOBS'),
    'contacts' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_CONTACTS'),
    'mobile' => Loc::getMessage('SPORINA_SETTINGS_CATEGORY_MOBILE'),
];

$arResult['PROPERTIES'] = include __DIR__ . '/modifiers/properties.php';
$active = (string)($arResult['ACTIVE_CATEGORY'] ?? '');
$arResult['ACTIVE_CATEGORY'] = isset($arResult['CATEGORIES'][$active]) ? $active : 'common';
