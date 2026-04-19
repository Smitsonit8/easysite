<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

// Получаем выбранную тему из настроек сайта
$theme = COption::GetOptionString("main", "wizard_sporina_easy_site_theme_id", "blue", SITE_ID);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?$APPLICATION->ShowHead();?>
  <title><?$APPLICATION->ShowTitle();?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/themes/<?=$theme?>/colors.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/style/style.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/dist/assets/owl.theme.default.min.css">
</head>
<body class="bx-theme-<?=$theme?>">
    <div id="panel">
		<?$APPLICATION->ShowPanel();?>
    </div>

<!-- шапка -->
    <section class="container header_mobile">
        <header class="block">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "sporina-top-menu",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "top",
                    "USE_EXT" => "N"
                )
            );?>
            <div class="block">
                <div>
                    <a href="<?=SITE_DIR?>poisk/" class="svg block_center svg_search">
                        <img src="<?=SITE_TEMPLATE_PATH?>/img/search.svg" class="svg_color">
                    </a>
                </div>
            </div>
        </header>

    </section>
