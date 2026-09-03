<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock"))
{
	return false;
}

$siteId = WIZARD_SITE_ID;
$iblockType = "easy_infocompany";
$iblockCode = "company_contacts_v2";

$iblockId = 0;
$iblockResult = CIBlock::GetList(array(), array(
	"TYPE" => $iblockType,
	"CODE" => $iblockCode,
));
if ($iblock = $iblockResult->Fetch())
{
	$iblockId = (int)$iblock["ID"];
}

if ($iblockId <= 0)
{
	$iblockObject = new CIBlock;
	$iblockId = (int)$iblockObject->Add(array(
		"ACTIVE" => "Y",
		"NAME" => "Контакты компании",
		"CODE" => $iblockCode,
		"XML_ID" => $iblockCode . "_" . $siteId,
		"IBLOCK_TYPE_ID" => $iblockType,
		"LID" => array($siteId),
		"GROUP_ID" => array(1 => "X", 2 => "R"),
	));
}

if ($iblockId <= 0)
{
	return false;
}

$properties = array(
	"ACTUAL_ADDRESS_LABEL" => "Подпись адреса",
	"EMAIL_LABEL" => "Подпись электронной почты",
	"FULL_NAME" => "Полное наименование",
	"SHORT_NAME" => "Краткое наименование",
	"PHONE_1" => "Телефон 1",
	"PHONE_1_LABEL" => "Подпись телефона 1",
	"PHONE_2" => "Телефон 2",
	"PHONE_2_LABEL" => "Подпись телефона 2",
	"EMAIL" => "Электронная почта",
	"EMAIL_NOTE" => "Примечание к электронной почте",
	"LEGAL_ADDRESS" => "Юридический адрес",
	"ACTUAL_ADDRESS" => "Фактический адрес",
	"WORK_HOURS" => "Режим работы",
	"WEEKENDS" => "Выходные дни",
	"MAP_LAT" => "Широта карты",
	"MAP_LON" => "Долгота карты",
	"MAP_TITLE" => "Заголовок карты",
	"MAP_HEIGHT" => "Высота карты",
	"COPYRIGHT_PRIMARY" => "Основная строка копирайта",
	"SOCIAL_VK" => "Ссылка VK",
	"SOCIAL_MAX" => "Ссылка MAX",
	"SOCIAL_OK" => "Ссылка Одноклассники",
	"SOCIAL_RUTUBE" => "Ссылка Rutube",
	"SOCIAL_DZEN" => "Ссылка Дзен",
);

$propertyObject = new CIBlockProperty;
$sort = 100;
foreach ($properties as $code => $name)
{
	$propertyResult = CIBlockProperty::GetList(array(), array(
		"IBLOCK_ID" => $iblockId,
		"CODE" => $code,
	));
	if (!$propertyResult->Fetch())
	{
		$propertyObject->Add(array(
			"IBLOCK_ID" => $iblockId,
			"NAME" => $name,
			"CODE" => $code,
			"PROPERTY_TYPE" => "S",
			"ACTIVE" => "Y",
			"SORT" => $sort,
		));
	}
	$sort += 10;
}

$contactElementId = 0;
$elementResult = CIBlockElement::GetList(array(), array(
	"IBLOCK_ID" => $iblockId,
	"CODE" => $iblockCode,
), false, array("nTopCount" => 1), array("ID"));

if ($contactElement = $elementResult->Fetch())
{
	$contactElementId = (int)$contactElement["ID"];
}

if ($contactElementId <= 0)
{
	$elementObject = new CIBlockElement;
	$contactElementId = (int)$elementObject->Add(array(
		"IBLOCK_ID" => $iblockId,
		"ACTIVE" => "Y",
		"NAME" => "Контакты компании",
		"CODE" => $iblockCode,
		"PROPERTY_VALUES" => array(
			"ACTUAL_ADDRESS_LABEL" => "Адрес компании",
			"FULL_NAME" => "Акционерное общество «Путь-Экспресс»",
			"SHORT_NAME" => "АО «Путь-Экспресс»",
			"PHONE_1" => "8 800 777 0001",
			"PHONE_1_LABEL" => "звонок бесплатный для всех регионов РФ",
			"PHONE_2" => "8 (4000) 666-888",
			"PHONE_2_LABEL" => "приемная АО «Путь-Экспресс»",
			"EMAIL_LABEL" => "электронная почта",
			"EMAIL" => "WAY-EXPRESS@YANDEX.RU",
			"EMAIL_NOTE" => "для официальной документации",
			"LEGAL_ADDRESS" => "236039, Калининградская область, г. Калининград, ул. А. Суворова, д. 1",
			"ACTUAL_ADDRESS" => "236039, г. Калининград, ул. Суворова, д. 1",
			"WORK_HOURS" => "Понедельник-четверг 08:00 - 17:00; пятница 08:00 - 15:45 (обеденный перерыв с 12:00 до 12:45).",
			"WEEKENDS" => "Суббота, воскресенье.",
			"MAP_LAT" => "51.533338",
			"MAP_LON" => "46.034176",
			"MAP_TITLE" => "Местоположение офиса",
			"MAP_HEIGHT" => "420",
			"COPYRIGHT_PRIMARY" => "© АО «Путь-Экспресс» 2011-2026",
		),
	));
}

return true;
