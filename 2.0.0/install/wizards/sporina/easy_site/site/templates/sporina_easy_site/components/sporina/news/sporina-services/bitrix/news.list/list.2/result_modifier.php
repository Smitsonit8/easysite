<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arParams['SHOW_SECTION_BADGE'] = ($arParams['SHOW_SECTION_BADGE'] ?? 'Y') === 'N' ? 'N' : 'Y';
$arParams['SECTION_BADGE_POSITION'] = ($arParams['SECTION_BADGE_POSITION'] ?? 'left') === 'right'
    ? 'right'
    : 'left';

if (empty($arResult['ITEMS']) || !CModule::IncludeModule('iblock')) {
    return;
}

$sectionIds = [];
foreach ($arResult['ITEMS'] as $arItem) {
    if (!empty($arItem['IBLOCK_SECTION_ID'])) {
        $sectionIds[(int)$arItem['IBLOCK_SECTION_ID']] = (int)$arItem['IBLOCK_SECTION_ID'];
    }
}

if (empty($sectionIds)) {
    return;
}

$sectionNames = [];
$sectionResult = CIBlockSection::GetList(
    [],
    ['ID' => $sectionIds, 'ACTIVE' => 'Y'],
    false,
    ['ID', 'NAME']
);

while ($arSection = $sectionResult->Fetch()) {
    $sectionNames[(int)$arSection['ID']] = $arSection['NAME'];
}

foreach ($arResult['ITEMS'] as &$arItem) {
    $sectionId = (int)($arItem['IBLOCK_SECTION_ID'] ?? 0);
    $arItem['SECTION_NAME'] = $sectionNames[$sectionId] ?? '';
}
unset($arItem);
