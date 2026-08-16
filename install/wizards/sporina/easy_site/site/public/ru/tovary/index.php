<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Товары");
$APPLICATION->SetPageProperty("keywords", "товары");
$APPLICATION->SetPageProperty("description", "Страница о товарах компании");
$APPLICATION->SetTitle("Товары");
?>
<!-- баннер с текстом на нем отличается от главной страници--> 
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
		<?$APPLICATION->IncludeComponent(
			"sporina:news", 
			"sporina-products", 
			[
				"ADD_ELEMENT_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "Y",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"BROWSER_TITLE" => "-",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "N",
				"CHECK_DATES" => "Y",
				"COMPONENT_TEMPLATE" => "sporina-products",
				"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
				"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
				"DETAIL_DISPLAY_TOP_PAGER" => "N",
				"DETAIL_FIELD_CODE" => [
					0 => "",
					1 => "GALLERY",
					2 => "",
				],
				"DETAIL_PAGER_SHOW_ALL" => "Y",
				"DETAIL_PAGER_TEMPLATE" => "",
				"DETAIL_PAGER_TITLE" => "Страница",
				"DETAIL_PROPERTY_CODE" => [
					0 => "",
					1 => "PRICE",
					2 => "GALLERY",
					3 => "",
				],
				"DETAIL_SET_CANONICAL_URL" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => PRODUCTS_IBLOCK_ID,
				"IBLOCK_TYPE" => "easy_products",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
				"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
				"NEWS_LIST_TEMPLATE" => "list.3",
				"NEWS_DETAIL_TEMPLATE" => "detail.1",
				"GALLERY_PROPERTY_CODE" => "GALLERY",
				"LIST_FIELD_CODE" => [
					0 => "",
					1 => "",
				],
				"LIST_PROPERTY_CODE" => [
					0 => "",
					1 => "PRICE",
					2 => "",
				],
				"MESSAGE_404" => "",
				"META_DESCRIPTION" => "-",
				"META_KEYWORDS" => "-",
				"NEWS_COUNT" => "20",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PREVIEW_TRUNCATE_LEN" => "",
				"SEF_FOLDER" => "#SITE_DIR#tovary/",
				"SEF_MODE" => "Y",
				"SET_LAST_MODIFIED" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "Y",
				"SHOW_404" => "N",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_BY2" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_ORDER2" => "ASC",
				"STRICT_SECTION_CHECK" => "N",
				"USE_CATEGORIES" => "N",
				"USE_FILTER" => "N",
				"USE_PERMISSIONS" => "N",
				"USE_RATING" => "N",
				"USE_RSS" => "N",
				"USE_SEARCH" => "N",
				"USE_SHARE" => "N",
				"USE_REVIEW" => "N",
				"FORM_SHOW" => "Y",
				"FORM_ID" => BUY_FORM_ID,
				"FORM_TEMPLATE" => "sporina-form-order",
				"FORM_SUCCESS_URL" => "",
				"FORM_USE_EXTENDED_ERRORS" => "N",
				"FORM_PERSONAL_DATA_URL" => "#SITE_DIR#about/policy/",
				"SEF_URL_TEMPLATES" => [
					"news" => "",
					"section" => "",
					"detail" => "#ELEMENT_CODE#/",
				]
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
