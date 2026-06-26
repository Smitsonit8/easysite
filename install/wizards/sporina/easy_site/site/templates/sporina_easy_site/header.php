<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

$theme = COption::GetOptionString("main", "wizard_sporina_easy_site_theme_id", "blue", SITE_ID);
$headerTemplate = (string)$APPLICATION->GetPageProperty("HEADER_TEMPLATE");
if (!in_array($headerTemplate, array("overlay", "default", "sticky"), true))
{
	$headerTemplate = "default";
}
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
<body class="bx-theme-<?=$theme?> header-template-<?=$headerTemplate?>">
    <div id="panel">
		<?$APPLICATION->ShowPanel();?>
    </div>

    <?$APPLICATION->IncludeComponent(
	"sporina:header", 
	"overlay", 
	[
		"LOGO_LINK" => SITE_DIR,
		"LOGO_SRC" => "img/logo.svg",
		"LOGO_ALT" => "",
		"SEARCH_LINK" => SITE_DIR."poisk/",
		"SEARCH_ICON_SRC" => "img/search.svg",
		"SEARCH_ALT" => "",
		"ROOT_MENU_TYPE" => "top",
		"CHILD_MENU_TYPE" => "left",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"COMPONENT_TEMPLATE" => "overlay"
	],
	false
);?>
