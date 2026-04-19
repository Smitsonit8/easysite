<!--<div id="bg_slider-main">-->
	<div class="bg-element">
	<div class="container position_relative height">
		<div class="heading-site">
			<?
			if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
			/** @var array $arParams */
			/** @var array $arResult */
			/** @global CMain $APPLICATION */
			/** @global CUser $USER */
			/** @global CDatabase $DB */
			/** @var CBitrixComponentTemplate $this */
			/** @var string $templateName */
			/** @var string $templateFile */
			/** @var string $templateFolder */
			/** @var string $componentPath */
			/** @var CBitrixComponent $component */
			$this->setFrameMode(true);

			if($arResult["FILE"] <> '')
				include($arResult["FILE"]);
			?>
		</div>
	</div>
</div>
<div class="mask_height">
</div>