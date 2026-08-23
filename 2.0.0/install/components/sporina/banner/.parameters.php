<?php
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"TITLE" => array(
			"PARENT" => "BASE",
			"NAME" => "Заголовок баннера",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SLOGAN" => array(
			"PARENT" => "BASE",
			"NAME" => "Слоган",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"TEXT" => array(
			"PARENT" => "BASE",
			"NAME" => "Текст баннера",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"BUTTON_TEXT" => array(
			"PARENT" => "BASE",
			"NAME" => "Текст кнопки",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"BUTTON_LINK" => array(
			"PARENT" => "BASE",
			"NAME" => "Ссылка кнопки",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_BUTTON" => array(
			"PARENT" => "VISUAL",
			"NAME" => "Показывать кнопку",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"IMAGE_SRC" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Путь к изображению",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"MOBILE_IMAGE_SRC" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Путь к мобильному изображению",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"SHOW_IMAGE" => array(
			"PARENT" => "VISUAL",
			"NAME" => "Показывать изображение",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"BACKGROUND_IMAGE_SRC" => array(
			"PARENT" => "VISUAL",
			"NAME" => "Путь к фоновому изображению",
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"BACKGROUND_COLOR" => array(
			"PARENT" => "VISUAL",
			"NAME" => Loc::getMessage("BACKGROUND_COLOR"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
	),
);
