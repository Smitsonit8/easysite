<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$propertyCodes = isset($arParams['DETAIL_PROPERTY_CODE']) && is_array($arParams['DETAIL_PROPERTY_CODE']) ? $arParams['DETAIL_PROPERTY_CODE'] : array();
foreach (array('CITY', 'SKILL', 'TYPE_EMPLOYMENT', 'SALARY') as $property) {
    $code = isset($arParams['PROPERTY_'.$property]) ? $arParams['PROPERTY_'.$property] : '';
    if ($code !== '' && !in_array($code, $propertyCodes, true)) $propertyCodes[] = $code;
}
$APPLICATION->IncludeComponent('bitrix:news.detail', 'default', array_merge($arParams, array(
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'], 'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
    'FIELD_CODE' => $arParams['DETAIL_FIELD_CODE'], 'PROPERTY_CODE' => $propertyCodes, 'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'], 'IBLOCK_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news'],
    'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'], 'CACHE_GROUPS' => $arParams['CACHE_GROUPS'], 'SET_TITLE' => $arParams['SET_TITLE'],
    'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'], 'CHECK_DATES' => $arParams['CHECK_DATES']
)), $component);
