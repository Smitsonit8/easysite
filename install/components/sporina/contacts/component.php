<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$contactValues = array();
if (CModule::IncludeModule("iblock"))
{
	$iblockResult = CIBlock::GetList(array(), array(
		"TYPE" => "easy_infocompany",
		"CODE" => "company_contacts_v1",
		"ACTIVE" => "Y",
	));
	if ($iblock = $iblockResult->Fetch())
	{
		$elementResult = CIBlockElement::GetList(array(), array(
			"IBLOCK_ID" => $iblock["ID"],
			"ACTIVE" => "Y",
			"CODE" => "company_contacts_v1",
		), false, array("nTopCount" => 1), array("ID", "IBLOCK_ID"));
		if ($element = $elementResult->GetNextElement())
		{
			foreach ($element->GetProperties() as $propertyCode => $property)
			{
				$contactValues[$propertyCode] = trim((string)($property["VALUE"] ?? ""));
			}
		}
	}
}

$propertyMap = array(
	"FULL_NAME" => "FULL_NAME",
	"SHORT_NAME" => "SHORT_NAME",
	"PHONE_1" => "PHONE_1",
	"PHONE_1_LABEL" => "PHONE_1_LABEL",
	"PHONE_2" => "PHONE_2",
	"PHONE_2_LABEL" => "PHONE_2_LABEL",
	"EMAIL" => "EMAIL",
	"EMAIL_NOTE" => "EMAIL_NOTE",
	"LEGAL_ADDRESS" => "LEGAL_ADDRESS",
	"ACTUAL_ADDRESS" => "ACTUAL_ADDRESS",
	"WORK_HOURS" => "WORK_HOURS",
	"WEEKENDS" => "WEEKENDS",
	"YANDEX_MAP_LAT" => "MAP_LAT",
	"YANDEX_MAP_LON" => "MAP_LON",
	"MAP_TITLE" => "MAP_TITLE",
	"MAP_HEIGHT" => "MAP_HEIGHT",
);

$iblockOnlyKeys = array_keys($propertyMap);
$getValue = static function ($key) use ($arParams, $contactValues, $propertyMap, $iblockOnlyKeys)
{
	$selectedPropertyCode = trim((string)($arParams["IBLOCK_PROPERTY_" . $key] ?? ""));
	$propertyCode = $selectedPropertyCode !== "" ? $selectedPropertyCode : ($propertyMap[$key] ?? "");
	if ($propertyCode !== "" && ($contactValues[$propertyCode] ?? "") !== "")
	{
		return $contactValues[$propertyCode];
	}
	if (in_array($key, $iblockOnlyKeys, true))
	{
		return "";
	}

	return trim((string)($arParams[$key] ?? ""));
};

$isShown = static function ($key) use ($arParams)
{
	return ($arParams[$key] ?? "N") === "Y";
};

$buildTextItem = static function ($show, $label, $value, $type = "text", $note = "") {
	$value = trim((string)$value);
	$note = trim((string)$note);

	return array(
		"SHOW" => $show && $value !== "",
		"LABEL" => $label,
		"VALUE" => $value,
		"TYPE" => $type,
		"NOTE" => $note,
	);
};

$buildPhoneItem = static function ($show, $label, $value) {
	$value = trim((string)$value);
	$href = preg_replace("/[^0-9+]/", "", $value);

	return array(
		"SHOW" => $show && $value !== "",
		"LABEL" => $label,
		"VALUE" => $value,
		"HREF" => $href !== "" ? "tel:" . $href : "",
	);
};

$filterVisibleItems = static function (array $items)
{
	return array_values(array_filter($items, static function ($item) {
		return !empty($item["SHOW"]);
	}));
};

$mapHeight = (int)$getValue("MAP_HEIGHT");
if ($mapHeight <= 0)
{
	$mapHeight = 420;
}

$mapLat = $getValue("YANDEX_MAP_LAT");
$mapLon = $getValue("YANDEX_MAP_LON");

$arResult = array(
	"TITLE" => Loc::getMessage("SPORINA_CONTACTS_TITLE"),
	"INTRO" => array(
		"EYEBROW" => Loc::getMessage("SPORINA_CONTACTS_INTRO_EYEBROW"),
		"TITLE" => Loc::getMessage("SPORINA_CONTACTS_INTRO_TITLE"),
	),
	"COMPANY_ITEMS" => $filterVisibleItems(array(
		$buildTextItem($isShown("SHOW_FULL_NAME"), Loc::getMessage("SPORINA_CONTACTS_LABEL_FULL_NAME"), $getValue("FULL_NAME")),
		$buildTextItem($isShown("SHOW_SHORT_NAME"), Loc::getMessage("SPORINA_CONTACTS_LABEL_SHORT_NAME"), $getValue("SHORT_NAME")),
		$buildTextItem($isShown("SHOW_LEGAL_ADDRESS"), Loc::getMessage("SPORINA_CONTACTS_LABEL_LEGAL_ADDRESS"), $getValue("LEGAL_ADDRESS")),
		$buildTextItem($isShown("SHOW_ACTUAL_ADDRESS"), Loc::getMessage("SPORINA_CONTACTS_LABEL_ACTUAL_ADDRESS"), $getValue("ACTUAL_ADDRESS")),
		$buildTextItem($isShown("SHOW_EMAIL"), Loc::getMessage("SPORINA_CONTACTS_LABEL_EMAIL"), $getValue("EMAIL"), "email", $getValue("EMAIL_NOTE")),
	)),
	"PHONE_ITEMS" => $filterVisibleItems(array(
		$buildPhoneItem($isShown("SHOW_PHONE_1"), $getValue("PHONE_1_LABEL"), $getValue("PHONE_1")),
		$buildPhoneItem($isShown("SHOW_PHONE_2"), $getValue("PHONE_2_LABEL"), $getValue("PHONE_2")),
	)),
	"SCHEDULE_ITEMS" => $filterVisibleItems(array(
		$buildTextItem($isShown("SHOW_WORK_HOURS"), Loc::getMessage("SPORINA_CONTACTS_LABEL_WORK_HOURS"), $getValue("WORK_HOURS")),
		$buildTextItem($isShown("SHOW_WEEKENDS"), Loc::getMessage("SPORINA_CONTACTS_LABEL_WEEKENDS"), $getValue("WEEKENDS")),
	)),
	"MAP" => array(
		"SHOW" => $isShown("SHOW_MAP") && $mapLat !== "" && $mapLon !== "",
		"LAT" => $mapLat,
		"LON" => $mapLon,
		"TITLE" => $getValue("MAP_TITLE") !== "" ? $getValue("MAP_TITLE") : Loc::getMessage("SPORINA_CONTACTS_MAP_DEFAULT_TITLE"),
		"HEIGHT" => $mapHeight,
	),
);

$arResult["SHOW_COMPANY"] = !empty($arResult["COMPANY_ITEMS"]);
$arResult["SHOW_PHONES"] = !empty($arResult["PHONE_ITEMS"]);
$arResult["SHOW_SCHEDULE"] = !empty($arResult["SCHEDULE_ITEMS"]);
$arResult["SHOW_SECONDARY"] = $arResult["SHOW_PHONES"] || $arResult["SHOW_SCHEDULE"];

$this->IncludeComponentTemplate();
