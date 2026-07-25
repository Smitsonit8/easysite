<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$details = array();
$ids = array();
foreach ($arResult['ITEMS'] as $item) $ids[] = (int)$item['ID'];
if (!empty($ids)) {
    $result = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $ids), false, false, array('ID', 'DETAIL_TEXT', 'DETAIL_TEXT_TYPE'));
    while ($row = $result->Fetch()) $details[(int)$row['ID']] = $row;
}

$sections = array();
foreach ($arResult['ITEMS'] as $index => $item) {
    $detail = isset($details[(int)$item['ID']]) ? $details[(int)$item['ID']] : array();
    $description = trim((string)$item['PREVIEW_TEXT']);
    if ($description === '' && !empty($detail['DETAIL_TEXT'])) $description = $detail['DETAIL_TEXT'];
    $item['SPORINA_DESCRIPTION'] = $description;
    $arResult['ITEMS'][$index]['SPORINA_DESCRIPTION'] = $description;
    $sectionId = !empty($item['IBLOCK_SECTION_ID']) ? (int)$item['IBLOCK_SECTION_ID'] : 0;
    if (!isset($sections[$sectionId])) {
        $sectionName = GetMessage('SPORINA_VACANCIES_WITHOUT_SECTION');
        if ($sectionId > 0 && ($section = CIBlockSection::GetByID($sectionId)->Fetch())) $sectionName = $section['NAME'];
        $sections[$sectionId] = array('ID' => $sectionId, 'NAME' => $sectionName, 'ITEMS' => array());
    }
    $sections[$sectionId]['ITEMS'][] = $item;
}
$arResult['SPORINA_SECTIONS'] = $sections;
