<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arTemplateParameters = [
    'SHOW_SECTION_BADGE' => [
        'PARENT' => 'BASE',
        'NAME' => 'Показывать бейдж раздела',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
    ],
    'SECTION_BADGE_POSITION' => [
        'PARENT' => 'BASE',
        'NAME' => 'Положение бейджа раздела',
        'TYPE' => 'LIST',
        'VALUES' => [
            'left' => 'Слева',
            'right' => 'Справа',
        ],
        'DEFAULT' => 'left',
    ],
];
