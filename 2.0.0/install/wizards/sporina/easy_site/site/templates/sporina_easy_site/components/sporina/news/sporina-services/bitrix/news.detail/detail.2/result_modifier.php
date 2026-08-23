<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arResult['SECTION_NAME'] = '';

if (empty($arResult['IBLOCK_SECTION_ID']) || !CModule::IncludeModule('iblock')) {
    return;
}

$sectionResult = CIBlockSection::GetList(
    [],
    [
        'ID' => (int)$arResult['IBLOCK_SECTION_ID'],
        'ACTIVE' => 'Y',
    ],
    false,
    ['NAME']
);

if ($arSection = $sectionResult->Fetch()) {
    $arResult['SECTION_NAME'] = $arSection['NAME'];
}
