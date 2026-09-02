<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Контакты");
$APPLICATION->SetPageProperty("description", "Страница контактов компании");
$APPLICATION->SetTitle("Контакты");

$APPLICATION->IncludeComponent(
	"sporina:banner",
	"compact",
	array(
		"BACKGROUND_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/fon.png",
		"BUTTON_LINK" => "#SITE_DIR#contacts/",
		"BUTTON_TEXT" => "Связаться с нами",
		"COMPONENT_TEMPLATE" => "compact",
		"IMAGE_SRC" => "",
		"MOBILE_IMAGE_SRC" => "",
		"SHOW_BUTTON" => "Y",
		"SHOW_IMAGE" => "Y",
		"SLOGAN" => "Работаем для вашего удобства",
		"TEXT" => "Подберите нужный раздел, изучите услуги и свяжитесь с нами, если нужна помощь или персональная консультация.",
		"TITLE" => $APPLICATION->GetTitle(false),
	),
	false
);
?>
<section class="container content_flex">
	<div class="content-no-menu">
		<?php
		$APPLICATION->IncludeComponent(
			"sporina:contacts",
			".default",
			array(
				"SHOW_FULL_NAME" => "Y",
				"SHOW_SHORT_NAME" => "Y",
				"SHOW_LEGAL_ADDRESS" => "Y",
				"SHOW_ACTUAL_ADDRESS" => "Y",
				"SHOW_EMAIL" => "Y",
				"SHOW_PHONE_1" => "Y",
				"SHOW_PHONE_2" => "Y",
				"SHOW_WORK_HOURS" => "Y",
				"SHOW_WEEKENDS" => "Y",
				"SHOW_MAP" => "Y",
				"IBLOCK_PROPERTY_FULL_NAME" => "FULL_NAME",
				"IBLOCK_PROPERTY_SHORT_NAME" => "SHORT_NAME",
				"IBLOCK_PROPERTY_LEGAL_ADDRESS" => "LEGAL_ADDRESS",
				"IBLOCK_PROPERTY_ACTUAL_ADDRESS" => "ACTUAL_ADDRESS",
				"IBLOCK_PROPERTY_EMAIL" => "EMAIL",
				"IBLOCK_PROPERTY_EMAIL_NOTE" => "EMAIL_NOTE",
				"IBLOCK_PROPERTY_PHONE_1" => "PHONE_1",
				"IBLOCK_PROPERTY_PHONE_1_LABEL" => "PHONE_1_LABEL",
				"IBLOCK_PROPERTY_PHONE_2" => "PHONE_2",
				"IBLOCK_PROPERTY_PHONE_2_LABEL" => "PHONE_2_LABEL",
				"IBLOCK_PROPERTY_WORK_HOURS" => "WORK_HOURS",
				"IBLOCK_PROPERTY_WEEKENDS" => "WEEKENDS",
				"IBLOCK_PROPERTY_YANDEX_MAP_LAT" => "MAP_LAT",
				"IBLOCK_PROPERTY_YANDEX_MAP_LON" => "MAP_LON",
				"IBLOCK_PROPERTY_MAP_TITLE" => "MAP_TITLE",
				"IBLOCK_PROPERTY_MAP_HEIGHT" => "MAP_HEIGHT",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"COMPONENT_TEMPLATE" => ".default",
			),
			false
		);
		?>
	</div>
</section>
<?php
$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"sporina-subscribe-t",
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "#SITE_DIR#include/subscribe.php",
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
