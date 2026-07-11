<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);
$arComponentParameters = [
    'PARAMETERS' => [
        'MODE' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_MODE'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'render' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_MODE_RENDER'),
                'configure' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_MODE_CONFIGURE'),
            ],
            'DEFAULT' => 'render',
        ],
        'ACTION_VARIABLE' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_ACTION_VARIABLE'),
            'TYPE' => 'STRING',
            'DEFAULT' => 'sporina-system-settings-action',
        ],
    ],
];
