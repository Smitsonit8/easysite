<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$arTemplateParameters = array(
    'NEWS_LIST_TEMPLATE' => array('PARENT' => 'BASE', 'NAME' => GetMessage('SPORINA_VACANCIES_2_LIST_TEMPLATE'), 'TYPE' => 'LIST', 'VALUES' => array('cards' => GetMessage('SPORINA_VACANCIES_2_LIST_CARDS')), 'DEFAULT' => 'cards'),
);
if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $properties = array(); 
    $result = CIBlockProperty::GetList(array('SORT' => 'ASC'), array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y'));
    while ($property = $result->Fetch()) if ($property['CODE'] !== '') $properties[$property['CODE']] = '['.$property['CODE'].'] '.$property['NAME'];
    foreach (array('CITY', 'EXP', 'TYPE', 'WAGE') as $code) $arTemplateParameters['PROPERTY_'.$code] = array('PARENT' => 'DATA_SOURCE', 'NAME' => GetMessage('SPORINA_VACANCIES_2_PROPERTY_'.$code), 'TYPE' => 'LIST', 'VALUES' => $properties, 'ADDITIONAL_VALUES' => 'Y');
}
