<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$getValue = static function ($key) use ($arParams)
{
	return trim((string)($arParams[$key] ?? ""));
};

$resolveAsset = static function ($path)
{
	$path = trim((string)$path);
	if ($path === "")
	{
		return "";
	}

	if (preg_match("~^(?:[a-z]+:)?//|^/|^data:~i", $path))
	{
		return $path;
	}

	return SITE_TEMPLATE_PATH . "/" . ltrim($path, "/");
};

$logoLink = $getValue("LOGO_LINK");
$searchLink = $getValue("SEARCH_LINK");
$rootMenuType = $getValue("ROOT_MENU_TYPE");
$childMenuType = $getValue("CHILD_MENU_TYPE");
$maxLevel = $getValue("MAX_LEVEL");
$menuCacheType = $getValue("MENU_CACHE_TYPE");
$menuCacheTime = $getValue("MENU_CACHE_TIME");

$arResult = array(
	"LOGO_LINK" => $logoLink !== "" ? $logoLink : SITE_DIR,
	"LOGO_SRC" => $resolveAsset($getValue("LOGO_SRC")),
	"LOGO_ALT" => $getValue("LOGO_ALT") !== "" ? $getValue("LOGO_ALT") : Loc::getMessage("SPORINA_HEADER_DEFAULT_LOGO_ALT"),
	"SEARCH_LINK" => $searchLink !== "" ? $searchLink : SITE_DIR . "poisk/",
	"BURGER_LABEL" => Loc::getMessage("SPORINA_HEADER_BURGER_LABEL"),
	"MENU" => array(
		"ROOT_MENU_TYPE" => $rootMenuType !== "" ? $rootMenuType : "top",
		"CHILD_MENU_TYPE" => $childMenuType !== "" ? $childMenuType : "left",
		"MAX_LEVEL" => $maxLevel !== "" ? $maxLevel : "1",
		"MENU_CACHE_TYPE" => $menuCacheType !== "" ? $menuCacheType : "N",
		"MENU_CACHE_TIME" => $menuCacheTime !== "" ? $menuCacheTime : "3600",
	),
);

$this->IncludeComponentTemplate();
