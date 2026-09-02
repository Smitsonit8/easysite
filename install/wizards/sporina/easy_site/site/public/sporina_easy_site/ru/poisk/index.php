<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
?>

<?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-slider-pages", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/slider-pages.php",
	),
	false
);?>
<!--меню, контент-->
<section class="container content_flex">   
    <div class="content-no-menu">
        <h2><?$APPLICATION->ShowTitle()?></h2>
        <p>
        <?$APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	"sporina-search", 
	[
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "N",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "50",
		"RESTART" => "N",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "N",
		"arrFILTER" => [
			0 => "main",
			1 => "iblock_raspisanie",
			2 => "iblock_information",
			3 => "iblock_news_and_changes",
		],
		"arrFILTER_iblock_news_and_changes" => [
			0 => "all",
		],
		"arrFILTER_iblock_raspisanie" => [
			0 => "all",
		],
		"arrWHERE" => "",
		"COMPONENT_TEMPLATE" => "clear",
		"SHOW_ITEM_TAGS" => "Y",
		"TAGS_INHERIT" => "Y",
		"SHOW_ITEM_DATE_CHANGE" => "Y",
		"SHOW_ORDER_BY" => "Y",
		"SHOW_TAGS_CLOUD" => "N",
		"arrFILTER_main" => "",
		"arrFILTER_iblock_information" => [
			0 => "all",
		]
	],
	false
);?>
        </p>
    </div>
</section>
	<?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-subscribe-t", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/subscribe.php",
	),
	false
	);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>