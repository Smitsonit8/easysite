<?
$sporinaSettings = isset($GLOBALS["SPORINA_EASY_SITE_SETTINGS"]) && is_array($GLOBALS["SPORINA_EASY_SITE_SETTINGS"])
	? $GLOBALS["SPORINA_EASY_SITE_SETTINGS"]
	: array();
$bannerTemplate = $sporinaSettings["pages-main-banner-template"] ?? ".default";
$APPLICATION->IncludeComponent(
	"sporina:banner",
	$bannerTemplate,
	array(
		"TITLE" => "АО «Путь-Экспресс»",
		"SLOGAN" => "Логистика, на которую можно опереться",
		"TEXT" => "Быстро. Точно. В срок. Организуем доставку, сопровождаем клиентов и помогаем бизнесу двигаться без остановок.",
		"BUTTON_TEXT" => "Подробнее",
		"BUTTON_LINK" => SITE_DIR."about/",
		"SHOW_BUTTON" => "Y",
		"IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/advertisement.png",
		"MOBILE_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/application_mobil.svg",
		"SHOW_IMAGE" => "Y",
		"BACKGROUND_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/bg.jpg",
		"COMPONENT_TEMPLATE" => $bannerTemplate,
	),
	false
);?>
