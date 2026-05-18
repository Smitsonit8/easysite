<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<div class="news-list sporina-cards-tiles">
	<section class="container">
		<div class="sporina-cards-tiles__grid">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $index => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$link = $arItem["DISPLAY_PROPERTIES"]["LINK_CARD"]["VALUE"];
	$hasImage = !empty($arItem["PREVIEW_PICTURE"]["SRC"]);
	?>
			<article class="sporina-cards-tiles__item<?=($hasImage ? ' sporina-cards-tiles__item--image' : '')?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
				<a class="sporina-cards-tiles__link" href="<?=$link?>">
					<?if($hasImage):?>
						<div class="sporina-cards-tiles__media">
							<img
								class="sporina-cards-tiles__image"
								src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
								alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
								title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
							/>
						</div>
					<?endif;?>
					<div class="sporina-cards-tiles__body">
						<div class="sporina-cards-tiles__head">
							<h2><?echo $arItem["NAME"]?></h2>
							<span class="sporina-cards-tiles__arrow">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/arrow.svg" alt="" class="svg_color">
							</span>
						</div>
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<p><?echo $arItem["PREVIEW_TEXT"];?></p>
						<?endif;?>
					</div>
				</a>
			</article>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
		</div>
	</section>
</div>
