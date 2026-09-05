<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Услуги");
$APPLICATION->SetPageProperty("keywords", "услуги");
$APPLICATION->SetPageProperty("description", "Страница о услугах компании");
$APPLICATION->SetTitle("Услуги");
?>
<?$APPLICATION->IncludeComponent(
	"sporina:banner", 
	"compact", 
	[
		"BACKGROUND_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/fon.png",
		"BUTTON_LINK" => "#SITE_DIR#contacts/",
		"BUTTON_TEXT" => "Наши контакты",
		"COMPONENT_TEMPLATE" => "compact",
		"IMAGE_SRC" => "",
		"MOBILE_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/women-small.png",
		"SHOW_BUTTON" => "Y",
		"SHOW_IMAGE" => "Y",
		"SLOGAN" => "Работаем для вашего удобства",
		"TEXT" => "Подберите нужный раздел, изучите услуги и свяжитесь с нами, если нужна помощь или персональная консультация.",
		"TITLE" => $APPLICATION->GetTitle(false),
		"BACKGROUND_COLOR" => ""
	],
	false
);?>
<!--меню, контент--> 
<section class="container content_flex">
	<div class="content-no-menu">
		<?$APPLICATION->IncludeComponent(
			"sporina:news", 
			"sporina-services", 
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
				"COMPONENT_TEMPLATE" => "sporina-services",
				"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
				"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
				"DETAIL_DISPLAY_TOP_PAGER" => "N",
				"DETAIL_FIELD_CODE" => [
					0 => "",
					1 => "",
				],
				"DETAIL_PAGER_SHOW_ALL" => "Y",
				"DETAIL_PAGER_TEMPLATE" => "",
				"DETAIL_PAGER_TITLE" => "Страница",
				"DETAIL_PROPERTY_CODE" => [
					0 => "",
					1 => "",
				],
				"DETAIL_SET_CANONICAL_URL" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => SERVICES_IBLOCK_ID,
				"IBLOCK_TYPE" => "easy_services",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
				"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
				"LIST_FIELD_CODE" => [
					0 => "",
					1 => "",
				],
				"LIST_PROPERTY_CODE" => [
					0 => "",
					1 => "",
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
				"PAGER_TITLE" => "Услуги",
				"PREVIEW_TRUNCATE_LEN" => "",
				"SEF_FOLDER" => "#SITE_DIR#uslugi/",
				"SEF_MODE" => "Y",
				"SET_LAST_MODIFIED" => "N",
				"SET_TITLE" => "Y",
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
				"NEWS_LIST_TEMPLATE" => "list.2",
				"NEWS_DETAIL_TEMPLATE" => "detail.1",
				"SHOW_SECTION_BADGE" => "Y",
				"SECTION_BADGE_POSITION" => "left",
				"USE_REVIEW" => "N",
				"FORM_SHOW" => "Y",
				"FORM_ID" => ORDER_FORM_ID,
				"FORM_TEMPLATE" => "sporina-form-order",
				"FORM_SUCCESS_URL" => "",
				"FORM_USE_EXTENDED_ERRORS" => "N",
				"FORM_PERSONAL_DATA_URL" => "#SITE_DIR#about/policy/",
				"SEF_URL_TEMPLATES" => [
					"news" => "",
					"section" => "",
					"detail" => "#ELEMENT_CODE#/",
				],
				"SET_STATUS_404" => "Y",
				"SHOW_404" => "Y",
				"FILE_404" => "#SITE_DIR#404.php"
			],
			false
		);?>
	</div>
 </section>

<!-- подписаться на телеграм-->
 <?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-subscribe-t", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "#SITE_DIR#include/subscribe.php",
	),
	false
	);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
