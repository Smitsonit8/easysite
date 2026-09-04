<?php
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

Loc::loadMessages(__FILE__);

$buttonAction = isset($arCurrentValues["BUTTON_ACTION"]) && $arCurrentValues["BUTTON_ACTION"] === "form" ? "form" : "link";
$formOptions = array("" => "Не выбрано");

if (CModule::IncludeModule("form"))
{
	$by = "s_sort";
	$order = "asc";
	$formList = CForm::GetList($by, $order, array("ACTIVE" => "Y"));
	while ($form = $formList->Fetch())
	{
		$formOptions[$form["ID"]] = "[" . $form["ID"] . "] " . $form["NAME"];
	}
}

$parameterDescriptions = array(
	"TITLE" => "Основной заголовок баннера.", "SLOGAN" => "Короткая надпись над заголовком.", "TEXT" => "Основной текст баннера.", "BUTTON_TEXT" => "Текст, отображаемый на кнопке.", "SHOW_BUTTON" => "Скрывает кнопку независимо от остальных настроек.", "IMAGE_SRC" => "Изображение для широкого экрана.", "MOBILE_IMAGE_SRC" => "Изображение для мобильных устройств.", "SHOW_IMAGE" => "Скрывает блок изображения баннера.", "BACKGROUND_IMAGE_SRC" => "Фоновое изображение баннера.", "BACKGROUND_COLOR" => "CSS-значение цвета фона, если изображение не задано.",
);

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
		"BUTTON_ACTION" => array(
			"PARENT" => "BASE",
			"NAME" => "Действие кнопки",
			"TYPE" => "LIST",
			"VALUES" => array(
				"link" => "Ссылка",
				"form" => "Форма",
			),
			"DEFAULT" => "link",
			"REFRESH" => "Y",
			"DESCRIPTION" => "Определяет, ведёт ли кнопка по ссылке или открывает веб-форму.",
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
		"CACHE_TYPE" => array("PARENT" => "CACHE_SETTINGS", "NAME" => "Тип кеширования", "TYPE" => "LIST", "VALUES" => array("A" => "Авто", "Y" => "Кешировать", "N" => "Не кешировать"), "DEFAULT" => "A", "DESCRIPTION" => "Кеширование применяется только к баннеру со ссылкой."),
		"CACHE_TIME" => array("PARENT" => "CACHE_SETTINGS", "NAME" => "Время кеширования", "TYPE" => "STRING", "DEFAULT" => "36000000", "DESCRIPTION" => "Время хранения кеша в секундах."),
	),
);

foreach ($parameterDescriptions as $parameterCode => $description)
{
	$arComponentParameters["PARAMETERS"][$parameterCode]["DESCRIPTION"] = $description;
}

if ($buttonAction === "form")
{
	$arComponentParameters["PARAMETERS"]["FORM_ID"] = array(
		"PARENT" => "BASE",
		"NAME" => "Веб-форма",
		"TYPE" => "LIST",
		"VALUES" => $formOptions,
		"DEFAULT" => "",
		"DESCRIPTION" => "Форма, которая будет открываться после нажатия кнопки.",
	);
}
else
{
	$arComponentParameters["PARAMETERS"]["BUTTON_LINK"] = array(
		"PARENT" => "BASE",
		"NAME" => "Ссылка кнопки",
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"DESCRIPTION" => "Адрес перехода после нажатия кнопки.",
	);
}
