<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$contactPropertyOptions = array("" => Loc::getMessage("SPORINA_FOOTER_DEFAULT_PROPERTY"));
if (CModule::IncludeModule("iblock"))
{
	$iblockResult = CIBlock::GetList(array(), array("TYPE" => "easy_infocompany", "CODE" => "company_contacts"));
	if ($iblock = $iblockResult->Fetch())
	{
		$propertyResult = CIBlockProperty::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array("IBLOCK_ID" => $iblock["ID"], "ACTIVE" => "Y"));
		while ($property = $propertyResult->Fetch())
		{
			$contactPropertyOptions[$property["CODE"]] = "[" . $property["CODE"] . "] " . $property["NAME"];
		}
	}
}

$arComponentParameters = array(
	"GROUPS" => array(
		"FOOTER_CONTENT" => array("NAME" => Loc::getMessage("SPORINA_FOOTER_GROUP_CONTENT"), "SORT" => 100),
		"COPYRIGHT" => array("NAME" => Loc::getMessage("SPORINA_FOOTER_GROUP_COPYRIGHT"), "SORT" => 200),
		"SOCIAL" => array("NAME" => Loc::getMessage("SPORINA_FOOTER_GROUP_SOCIAL"), "SORT" => 300),
		"CONTACT_PROPERTIES" => array("NAME" => Loc::getMessage("SPORINA_FOOTER_GROUP_CONTACT_PROPERTIES"), "SORT" => 400),
		"SOCIAL_PROPERTIES" => array("NAME" => Loc::getMessage("SPORINA_FOOTER_GROUP_SOCIAL_PROPERTIES"), "SORT" => 500),
	),
	"PARAMETERS" => array(
		"LICENSE_TEXT" => array("PARENT" => "FOOTER_CONTENT", "NAME" => Loc::getMessage("SPORINA_FOOTER_LICENSE_TEXT"), "TYPE" => "STRING", "DEFAULT" => "", "SORT" => 100),
		"LICENSE_LINK" => array("PARENT" => "FOOTER_CONTENT", "NAME" => Loc::getMessage("SPORINA_FOOTER_LICENSE_LINK"), "TYPE" => "STRING", "DEFAULT" => "#", "SORT" => 110),
		"POLICY_TEXT" => array("PARENT" => "FOOTER_CONTENT", "NAME" => Loc::getMessage("SPORINA_FOOTER_POLICY_TEXT"), "TYPE" => "STRING", "DEFAULT" => "", "SORT" => 200),
		"POLICY_LINK" => array("PARENT" => "FOOTER_CONTENT", "NAME" => Loc::getMessage("SPORINA_FOOTER_POLICY_LINK"), "TYPE" => "STRING", "DEFAULT" => "#", "SORT" => 210),
		"COPYRIGHT_SECONDARY_PREFIX" => array("PARENT" => "COPYRIGHT", "NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_PREFIX"), "TYPE" => "STRING", "DEFAULT" => "", "SORT" => 100),
		"COPYRIGHT_SECONDARY_LINK_TEXT" => array("PARENT" => "COPYRIGHT", "NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_LINK_TEXT"), "TYPE" => "STRING", "DEFAULT" => "", "SORT" => 110),
		"COPYRIGHT_SECONDARY_LINK" => array("PARENT" => "COPYRIGHT", "NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_LINK"), "TYPE" => "STRING", "DEFAULT" => "#", "SORT" => 120),
		"COPYRIGHT_SECONDARY_SUFFIX" => array("PARENT" => "COPYRIGHT", "NAME" => Loc::getMessage("SPORINA_FOOTER_COPYRIGHT_SECONDARY_SUFFIX"), "TYPE" => "STRING", "DEFAULT" => "", "SORT" => 130),
		"SOCIAL_SHOW" => array("PARENT" => "SOCIAL", "NAME" => Loc::getMessage("SPORINA_FOOTER_SOCIAL_SHOW"), "TYPE" => "CHECKBOX", "DEFAULT" => "N", "REFRESH" => "Y", "SORT" => 100),
	),
);

