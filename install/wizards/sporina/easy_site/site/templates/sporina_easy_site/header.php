<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

CJSCore::Init(array("jquery"));
$sporinaSettings = $APPLICATION->IncludeComponent(
	"sporina:system.settings",
	"",
	array("MODE" => "render"),
	false,
	array("HIDE_ICONS" => "Y")
);

use Bitrix\Main\Page\Asset;

if (!is_array($sporinaSettings) && \Bitrix\Main\Loader::includeModule('sporina.easysite'))
{
	$sporinaSettings = \Sporina\EasySite\Settings::getAll();
}
if (!is_array($sporinaSettings))
{
	return;
}
$GLOBALS["SPORINA_EASY_SITE_SETTINGS"] = $sporinaSettings;
$appearance = \Sporina\EasySite\Settings::getAppearance();
$logoSrc = \Sporina\EasySite\Settings::getLogoUrl();
$theme = $appearance['theme'];
$headerTemplate = $appearance['headerTemplate'];
$fontFamily = $appearance['fontFamily'];
$font = in_array($sporinaSettings['template-font'] ?? '', ['ibm-plex-sans', 'arial', 'manrope', 'onest', 'roboto'], true)
	? $sporinaSettings['template-font']
	: 'ibm-plex-sans';
$textSize = in_array($sporinaSettings['typography-text-size'] ?? '', ['small', 'medium', 'large'], true)
	? $sporinaSettings['typography-text-size']
	: 'medium';
$headingSize = in_array($sporinaSettings['typography-heading-size'] ?? '', ['small', 'medium', 'large'], true)
	? $sporinaSettings['typography-heading-size']
	: 'medium';
$buttonEffect = in_array($sporinaSettings['template-button-effect'] ?? '', ['', 'btn-effect-1', 'btn-effect-2', 'btn-effect-3'], true)
	? $sporinaSettings['template-button-effect']
	: '';
?>
<!DOCTYPE html>
<html lang="ru" data-font="<?=htmlspecialcharsbx($font)?>" data-text-size="<?=htmlspecialcharsbx($textSize)?>" data-heading-size="<?=htmlspecialcharsbx($headingSize)?>">
<head>
  <?$APPLICATION->ShowHead();?>
  <title><?$APPLICATION->ShowTitle();?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/themes/<?=$theme?>/colors.css">
    <?
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/style/style.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/style/typography.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/style/fonts/ibm-plex-sans.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/style/fonts/arial.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/style/fonts/manrope.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/style/fonts/onest.css');
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/style/fonts/roboto.css');
    ?>
    <style>
      :root {
        --site-background: <?=htmlspecialcharsbx($appearance['backgroundColor'])?>;
        --site-max-width: <?=intval($appearance['width'])?>px;
        --site-font-family: <?=$fontFamily?>;
      }
    </style>
    <script>
      (function () {
        var effect = <?=json_encode($buttonEffect)?>;
        var effectClasses = ['btn-effect-1', 'btn-effect-2', 'btn-effect-3'];

        function applyButtonEffect() {
          document.querySelectorAll('a.sporina-button, button.sporina-button').forEach(function (element) {
            element.classList.remove.apply(element.classList, effectClasses);
            if (effect) element.classList.add(effect);
          });
        }

        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', applyButtonEffect);
        } else {
          applyButtonEffect();
        }

        if (window.BX && typeof window.BX.addCustomEvent === 'function') {
          window.BX.addCustomEvent('onAjaxSuccess', applyButtonEffect);
        }
      })();
    </script>
    <?if ($appearance['lazyloadUse'] === "Y"):?>
      <script>
      (function () {
        function lazy(node) {
          if (node.nodeType !== 1) return;
          if (node.tagName === 'IMG' && !node.closest('.system-settings')) node.loading = 'lazy';
          node.querySelectorAll && node.querySelectorAll('img:not([loading])').forEach(function (image) {
            if (!image.closest('.system-settings')) image.loading = 'lazy';
          });
        }
        new MutationObserver(function (entries) {
          entries.forEach(function (entry) { entry.addedNodes.forEach(lazy); });
        }).observe(document.documentElement, {childList: true, subtree: true});
      })();
      </script>
    <?endif?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&family=Onest:wght@400;500;600;700&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/dist/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body class="bx-theme-<?=$theme?> header-template-<?=$headerTemplate?><?=$appearance['backgroundUse'] === "N" ? " site-background-disabled" : ""?>">
    <div id="panel">
		<?$APPLICATION->ShowPanel();?>
    </div>
    <?$APPLICATION->IncludeComponent(
		"sporina:system.settings",
		"",
		array("MODE" => "configure"),
		false
	);?>

    <?$APPLICATION->IncludeComponent(
	"sporina:header", 
	"overlay",
	[
		"LOGO_LINK" => SITE_DIR,
		"LOGO_SRC" => $logoSrc,
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
