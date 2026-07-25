<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$propertyCodes = isset($arParams['DETAIL_PROPERTY_CODE']) && is_array($arParams['DETAIL_PROPERTY_CODE']) ? $arParams['DETAIL_PROPERTY_CODE'] : array();
foreach (array('CITY', 'SKILL', 'TYPE_EMPLOYMENT', 'SALARY') as $property) { $code = isset($arParams['PROPERTY_'.$property]) ? $arParams['PROPERTY_'.$property] : ''; if ($code !== '' && !in_array($code, $propertyCodes, true)) $propertyCodes[] = $code; }
$showMenu = isset($arParams['DETAIL_MENU_SHOW']) && $arParams['DETAIL_MENU_SHOW'] === 'Y' && !empty($arParams['MENU_ROOT']);
if ($showMenu) {
    $menu = new CMenu($arParams['MENU_ROOT']);
    $showMenu = $menu->Init($APPLICATION->GetCurDir(), true) && !empty($menu->arMenu);
}
?>
<div class="sporina-vacancies-layout<?=$showMenu ? ' sporina-vacancies-layout--menu' : ''?>"><?php if ($showMenu): ?><aside class="sporina-vacancies-layout__menu"><?php $APPLICATION->IncludeComponent('bitrix:menu', 'default', array('ROOT_MENU_TYPE' => $arParams['MENU_ROOT'], 'CHILD_MENU_TYPE' => $arParams['MENU_CHILD'], 'MAX_LEVEL' => $arParams['MENU_LEVEL'], 'USE_EXT' => 'Y', 'DELAY' => 'N', 'ALLOW_MULTI_SELECT' => 'N', 'MENU_CACHE_TYPE' => $arParams['CACHE_TYPE'], 'MENU_CACHE_TIME' => $arParams['CACHE_TIME'], 'MENU_CACHE_USE_GROUPS' => $arParams['CACHE_GROUPS']), $component); ?></aside><?php endif; ?><div class="sporina-vacancies-layout__content"><?php $APPLICATION->IncludeComponent('bitrix:news.detail', 'default', array_merge($arParams, array('IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'], 'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'], 'FIELD_CODE' => $arParams['DETAIL_FIELD_CODE'], 'PROPERTY_CODE' => $propertyCodes, 'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'], 'IBLOCK_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news'], 'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'], 'CACHE_GROUPS' => $arParams['CACHE_GROUPS'], 'SET_TITLE' => $arParams['SET_TITLE'], 'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'], 'CHECK_DATES' => $arParams['CHECK_DATES'])), $component); ?></div></div>
