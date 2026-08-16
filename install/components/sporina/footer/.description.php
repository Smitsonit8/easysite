<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage("SPORINA_FOOTER_COMPONENT_NAME"),
	"DESCRIPTION" => Loc::getMessage("SPORINA_FOOTER_COMPONENT_DESCRIPTION"),
	"PATH" => array(
		"ID" => "sporina",
		"NAME" => Loc::getMessage("SPORINA_FOOTER_COMPONENT_SECTION"),
	),
);
