<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<?
$APPLICATION->IncludeComponent(
	"sporina:footer", 
	"big",
	[
		"PHONE_1_VALUE" => "8 800 777 0001",
		"PHONE_1_LABEL" => "звонок бесплатный для всех регионов РФ",
		"PHONE_2_VALUE" => "8 (4000) 666-888",
		"PHONE_2_LABEL" => "приемная АО «Путь-Экспресс»",
		"EMAIL_VALUE" => "WAY-EXPRESS@YANDEX.RU",
		"EMAIL_LABEL" => "электронная почта",
		"ADDRESS_VALUE" => "236039, г. Калининград, Суворова ул., д. 1",
		"ADDRESS_LABEL" => "Адрес компании",
		"LICENSE_TEXT" => "Лицензия на право осуществления перевозки груза транспортом серия ПП № 1231231",
		"LICENSE_LINK" => "#",
		"POLICY_TEXT" => "Политика обработки персональных данных",
		"POLICY_LINK" => SITE_DIR."about/policy/",
		"COPYRIGHT_PRIMARY" => "© АО «Путь-Экспресс» 2011-2026",
		"COPYRIGHT_SECONDARY_PREFIX" => "При использовании любых материалов ссылка на ",
		"COPYRIGHT_SECONDARY_LINK_TEXT" => "Сайт",
		"COPYRIGHT_SECONDARY_LINK" => "#",
		"COPYRIGHT_SECONDARY_SUFFIX" => " обязательна",
		"TELEGRAM_LINK" => "https://t.me/",
		"GOOGLE_PLAY_LINK" => "https://play.google.com/",
		"APP_STORE_LINK" => "https://apps.apple.com/",
		"COMPONENT_TEMPLATE" => "big"
	],
	false
);?>
<script src="<?=SITE_TEMPLATE_PATH?>/dist/owl.carousel.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/my_js.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/slide.js"></script>
</body>
</html>
