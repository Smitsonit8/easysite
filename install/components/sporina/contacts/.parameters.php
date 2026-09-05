<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$contactPropertyOptions = array("" => Loc::getMessage("SPORINA_CONTACTS_DEFAULT_PROPERTY"));
if (CModule::IncludeModule("iblock"))
{
	$iblockResult = CIBlock::GetList(array(), array("TYPE" => "easy_infocompany", "CODE" => "company_contacts_v1"));
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
		"DISPLAY" => array("NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_DISPLAY"), "SORT" => 100),
		"COMPANY_PROPERTIES" => array("NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_COMPANY_PROPERTIES"), "SORT" => 200),
		"PHONE_PROPERTIES" => array("NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_PHONE_PROPERTIES"), "SORT" => 300),
		"SCHEDULE_PROPERTIES" => array("NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_SCHEDULE_PROPERTIES"), "SORT" => 400),
		"MAP_PROPERTIES" => array("NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_MAP_PROPERTIES"), "SORT" => 500),
	),
	"PARAMETERS" => array(
		"SHOW_FULL_NAME" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_FULL_NAME"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 100),
		"SHOW_SHORT_NAME" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_SHORT_NAME"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 110),
		"SHOW_LEGAL_ADDRESS" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_LEGAL_ADDRESS"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 120),
		"SHOW_ACTUAL_ADDRESS" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_ACTUAL_ADDRESS"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 130),
		"SHOW_EMAIL" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_EMAIL"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 140),
		"SHOW_PHONE_1" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_PHONE_1"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 200),
		"SHOW_PHONE_2" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_PHONE_2"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 210),
		"SHOW_WORK_HOURS" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_WORK_HOURS"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 300),
		"SHOW_WEEKENDS" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_WEEKENDS"), "TYPE" => "CHECKBOX", "DEFAULT" => "Y", "SORT" => 310),
		"SHOW_MAP" => array("PARENT" => "DISPLAY", "NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_MAP"), "TYPE" => "CHECKBOX", "DEFAULT" => "N", "SORT" => 400),
		"CACHE_TIME" => array("DEFAULT" => 36000000),
	),
);

$iblockPropertyParameters = array(
	"IBLOCK_PROPERTY_FULL_NAME" => array("GROUP" => "COMPANY_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_FULL_NAME", "DEFAULT" => "FULL_NAME", "SORT" => 100),
	"IBLOCK_PROPERTY_SHORT_NAME" => array("GROUP" => "COMPANY_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_SHORT_NAME", "DEFAULT" => "SHORT_NAME", "SORT" => 110),
	"IBLOCK_PROPERTY_LEGAL_ADDRESS" => array("GROUP" => "COMPANY_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_LEGAL_ADDRESS", "DEFAULT" => "LEGAL_ADDRESS", "SORT" => 120),
	"IBLOCK_PROPERTY_ACTUAL_ADDRESS" => array("GROUP" => "COMPANY_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_ACTUAL_ADDRESS", "DEFAULT" => "ACTUAL_ADDRESS", "SORT" => 130),
	"IBLOCK_PROPERTY_EMAIL" => array("GROUP" => "COMPANY_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_EMAIL", "DEFAULT" => "EMAIL", "SORT" => 140),
	"IBLOCK_PROPERTY_EMAIL_NOTE" => array("GROUP" => "COMPANY_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_EMAIL_NOTE", "DEFAULT" => "EMAIL_NOTE", "SORT" => 150),
	"IBLOCK_PROPERTY_PHONE_1" => array("GROUP" => "PHONE_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_PHONE_1", "DEFAULT" => "PHONE_1", "SORT" => 100),
	"IBLOCK_PROPERTY_PHONE_1_LABEL" => array("GROUP" => "PHONE_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_PHONE_1_LABEL", "DEFAULT" => "PHONE_1_LABEL", "SORT" => 110),
	"IBLOCK_PROPERTY_PHONE_2" => array("GROUP" => "PHONE_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_PHONE_2", "DEFAULT" => "PHONE_2", "SORT" => 120),
	"IBLOCK_PROPERTY_PHONE_2_LABEL" => array("GROUP" => "PHONE_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_PHONE_2_LABEL", "DEFAULT" => "PHONE_2_LABEL", "SORT" => 130),
	"IBLOCK_PROPERTY_WORK_HOURS" => array("GROUP" => "SCHEDULE_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_WORK_HOURS", "DEFAULT" => "WORK_HOURS", "SORT" => 100),
	"IBLOCK_PROPERTY_WEEKENDS" => array("GROUP" => "SCHEDULE_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_WEEKENDS", "DEFAULT" => "WEEKENDS", "SORT" => 110),
	"IBLOCK_PROPERTY_YANDEX_MAP_LAT" => array("GROUP" => "MAP_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_MAP_LAT", "DEFAULT" => "MAP_LAT", "SORT" => 100),
	"IBLOCK_PROPERTY_YANDEX_MAP_LON" => array("GROUP" => "MAP_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_MAP_LON", "DEFAULT" => "MAP_LON", "SORT" => 110),
	"IBLOCK_PROPERTY_MAP_TITLE" => array("GROUP" => "MAP_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_MAP_TITLE", "DEFAULT" => "MAP_TITLE", "SORT" => 120),
	"IBLOCK_PROPERTY_MAP_HEIGHT" => array("GROUP" => "MAP_PROPERTIES", "NAME" => "SPORINA_CONTACTS_IBLOCK_MAP_HEIGHT", "DEFAULT" => "MAP_HEIGHT", "SORT" => 130),
);

foreach ($iblockPropertyParameters as $parameterCode => $parameter)
{
	$arComponentParameters["PARAMETERS"][$parameterCode] = array(
		"PARENT" => $parameter["GROUP"],
		"NAME" => Loc::getMessage($parameter["NAME"]),
		"TYPE" => "LIST",
		"VALUES" => $contactPropertyOptions,
		"DEFAULT" => $parameter["DEFAULT"],
		"SORT" => $parameter["SORT"],
	);
}
