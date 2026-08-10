<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Контакты");
$APPLICATION->SetPageProperty("description", "Страница контактов компании");
$APPLICATION->SetTitle("Контакты");
?>

<?$APPLICATION->IncludeComponent(
	"sporina:banner",
	"compact",
	Array(
		"BACKGROUND_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/bg_w.png",
		"BUTTON_LINK" => SITE_DIR."contacts/",
		"BUTTON_TEXT" => "Связаться с нами",
		"COMPONENT_TEMPLATE" => "compact",
		"IMAGE_SRC" => "",
		"MOBILE_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/application_img.svg",
		"SHOW_BUTTON" => "Y",
		"SHOW_IMAGE" => "Y",
		"SLOGAN" => "Работаем для вашего удобства",
		"TEXT" => "Подберите нужный раздел, изучите услуги и свяжитесь с нами, если нужна помощь или персональная консультация.",
		"TITLE" => $APPLICATION->GetTitle(false)
	)
);?>
<!--меню, контент-->
<section class="container content_flex">
  <div class="content-no-menu">
    <?php
    $sporinaSettings = isset($GLOBALS['SPORINA_EASY_SITE_SETTINGS']) && is_array($GLOBALS['SPORINA_EASY_SITE_SETTINGS'])
        ? $GLOBALS['SPORINA_EASY_SITE_SETTINGS']
        : array();
    $hasSiteSettings = \Bitrix\Main\Loader::includeModule('sporina.easysite');
    $mapSetting = static function ($settingKey, $componentDefault) use ($sporinaSettings, $hasSiteSettings) {
        if ($hasSiteSettings && \Sporina\EasySite\Settings::hasStoredValue($settingKey)) {
            return (string)($sporinaSettings[$settingKey] ?? $componentDefault);
        }

        return $componentDefault;
    };
    ?>
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
		"SHOW_MAP" => $mapSetting("contacts-map-use", "Y"),
		"YANDEX_MAP_LAT" => $mapSetting("contacts-map-lat", "51.533338"),
		"YANDEX_MAP_LON" => $mapSetting("contacts-map-lon", "46.034176"),
		"MAP_TITLE" => $mapSetting("contacts-map-title", "Местоположение офиса"),
		"MAP_HEIGHT" => $mapSetting("contacts-map-height", "420"),
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
