<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$sectionIds = [];
foreach ($arResult['ITEMS'] as $item) {
    if (!empty($item['IBLOCK_SECTION_ID'])) {
        $sectionIds[] = (int)$item['IBLOCK_SECTION_ID'];
    }
}

$sectionIds = array_values(array_unique($sectionIds));
$sections = [];

if ($sectionIds) {
    $dbSections = CIBlockSection::GetList(
        ['SORT' => 'ASC'],
        ['ID' => $sectionIds, 'ACTIVE' => 'Y'],
        false,
        ['ID', 'NAME', 'SECTION_PAGE_URL']
    );

    while ($section = $dbSections->GetNext()) {
        $sections[(int)$section['ID']] = $section;
    }
}

foreach ($arResult['ITEMS'] as &$item) {
    $sectionId = (int)($item['IBLOCK_SECTION_ID'] ?? 0);
    $item['SPORINA_SECTION'] = $sections[$sectionId] ?? null;
}
unset($item);
