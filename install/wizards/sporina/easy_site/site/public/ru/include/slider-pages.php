<?$APPLICATION->IncludeComponent(
	"sporina:banner",
	"compact",
	array(
		"TITLE" => $APPLICATION->GetTitle(false),
		"SLOGAN" => "Работаем для вашего удобства",
		"TEXT" => "Подберите нужный раздел, изучите услуги и свяжитесь с нами, если нужна помощь или персональная консультация.",
		"BUTTON_TEXT" => "Связаться с нами",
		"BUTTON_LINK" => "#SITE_DIR#contacts/",
		"SHOW_BUTTON" => "Y",
		"IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/women-small.png",
		"MOBILE_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/women-small.png",
		"SHOW_IMAGE" => "Y",
		"BACKGROUND_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/fon.png",
	),
	false
);?>
