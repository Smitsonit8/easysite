<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) return;

$arTemplateParameters = array(
    'NEWS_LIST_TEMPLATE' => array(
        'PARENT' => 'BASE',
        'NAME' => GetMessage('SPORINA_STAFF_LIST_TEMPLATE'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'blocks.1' => GetMessage('SPORINA_STAFF_LIST_TEMPLATE_BLOCKS'),
            'list.1' => GetMessage('SPORINA_STAFF_LIST_TEMPLATE_LIST')
        ),
        'DEFAULT' => 'blocks.1'
    ),
    'SOCIAL_SHOW' => array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('SPORINA_STAFF_SOCIAL_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y'
    ),
);

if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $properties = array();
    $result = CIBlockProperty::GetList(array('SORT' => 'ASC'), array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y'));
    while ($property = $result->Fetch()) {
        if ($property['CODE'] !== '' && $property['PROPERTY_TYPE'] === 'S' && empty($property['USER_TYPE'])) {
            $properties[$property['CODE']] = '['.$property['CODE'].'] '.$property['NAME'];
        }
    }
    foreach (array('POSITION', 'PHONE', 'EMAIL', 'SOCIAL_VK', 'SOCIAL_MAX', 'SOCIAL_OK', 'SOCIAL_RUTUBE', 'SOCIAL_DZEN') as $code) {
        $arTemplateParameters['PROPERTY_'.$code] = array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => GetMessage('SPORINA_STAFF_PROPERTY_'.$code),
            'TYPE' => 'LIST',
            'VALUES' => $properties,
            'ADDITIONAL_VALUES' => 'Y'
        );
    }
}
