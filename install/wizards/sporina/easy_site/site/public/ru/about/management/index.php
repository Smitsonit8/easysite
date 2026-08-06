<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Руководство компании");
$APPLICATION->SetTitle("Руководство компании");
?><!-- слайдер с текстом на нем отличается от главной страници--> <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"sporina-slider-pages",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/slider-pages.php"
	)
);?> <!--меню, контент--> <section class="container content_flex">
<div class="content_nav">
	<div class="content_nav-bg">
 <input type="checkbox" id="content_nav-head">
        <label class="content_nav-head" for="content_nav-head"><?$APPLICATION->ShowTitle()?></label>
		<!--<label class="content_nav-head" for="content_nav-head"> О компании</label>--> <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"sporina-left-menu",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(0=>"",),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "N"
	)
);?>
	</div>
</div>
<div class="content">
<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"staff", 
	[
		"COMPONENT_TEMPLATE" => "staff",
		"IBLOCK_TYPE" => "easy_site_company",
		"IBLOCK_ID" => "444",
		"NEWS_COUNT" => "20",
		"USE_SEARCH" => "N",
		"NEWS_LIST_TEMPLATE" => "blocks.1",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"SOCIAL_SHOW" => "Y",
		"PROPERTY_POSITION" => "POSITION",
		"PROPERTY_PHONE" => "PHONE",
		"PROPERTY_EMAIL" => "EMAIL",
		"PROPERTY_SOCIAL_VK" => "VKONTAKTE",
		"PROPERTY_SOCIAL_FB" => "OK",
		"PROPERTY_SOCIAL_INST" => "MAX",
		"SEF_MODE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_PERMISSIONS" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"LIST_PROPERTY_CODE" => [
			0 => "EMAIL",
			1 => "VKONTAKTE",
			2 => "OK",
			3 => "MAIL",
			4 => "MAX",
			5 => "",
		],
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"DETAIL_PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"PROPERTY_SOCIAL_MAX" => "MAX",
		"PROPERTY_SOCIAL_OK" => "OK",
		"PROPERTY_SOCIAL_RUTUBE" => "RUTUBE",
		"PROPERTY_SOCIAL_DZEN" => "DZEN",
		"VARIABLE_ALIASES" => [
			"SECTION_ID" => "SECTION_ID",
			"ELEMENT_ID" => "ELEMENT_ID",
		]
	],
	false
);?>
</div>
 </section>
<!-- подписаться на телеграм-->
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"sporina-subscribe-t",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/subscribe.php"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
