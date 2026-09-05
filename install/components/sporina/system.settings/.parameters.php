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
        'DISPLAY_FOR' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_DISPLAY_FOR'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'all' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_DISPLAY_FOR_ALL'),
                'authorized' => Loc::getMessage('SPORINA_SYSTEM_SETTINGS_DISPLAY_FOR_AUTHORIZED'),
            ],
            'DEFAULT' => 'authorized',
        ],
        'PROFILE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Профиль настроек шаблона',
            'TYPE' => 'STRING',
            'DEFAULT' => 'sporina_easy_site',
        ],
    ],
];
