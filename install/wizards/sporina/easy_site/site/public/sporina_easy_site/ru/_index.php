<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Главная страница АО \"Путь‑Экспресс\"");
$APPLICATION->SetPageProperty("tags", "заказать услугу, новости компании");
$APPLICATION->SetPageProperty("keywords", "Путь‑Экспресс");
$APPLICATION->SetPageProperty("description", "Главная страница АО \"Путь‑Экспресс\"");
$APPLICATION->SetTitle("Главная");
$sporinaSettings = isset($GLOBALS["SPORINA_EASY_SITE_SETTINGS"]) && is_array($GLOBALS["SPORINA_EASY_SITE_SETTINGS"])
	? $GLOBALS["SPORINA_EASY_SITE_SETTINGS"]
	: array();
?>
<!--Баннер-->
<?if (($sporinaSettings["pages-main-banner-use"] ?? "Y") === "Y"):?>
<?$APPLICATION->IncludeComponent(
	"sporina:banner", 
	".default", 
	[
		"BACKGROUND_COLOR" => "",
		"BACKGROUND_IMAGE_SRC" => "",
		"BUTTON_LINK" => "",
		"BUTTON_TEXT" => "Связаться",
		"COMPONENT_TEMPLATE" => ".default",
		"IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/driver.png",
		"MOBILE_IMAGE_SRC" => SITE_TEMPLATE_PATH."/style/img/driver.png",
		"SHOW_BUTTON" => "Y",
		"SHOW_IMAGE" => "Y",
		"SLOGAN" => "Логистика, на которую можно опереться",
		"TEXT" => "Быстро. Точно. В срок. Организуем доставку, сопровождаем клиентов и помогаем бизнесу двигаться без остановок.",
		"TITLE" => "АО «Путь-Экспресс»",
		"BUTTON_ACTION" => "form",
		"FORM_ID" => FEEDBACK_FORM_ID
	],
	false
);?>
<?endif?>

<!-- блок с карточками-->
<?if (($sporinaSettings["pages-main-infocards-use"] ?? "Y") === "Y"):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"sporina-infocards.2", 
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "cards_info_v1",
		"IBLOCK_TYPE" => "easy_cardsinfo",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "6",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Карточки",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => [
			0 => "",
			1 => "LINK_CARD",
			2 => "",
		],
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ID",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "sporina-infocards.2"
	],
	false
);?>
<?endif?>
 
<!-- подписаться на телеграм-->
<?if (($sporinaSettings["pages-main-subscribe-use"] ?? "Y") === "Y"):?>
<?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-subscribe-t", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "#SITE_DIR#include/subscribe.php",
	),
	false
	);?>
<?endif?>

<!-- расписание--> 
<?if (($sporinaSettings["pages-main-columns-use"] ?? "Y") === "Y"):?>
<section class="container">
<div class="block_between block_between--margin<?=($sporinaSettings["pages-main-columns-layout"] ?? "two") === "stacked" ? " block_between--stacked" : ""?>">
	<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"sporina-column-news", 
	[
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
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
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => ARTICLES_IBLOCK_ID,
		"IBLOCK_TYPE" => "easy_news_articles",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"LIST_FIELD_CODE" => [
			0 => "TIMESTAMP_X",
			1 => "",
		],
		"LIST_PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "4",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Изменения в расписании",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "#SITE_DIR#izmeneniya-v-raspisanii/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "TIMESTAMP_X",
		"SORT_BY2" => "TIMESTAMP_X",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "sporina-column-news",
		"NEWS_LIST_TEMPLATE" => "list.2",
		"COLUMNS_LAYOUT" => "two",
		"USE_REVIEW" => "N",
		"SHOW_IBLOCK_TITLE" => "Y",
		"SHOW_MORE_BUTTON" => "Y",
		"SEF_URL_TEMPLATES" => [
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		]
	],
	false
);?>

	<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"sporina-column-news", 
	[
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => NEWS_IBLOCK_ID,
		"IBLOCK_TYPE" => "easy_news_articles",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"LIST_FIELD_CODE" => [
			0 => "TIMESTAMP_X",
			1 => "",
		],
		"LIST_PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "4",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "#SITE_DIR#novosti-kompanii/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "TIMESTAMP_X",
		"SORT_BY2" => "TIMESTAMP_X",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "sporina-column-news",
		"NEWS_LIST_TEMPLATE" => "list.2",
		"COLUMNS_LAYOUT" => "two",
		"SHOW_IBLOCK_TITLE" => "Y",
		"SHOW_MORE_BUTTON" => "Y",
		"USE_REVIEW" => "N",
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
<?endif?>
<!-- мобильное приложение--> 
<?if (($sporinaSettings["pages-main-advertising-use"] ?? "Y") === "Y"):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"sporina-banner-app", 
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => [
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
			2 => "",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "promo_banners_v1",
		"IBLOCK_TYPE" => "easy_promobanners",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "1",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Баннеры",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => [
			0 => "",
			1 => "IMAGE_MOBILE",
			2 => "NAME_BUTTON",
			3 => "LINK_TO",
			4 => "",
		],
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "sporina-banner-app"
	],
	false
);?>
<?endif?>

<!-- новости--> 
<?if (($sporinaSettings["pages-main-current-news-use"] ?? "Y") === "Y"):?>
<section class="position_relative">

<?
$GLOBALS['arrFilter'] = array();
$GLOBALS['arrFilter'] = array_merge($GLOBALS['arrFilter'], Array("!PROPERTY_TOINDEX" => false));
$APPLICATION->IncludeComponent(
	"bitrix:news.index", 
	"sporina-news-all.1", 
	[
		"IBLOCKS" => [
		],
		"NEWS_COUNT" => "2000",
		"IBLOCK_SORT_BY" => "ID",
		"IBLOCK_SORT_ORDER" => "ASC",
		"SORT_BY1" => "ID",
		"SORT_ORDER1" => "RAND",
		"FIELD_CODE" => [
			0 => "TIMESTAMP_X",
			1 => "",
		],
		"PROPERTY_CODE" => [
			0 => "",
			1 => "TOINDEX",
			2 => "",
		],
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_URL" => "",
		"DETAIL_URL" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SHOW_SLIDER_NAVIGATION" => "Y",
		"ENABLE_SLIDER_AUTOPLAY" => "N",
		"SLIDER_AUTOPLAY_TIMEOUT" => "5000",
		"COMPONENT_TEMPLATE" => "sporina-news-all.1",
		"IBLOCK_TYPE" => "easy_news_articles",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"BLOCK_DESCRIPTION" => " ",
		"SHOW_BLOCK_DESCRIPTION" => "N"
	],
	false
);
?>

 </section> 
<?endif?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
