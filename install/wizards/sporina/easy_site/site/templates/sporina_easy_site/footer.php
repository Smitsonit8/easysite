<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<?
$APPLICATION->IncludeComponent(
	"sporina:footer",
	"big",
	[
		"LICENSE_TEXT" => "Лицензия на право осуществления перевозки груза транспортом серия ПП № 1231231",
		"LICENSE_LINK" => "#",
		"POLICY_TEXT" => "Политика обработки персональных данных",
		"POLICY_LINK" => SITE_DIR."about/policy/",
		"COPYRIGHT_SECONDARY_PREFIX" => "При использовании любых материалов ссылка на ",
		"COPYRIGHT_SECONDARY_LINK_TEXT" => "Сайт",
		"COPYRIGHT_SECONDARY_LINK" => "#",
		"COPYRIGHT_SECONDARY_SUFFIX" => " обязательна",
		"TELEGRAM_LINK" => "https://t.me/",
		"GOOGLE_PLAY_LINK" => "https://play.google.com/",
		"APP_STORE_LINK" => "https://apps.apple.com/",
		"IBLOCK_PROPERTY_PHONE_1_VALUE" => "PHONE_1",
		"IBLOCK_PROPERTY_PHONE_1_LABEL" => "PHONE_1_LABEL",
		"IBLOCK_PROPERTY_PHONE_2_VALUE" => "PHONE_2",
		"IBLOCK_PROPERTY_PHONE_2_LABEL" => "PHONE_2_LABEL",
		"IBLOCK_PROPERTY_EMAIL_VALUE" => "EMAIL",
		"IBLOCK_PROPERTY_EMAIL_LABEL" => "EMAIL_NOTE",
		"IBLOCK_PROPERTY_ADDRESS_VALUE" => "ACTUAL_ADDRESS",
		"IBLOCK_PROPERTY_ADDRESS_LABEL" => "ACTUAL_ADDRESS_LABEL",
		"IBLOCK_PROPERTY_COPYRIGHT_PRIMARY" => "COPYRIGHT_PRIMARY",
		"IBLOCK_PROPERTY_SOCIAL_VK" => "SOCIAL_VK",
		"IBLOCK_PROPERTY_SOCIAL_MAX" => "SOCIAL_MAX",
		"IBLOCK_PROPERTY_SOCIAL_OK" => "SOCIAL_OK",
		"IBLOCK_PROPERTY_SOCIAL_RUTUBE" => "SOCIAL_RUTUBE",
		"IBLOCK_PROPERTY_SOCIAL_DZEN" => "SOCIAL_DZEN",
		"COMPONENT_TEMPLATE" => "big"
	],
	false
);
?>
<script src="<?=SITE_TEMPLATE_PATH?>/dist/owl.carousel.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/my_js.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/slide.js"></script>
</body>
</html>
