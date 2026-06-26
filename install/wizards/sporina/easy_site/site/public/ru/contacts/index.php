<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Контакты");
$APPLICATION->SetPageProperty("description", "Страница контактов компании");
$APPLICATION->SetTitle("Контакты");
?>

<!-- слайдер с текстом на нем отличается от главной страници-->
<?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-slider-pages", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/slider-pages.php",
	),
	false
);?>
<!--меню, контент-->
<section class="container content_flex">
  <div class="content">
    <?$APPLICATION->IncludeComponent(
	"sporina:contacts", 
	".default", 
	[
		"SHOW_FULL_NAME" => "Y",
		"FULL_NAME" => "Акционерное общество «Путь-Экспресс»",
		"SHOW_SHORT_NAME" => "Y",
		"SHORT_NAME" => "АО «Путь-Экспресс»",
		"SHOW_LEGAL_ADDRESS" => "Y",
		"LEGAL_ADDRESS" => "236039, Калининградская область, г. Калининград, ул. А. Суворова, д. 1",
		"SHOW_ACTUAL_ADDRESS" => "Y",
		"ACTUAL_ADDRESS" => "236039, Калининградская область, г. Калининград, ул. А. Суворова, д. 1",
		"SHOW_EMAIL" => "Y",
		"EMAIL" => "WAY-EXPRESS@YANDEX.RU",
		"EMAIL_NOTE" => "для официальной документации",
		"SHOW_PHONE_1" => "Y",
		"PHONE_1" => "8 800 777 0000",
		"PHONE_1_LABEL" => "основной телефон",
		"SHOW_PHONE_2" => "Y",
		"PHONE_2" => "8 (4000) 666-888",
		"PHONE_2_LABEL" => "приемная",
		"SHOW_WORK_HOURS" => "Y",
		"WORK_HOURS" => "Понедельник-четверг 08:00 - 17:00; пятница 08:00 - 15:45 (обеденный перерыв с 12:00 до 12:45).",
		"SHOW_WEEKENDS" => "Y",
		"WEEKENDS" => "Суббота, воскресенье.",
		"SHOW_MAP" => "Y",
		"YANDEX_MAP_LAT" => "51.533338",
		"YANDEX_MAP_LON" => "46.034176",
		"MAP_TITLE" => "Местоположение офиса",
		"MAP_HEIGHT" => "420",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"COMPONENT_TEMPLATE" => ".default"
	],
	false
);?>
  </div>
</section>
<!-- подписаться на телеграм-->
<?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-subscribe-t", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/subscribe.php",
	),
	false
	);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
