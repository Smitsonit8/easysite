<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$availableTemplates = array('cards'); $listTemplate = isset($arParams['NEWS_LIST_TEMPLATE']) ? (string)$arParams['NEWS_LIST_TEMPLATE'] : 'cards'; if (!in_array($listTemplate, $availableTemplates, true)) $listTemplate = 'cards';
$propertyCodes = isset($arParams['LIST_PROPERTY_CODE']) && is_array($arParams['LIST_PROPERTY_CODE']) ? $arParams['LIST_PROPERTY_CODE'] : array();
foreach (array('CITY', 'EXP', 'TYPE', 'WAGE') as $property) { $code = isset($arParams['PROPERTY_'.$property]) ? $arParams['PROPERTY_'.$property] : ''; if ($code !== '' && !in_array($code, $propertyCodes, true)) $propertyCodes[] = $code; }
$showMenu = isset($arParams['LIST_MENU_SHOW']) && $arParams['LIST_MENU_SHOW'] === 'Y' && !empty($arParams['MENU_ROOT']);
if ($showMenu) {
    $menu = new CMenu($arParams['MENU_ROOT']);
    $showMenu = $menu->Init($APPLICATION->GetCurDir(), true) && !empty($menu->arMenu);
}
?>
<div class="sporina-vacancies-layout<?=$showMenu ? ' sporina-vacancies-layout--menu' : ''?>">
<?php if ($showMenu): ?><aside class="sporina-vacancies-layout__menu"><?php $APPLICATION->IncludeComponent('bitrix:menu', 'default', array('ROOT_MENU_TYPE' => $arParams['MENU_ROOT'], 'CHILD_MENU_TYPE' => $arParams['MENU_CHILD'], 'MAX_LEVEL' => $arParams['MENU_LEVEL'], 'USE_EXT' => 'Y', 'DELAY' => 'N', 'ALLOW_MULTI_SELECT' => 'N', 'MENU_CACHE_TYPE' => $arParams['CACHE_TYPE'], 'MENU_CACHE_TIME' => $arParams['CACHE_TIME'], 'MENU_CACHE_USE_GROUPS' => $arParams['CACHE_GROUPS']), $component); ?></aside><?php endif; ?>
<div class="sporina-vacancies-layout__content"><?php $APPLICATION->IncludeComponent('bitrix:news.list', $listTemplate, array_merge($arParams, array('IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'NEWS_COUNT' => $arParams['NEWS_COUNT'], 'SORT_BY1' => $arParams['SORT_BY1'], 'SORT_ORDER1' => $arParams['SORT_ORDER1'], 'SORT_BY2' => $arParams['SORT_BY2'], 'SORT_ORDER2' => $arParams['SORT_ORDER2'], 'FIELD_CODE' => $arParams['LIST_FIELD_CODE'], 'PROPERTY_CODE' => $propertyCodes, 'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'], 'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'], 'CACHE_FILTER' => $arParams['CACHE_FILTER'], 'CACHE_GROUPS' => $arParams['CACHE_GROUPS'], 'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'], 'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'], 'PAGER_TITLE' => $arParams['PAGER_TITLE'], 'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'], 'CHECK_DATES' => $arParams['CHECK_DATES'])), $component); ?></div></div>
