<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

/** @var array $arCurrentValues */

$arTemplateParameters = array(
	"NEWS_LIST_TEMPLATE" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("T_IBLOCK_LIST_TEMPLATE"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"stand" => "stand",
			"smoothness" => "smoothness",
			"layering" => "layering",
		),
		"DEFAULT" => "stand",
	),
	"NEWS_DETAIL_TEMPLATE" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("T_IBLOCK_DETAIL_TEMPLATE"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"stand" => "stand",
			"smoothness" => "smoothness",
			"layering" => "layering",
		),
		"DEFAULT" => "stand",
	),
	'SHOW_SECTION_BADGE' => [
        'PARENT' => 'BASE',
        'NAME' => GetMessage("T_IBLOCK_SECTION_BADGE"),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
    ],
    'SECTION_BADGE_POSITION' => [
        'PARENT' => 'BASE',
        'NAME' => GetMessage("T_IBLOCK_SECTION_BADGE_POSITION"),
        'TYPE' => 'LIST',
        'VALUES' => [
            'left' => 'Слева',
            'right' => 'Справа',
        ],
        'DEFAULT' => 'left',
    ],
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
);

if (($arCurrentValues['USE_SHARE'] ?? 'N') === 'Y')
{
	$arTemplateParameters["SHARE_HIDE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
		"TYPE" => "CHECKBOX",
		"VALUE" => "Y",
		"DEFAULT" => "N",
	);

	$arTemplateParameters["SHARE_TEMPLATE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
		"DEFAULT" => "sporina-social-share",
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"REFRESH"=> "Y",
	);

	$arTemplateParameters["SHARE_MAX"] = array(
		"NAME" => "MAX",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);

	$arTemplateParameters["SHARE_VK"] = array(
		"NAME" => "VK",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);

	$arTemplateParameters["SHARE_OK"] = array(
		"NAME" => "OK",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);

	$arTemplateParameters["SHARE_MAIL"] = array(
		"NAME" => "Mail",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
}
