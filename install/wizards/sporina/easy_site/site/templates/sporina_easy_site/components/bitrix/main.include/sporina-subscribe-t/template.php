<section class="container">
	<a href="https://t.me/aokppk39" class="svg">
			<div class="block block_info--bgWhite block_tg">
				<div>
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
			<div>
				<img src="<?=SITE_TEMPLATE_PATH?>/img/telegram.svg" class="svg_color">
			</div>
		</div>
 	</a>					
</section>
