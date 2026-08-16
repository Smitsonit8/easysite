<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"LOGO_LINK" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_HEADER_LOGO_LINK"),
			"TYPE" => "STRING",
			"DEFAULT" => SITE_DIR,
		),
		"LOGO_SRC" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_HEADER_LOGO_SRC"),
			"TYPE" => "STRING",
			"DEFAULT" => "img/logo.svg",
		),
		"LOGO_ALT" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_HEADER_LOGO_ALT"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SEARCH_LINK" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_HEADER_SEARCH_LINK"),
			"TYPE" => "STRING",
			"DEFAULT" => SITE_DIR . "poisk/",
		),
		"ROOT_MENU_TYPE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => Loc::getMessage("SPORINA_HEADER_ROOT_MENU_TYPE"),
			"TYPE" => "STRING",
			"DEFAULT" => "top",
		),
		"CHILD_MENU_TYPE" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => Loc::getMessage("SPORINA_HEADER_CHILD_MENU_TYPE"),
			"TYPE" => "STRING",
			"DEFAULT" => "left",
		),
		"MAX_LEVEL" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => Loc::getMessage("SPORINA_HEADER_MAX_LEVEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "1",
		),
		"MENU_CACHE_TYPE" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => Loc::getMessage("SPORINA_HEADER_MENU_CACHE_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"A" => Loc::getMessage("SPORINA_HEADER_MENU_CACHE_TYPE_AUTO"),
				"Y" => Loc::getMessage("SPORINA_HEADER_MENU_CACHE_TYPE_YES"),
				"N" => Loc::getMessage("SPORINA_HEADER_MENU_CACHE_TYPE_NO"),
			),
			"DEFAULT" => "N",
		),
		"MENU_CACHE_TIME" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => Loc::getMessage("SPORINA_HEADER_MENU_CACHE_TIME"),
			"TYPE" => "STRING",
			"DEFAULT" => "3600",
		),
	),
);
