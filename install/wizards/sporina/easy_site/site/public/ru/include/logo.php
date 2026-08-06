<?php
$logoSrc = SITE_TEMPLATE_PATH . '/img/logo.svg';
if (\Bitrix\Main\Loader::includeModule('sporina.easysite')) {
    $logoSrc = \Sporina\EasySite\Settings::getLogoUrl();
}
?>
<img src="<?=htmlspecialcharsbx($logoSrc)?>" alt="">