$iblockPropertyParameters = array(
	"IBLOCK_PROPERTY_PHONE_1_VALUE" => array("NAME" => "SPORINA_FOOTER_IBLOCK_PHONE_1_VALUE", "DEFAULT" => "PHONE_1", "SORT" => 100),
	"IBLOCK_PROPERTY_PHONE_1_LABEL" => array("NAME" => "SPORINA_FOOTER_IBLOCK_PHONE_1_LABEL", "DEFAULT" => "PHONE_1_LABEL", "SORT" => 110),
	"IBLOCK_PROPERTY_PHONE_2_VALUE" => array("NAME" => "SPORINA_FOOTER_IBLOCK_PHONE_2_VALUE", "DEFAULT" => "PHONE_2", "SORT" => 120),
	"IBLOCK_PROPERTY_PHONE_2_LABEL" => array("NAME" => "SPORINA_FOOTER_IBLOCK_PHONE_2_LABEL", "DEFAULT" => "PHONE_2_LABEL", "SORT" => 130),
	"IBLOCK_PROPERTY_EMAIL_VALUE" => array("NAME" => "SPORINA_FOOTER_IBLOCK_EMAIL_VALUE", "DEFAULT" => "EMAIL", "SORT" => 140),
	"IBLOCK_PROPERTY_EMAIL_LABEL" => array("NAME" => "SPORINA_FOOTER_IBLOCK_EMAIL_LABEL", "DEFAULT" => "EMAIL_NOTE", "SORT" => 150),
	"IBLOCK_PROPERTY_ADDRESS_VALUE" => array("NAME" => "SPORINA_FOOTER_IBLOCK_ADDRESS_VALUE", "DEFAULT" => "ACTUAL_ADDRESS", "SORT" => 160),
	"IBLOCK_PROPERTY_ADDRESS_LABEL" => array("NAME" => "SPORINA_FOOTER_IBLOCK_ADDRESS_LABEL", "DEFAULT" => "ACTUAL_ADDRESS_LABEL", "SORT" => 170),
	"IBLOCK_PROPERTY_COPYRIGHT_PRIMARY" => array("NAME" => "SPORINA_FOOTER_IBLOCK_COPYRIGHT_PRIMARY", "DEFAULT" => "COPYRIGHT_PRIMARY", "SORT" => 180),
	"IBLOCK_PROPERTY_SOCIAL_VK" => array("NAME" => "SPORINA_FOOTER_IBLOCK_SOCIAL_VK", "DEFAULT" => "SOCIAL_VK", "SORT" => 100),
	"IBLOCK_PROPERTY_SOCIAL_MAX" => array("NAME" => "SPORINA_FOOTER_IBLOCK_SOCIAL_MAX", "DEFAULT" => "SOCIAL_MAX", "SORT" => 110),
	"IBLOCK_PROPERTY_SOCIAL_OK" => array("NAME" => "SPORINA_FOOTER_IBLOCK_SOCIAL_OK", "DEFAULT" => "SOCIAL_OK", "SORT" => 120),
	"IBLOCK_PROPERTY_SOCIAL_RUTUBE" => array("NAME" => "SPORINA_FOOTER_IBLOCK_SOCIAL_RUTUBE", "DEFAULT" => "SOCIAL_RUTUBE", "SORT" => 130),
	"IBLOCK_PROPERTY_SOCIAL_DZEN" => array("NAME" => "SPORINA_FOOTER_IBLOCK_SOCIAL_DZEN", "DEFAULT" => "SOCIAL_DZEN", "SORT" => 140),
);
$socialPropertyParameters = array("IBLOCK_PROPERTY_SOCIAL_VK", "IBLOCK_PROPERTY_SOCIAL_MAX", "IBLOCK_PROPERTY_SOCIAL_OK", "IBLOCK_PROPERTY_SOCIAL_RUTUBE", "IBLOCK_PROPERTY_SOCIAL_DZEN");
$socialEnabled = isset($arCurrentValues["SOCIAL_SHOW"]) && $arCurrentValues["SOCIAL_SHOW"] === "Y";

foreach ($iblockPropertyParameters as $parameterCode => $parameter)
{
	if (in_array($parameterCode, $socialPropertyParameters, true) && !$socialEnabled)
	{
		continue;
	}

	$arComponentParameters["PARAMETERS"][$parameterCode] = array(
		"PARENT" => in_array($parameterCode, $socialPropertyParameters, true) ? "SOCIAL_PROPERTIES" : "CONTACT_PROPERTIES",
		"NAME" => Loc::getMessage($parameter["NAME"]),
		"TYPE" => "LIST",
		"VALUES" => $contactPropertyOptions,
		"DEFAULT" => $parameter["DEFAULT"],
		"SORT" => $parameter["SORT"],
	);
}
