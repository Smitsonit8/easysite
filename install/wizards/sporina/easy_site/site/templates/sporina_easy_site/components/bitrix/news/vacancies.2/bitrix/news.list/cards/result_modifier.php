<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$sections = array();
if (!empty($arParams['IBLOCK_TYPE']) && !empty($arParams['IBLOCK_ID'])) {
    $result = CIBlockSection::GetList(array('SORT' => 'ASC'), array(
        'ACTIVE' => 'Y',
        'SECTION_ID' => false,
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID']
    ));
    while ($section = $result->Fetch()) {
        $section['ITEMS'] = array();
        $sections[(int)$section['ID']] = $section;
    }
}

foreach ($arResult['ITEMS'] as $item) {
    $sectionId = !empty($item['IBLOCK_SECTION_ID']) ? (int)$item['IBLOCK_SECTION_ID'] : 0;
    if (isset($sections[$sectionId])) $sections[$sectionId]['ITEMS'][] = $item;
}

$arResult['SPORINA_SECTIONS'] = $sections;
