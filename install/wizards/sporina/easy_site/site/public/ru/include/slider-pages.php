<?$APPLICATION->IncludeComponent(
	"sporina:banner",
	"compact",
	array(
		"TITLE" => $APPLICATION->GetTitle(false),
		"SLOGAN" => "Работаем для вашего удобства",
		"TEXT" => "Подберите нужный раздел, изучите услуги и свяжитесь с нами, если нужна помощь или персональная консультация.",
		"BUTTON_TEXT" => "Связаться с нами",
		"BUTTON_LINK" => SITE_DIR."contacts/",
		"SHOW_BUTTON" => "Y",
		"IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/application_img.svg",
		"MOBILE_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/application_img.svg",
		"SHOW_IMAGE" => "Y",
		"BACKGROUND_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/bg_w.png",
	),
	false
);?>
