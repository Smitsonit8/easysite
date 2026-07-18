<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
$propertyCodes = is_array($arParams['DETAIL_PROPERTY_CODE']) ? $arParams['DETAIL_PROPERTY_CODE'] : array();
foreach (array('POSITION', 'PHONE', 'EMAIL', 'SOCIAL_VK', 'SOCIAL_MAX', 'SOCIAL_OK', 'SOCIAL_RUTUBE', 'SOCIAL_DZEN') as $property) {
    $code = isset($arParams['PROPERTY_'.$property]) ? $arParams['PROPERTY_'.$property] : '';
    if ($code !== '' && !in_array($code, $propertyCodes, true)) $propertyCodes[] = $code;
}
if (!isset($arParams['DETAIL_FIELD_CODE']) || !is_array($arParams['DETAIL_FIELD_CODE'])) $arParams['DETAIL_FIELD_CODE'] = array();
foreach (array('PREVIEW_PICTURE', 'DETAIL_PICTURE') as $field) {
    if (!in_array($field, $arParams['DETAIL_FIELD_CODE'], true)) $arParams['DETAIL_FIELD_CODE'][] = $field;
}
$APPLICATION->IncludeComponent('bitrix:news.detail', 'staff.1', array_merge($arParams, array(
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'], 'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
    'FIELD_CODE' => $arParams['DETAIL_FIELD_CODE'], 'PROPERTY_CODE' => $propertyCodes,
    'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'], 'IBLOCK_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news'],
    'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'], 'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    'SET_TITLE' => $arParams['SET_TITLE'], 'INCLUDE_IBLOCK_INTO_CHAIN' => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'], 'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'],
    'CHECK_DATES' => $arParams['CHECK_DATES'], 'SOCIAL_SHOW' => $arParams['SOCIAL_SHOW'],
    'PROPERTY_POSITION' => $arParams['PROPERTY_POSITION'], 'PROPERTY_PHONE' => $arParams['PROPERTY_PHONE'], 'PROPERTY_EMAIL' => $arParams['PROPERTY_EMAIL'],
    'PROPERTY_SOCIAL_VK' => $arParams['PROPERTY_SOCIAL_VK'], 'PROPERTY_SOCIAL_MAX' => $arParams['PROPERTY_SOCIAL_MAX'], 'PROPERTY_SOCIAL_OK' => $arParams['PROPERTY_SOCIAL_OK'], 'PROPERTY_SOCIAL_RUTUBE' => $arParams['PROPERTY_SOCIAL_RUTUBE'], 'PROPERTY_SOCIAL_DZEN' => $arParams['PROPERTY_SOCIAL_DZEN']
)), $component);
