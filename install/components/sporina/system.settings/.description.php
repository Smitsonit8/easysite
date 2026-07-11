<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);
$arComponentDescription = [
    'NAME' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_NAME'),
    'DESCRIPTION' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_DESCRIPTION'),
    'PATH' => [
        'ID' => 'sporina',
        'NAME' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_GROUP'),
    ],
];
