<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"PHONE_1_VALUE" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_PHONE_1_VALUE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"PHONE_1_LABEL" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_PHONE_1_LABEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"PHONE_2_VALUE" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_PHONE_2_VALUE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"PHONE_2_LABEL" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_PHONE_2_LABEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"EMAIL_VALUE" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_EMAIL_VALUE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"EMAIL_LABEL" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_EMAIL_LABEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"ADDRESS_VALUE" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_ADDRESS_VALUE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"ADDRESS_LABEL" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_ADDRESS_LABEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"LICENSE_TEXT" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_LICENSE_TEXT"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"LICENSE_LINK" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_LICENSE_LINK"),
			"TYPE" => "STRING",
			"DEFAULT" => "#",
		),
		"POLICY_TEXT" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_POLICY_TEXT"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"POLICY_LINK" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_POLICY_LINK"),
			"TYPE" => "STRING",
			"DEFAULT" => "#",
		),
		"COPYRIGHT_PRIMARY" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_PRIMARY"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"COPYRIGHT_SECONDARY_PREFIX" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_PREFIX"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"COPYRIGHT_SECONDARY_LINK_TEXT" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_LINK_TEXT"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"COPYRIGHT_SECONDARY_LINK" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_LINK"),
			"TYPE" => "STRING",
			"DEFAULT" => "#",
		),
		"COPYRIGHT_SECONDARY_SUFFIX" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_SUFFIX"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SOCIAL_SHOW" => array(
			"PARENT" => "VISUAL",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_SOCIAL_SHOW"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
	),
);

if (isset($arCurrentValues["SOCIAL_SHOW"]) && $arCurrentValues["SOCIAL_SHOW"] === "Y")
{
	foreach (array("VK", "MAX", "OK", "RUTUBE", "DZEN") as $social)
	{
		$arComponentParameters["PARAMETERS"]["SOCIAL_".$social] = array(
			"PARENT" => "VISUAL",
			"NAME" => Loc::getMessage("SPORINA_FOOTER_SOCIAL_".$social),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
	}
}
