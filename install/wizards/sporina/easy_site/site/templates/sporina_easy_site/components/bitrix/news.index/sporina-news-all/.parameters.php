<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arTemplateParameters = array(
	"SHOW_SLIDER_NAVIGATION" => array(
		"PARENT" => "VISUAL",
		"NAME" => Loc::getMessage("SPORINA_NEWS_ALL_SHOW_SLIDER_NAVIGATION"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"ENABLE_SLIDER_AUTOPLAY" => array(
		"PARENT" => "VISUAL",
		"NAME" => Loc::getMessage("SPORINA_NEWS_ALL_ENABLE_SLIDER_AUTOPLAY"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"SLIDER_AUTOPLAY_TIMEOUT" => array(
		"PARENT" => "VISUAL",
		"NAME" => Loc::getMessage("SPORINA_NEWS_ALL_SLIDER_AUTOPLAY_TIMEOUT"),
		"TYPE" => "STRING",
		"DEFAULT" => "5000",
	),
);
