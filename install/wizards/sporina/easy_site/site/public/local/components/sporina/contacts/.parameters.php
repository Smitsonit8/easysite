<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"GROUPS" => array(
		"COMPANY" => array(
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_COMPANY"),
			"SORT" => 100,
		),
		"PHONES" => array(
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_PHONES"),
			"SORT" => 200,
		),
		"SCHEDULE" => array(
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_SCHEDULE"),
			"SORT" => 300,
		),
		"MAP" => array(
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_GROUP_MAP"),
			"SORT" => 400,
		),
	),
	"PARAMETERS" => array(
		"SHOW_FULL_NAME" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_FULL_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"FULL_NAME" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_FULL_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_SHORT_NAME" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_SHORT_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"SHORT_NAME" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHORT_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_LEGAL_ADDRESS" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_LEGAL_ADDRESS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"LEGAL_ADDRESS" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_LEGAL_ADDRESS"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_ACTUAL_ADDRESS" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_ACTUAL_ADDRESS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"ACTUAL_ADDRESS" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_ACTUAL_ADDRESS"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_EMAIL" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_EMAIL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"EMAIL" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_EMAIL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"EMAIL_NOTE" => array(
			"PARENT" => "COMPANY",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_EMAIL_NOTE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_PHONE_1" => array(
			"PARENT" => "PHONES",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_PHONE_1"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"PHONE_1" => array(
			"PARENT" => "PHONES",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_PHONE_1"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"PHONE_1_LABEL" => array(
			"PARENT" => "PHONES",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_PHONE_1_LABEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_PHONE_2" => array(
			"PARENT" => "PHONES",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_PHONE_2"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"PHONE_2" => array(
			"PARENT" => "PHONES",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_PHONE_2"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"PHONE_2_LABEL" => array(
			"PARENT" => "PHONES",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_PHONE_2_LABEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_WORK_HOURS" => array(
			"PARENT" => "SCHEDULE",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_WORK_HOURS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"WORK_HOURS" => array(
			"PARENT" => "SCHEDULE",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_WORK_HOURS"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_WEEKENDS" => array(
			"PARENT" => "SCHEDULE",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_WEEKENDS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"WEEKENDS" => array(
			"PARENT" => "SCHEDULE",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_WEEKENDS"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_MAP" => array(
			"PARENT" => "MAP",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_SHOW_MAP"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"YANDEX_MAP_LAT" => array(
			"PARENT" => "MAP",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_YANDEX_MAP_LAT"),
			"TYPE" => "STRING",
			"DEFAULT" => "54.682294",
		),
		"YANDEX_MAP_LON" => array(
			"PARENT" => "MAP",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_YANDEX_MAP_LON"),
			"TYPE" => "STRING",
			"DEFAULT" => "20.454926",
		),
		"MAP_TITLE" => array(
			"PARENT" => "MAP",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_MAP_TITLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"MAP_HEIGHT" => array(
			"PARENT" => "MAP",
			"NAME" => Loc::getMessage("SPORINA_CONTACTS_MAP_HEIGHT"),
			"TYPE" => "STRING",
			"DEFAULT" => "420",
		),
		"CACHE_TIME" => array("DEFAULT" => 36000000),
	),
);
