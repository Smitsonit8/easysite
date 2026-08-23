<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$resolvePath = static function ($path)
{
	$path = trim((string)$path);
	if ($path === "")
	{
		return "";
	}

	if (preg_match("#^(https?:)?//#i", $path))
	{
		return $path;
	}

	if ($path[0] === "/")
	{
		return $path;
	}

	return SITE_TEMPLATE_PATH . "/" . ltrim($path, "/");
};

$title = trim((string)($arParams["TITLE"] ?? ""));
$slogan = trim((string)($arParams["SLOGAN"] ?? ""));
$text = trim((string)($arParams["TEXT"] ?? ""));
$buttonText = trim((string)($arParams["BUTTON_TEXT"] ?? ""));
$buttonLink = trim((string)($arParams["BUTTON_LINK"] ?? ""));
$imageSrc = $resolvePath($arParams["IMAGE_SRC"] ?? "");
$mobileImageSrc = $resolvePath($arParams["MOBILE_IMAGE_SRC"] ?? "");
$backgroundImageSrc = $resolvePath($arParams["BACKGROUND_IMAGE_SRC"] ?? "");
$backgroundColor = trim((string)($arParams["BACKGROUND_COLOR"] ?? ""));

$arResult = array(
	"TITLE" => $title,
	"SLOGAN" => $slogan,
	"TEXT" => $text,
	"BUTTON_TEXT" => $buttonText,
	"BUTTON_LINK" => $buttonLink,
	"SHOW_BUTTON" => $arParams["SHOW_BUTTON"] !== "N" && $buttonText !== "" && $buttonLink !== "",
	"SHOW_IMAGE" => $arParams["SHOW_IMAGE"] !== "N" && ($imageSrc !== "" || $mobileImageSrc !== ""),
	"IMAGE_SRC" => $imageSrc,
	"MOBILE_IMAGE_SRC" => $mobileImageSrc,
	"BACKGROUND_IMAGE_SRC" => $backgroundImageSrc,
	"BACKGROUND_COLOR" => $backgroundColor,
);

$this->IncludeComponentTemplate();
