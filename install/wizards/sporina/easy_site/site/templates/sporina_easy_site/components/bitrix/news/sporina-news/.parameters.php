<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"NEWS_LIST_TEMPLATE" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SPORINA_NEWS_LIST_TEMPLATE"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"circle" => GetMessage("SPORINA_NEWS_TEMPLATE_CIRCLE"),
			"paper" => GetMessage("SPORINA_NEWS_TEMPLATE_PAPER"),
			"stand" => GetMessage("SPORINA_NEWS_TEMPLATE_STAND"),
		),
		"DEFAULT" => "circle",
	),
	"NEWS_DETAIL_TEMPLATE" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SPORINA_NEWS_DETAIL_TEMPLATE"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"circle" => GetMessage("SPORINA_NEWS_TEMPLATE_CIRCLE"),
			"paper" => GetMessage("SPORINA_NEWS_TEMPLATE_PAPER"),
			"stand" => GetMessage("SPORINA_NEWS_TEMPLATE_STAND"),
		),
		"DEFAULT" => "circle",
	),
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
);

if ($arCurrentValues["USE_SHARE"] == "Y")
{
	$arTemplateParameters["SHARE_HIDE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
		"TYPE" => "CHECKBOX",
		"VALUE" => "Y",
		"DEFAULT" => "N",
	);

	$arTemplateParameters["SHARE_TEMPLATE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
		"DEFAULT" => "sporina-social-share",
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"REFRESH"=> "Y",
	);
	
	$arTemplateParameters["SHARE_MAX"] = array(
		"NAME" => "MAX",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
	$arTemplateParameters["SHARE_VK"] = array(
		"NAME" => "VK",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
	$arTemplateParameters["SHARE_OK"] = array(
		"NAME" => "OK",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
	$arTemplateParameters["SHARE_MAIL"] = array(
		"NAME" => "Mail",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
}

?>
