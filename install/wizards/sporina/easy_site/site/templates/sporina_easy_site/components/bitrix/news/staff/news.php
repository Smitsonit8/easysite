<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
$availableNewsListTemplates = array('blocks.1', 'list.1');
$newsListTemplate = isset($arParams['NEWS_LIST_TEMPLATE']) ? (string)$arParams['NEWS_LIST_TEMPLATE'] : 'blocks.1';
if (!in_array($newsListTemplate, $availableNewsListTemplates, true)) $newsListTemplate = 'blocks.1';

$propertyCodes = is_array($arParams['LIST_PROPERTY_CODE']) ? $arParams['LIST_PROPERTY_CODE'] : array();
foreach (array('POSITION', 'PHONE', 'EMAIL', 'SOCIAL_VK', 'SOCIAL_MAX', 'SOCIAL_OK', 'SOCIAL_RUTUBE', 'SOCIAL_DZEN') as $property) {
    $code = isset($arParams['PROPERTY_'.$property]) ? $arParams['PROPERTY_'.$property] : '';
    if ($code !== '' && !in_array($code, $propertyCodes, true)) $propertyCodes[] = $code;
}

$APPLICATION->IncludeComponent('bitrix:news.list', $newsListTemplate, array_merge($arParams, array(
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'NEWS_COUNT' => $arParams['NEWS_COUNT'], 'SORT_BY1' => $arParams['SORT_BY1'], 'SORT_ORDER1' => $arParams['SORT_ORDER1'],
    'SORT_BY2' => $arParams['SORT_BY2'], 'SORT_ORDER2' => $arParams['SORT_ORDER2'],
    'FIELD_CODE' => $arParams['LIST_FIELD_CODE'], 'PROPERTY_CODE' => $propertyCodes,
    'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'],
    'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'], 'CACHE_FILTER' => $arParams['CACHE_FILTER'], 'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'], 'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'], 'PAGER_TITLE' => $arParams['PAGER_TITLE'], 'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
    'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'], 'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'], 'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
    'CHECK_DATES' => $arParams['CHECK_DATES'], 'SET_TITLE' => $arParams['SET_TITLE'], 'INCLUDE_IBLOCK_INTO_CHAIN' => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
    'SOCIAL_SHOW' => $arParams['SOCIAL_SHOW'],
    'PROPERTY_POSITION' => $arParams['PROPERTY_POSITION'], 'PROPERTY_PHONE' => $arParams['PROPERTY_PHONE'], 'PROPERTY_EMAIL' => $arParams['PROPERTY_EMAIL'],
    'PROPERTY_SOCIAL_VK' => $arParams['PROPERTY_SOCIAL_VK'], 'PROPERTY_SOCIAL_MAX' => $arParams['PROPERTY_SOCIAL_MAX'], 'PROPERTY_SOCIAL_OK' => $arParams['PROPERTY_SOCIAL_OK'], 'PROPERTY_SOCIAL_RUTUBE' => $arParams['PROPERTY_SOCIAL_RUTUBE'], 'PROPERTY_SOCIAL_DZEN' => $arParams['PROPERTY_SOCIAL_DZEN']
)), $component);
