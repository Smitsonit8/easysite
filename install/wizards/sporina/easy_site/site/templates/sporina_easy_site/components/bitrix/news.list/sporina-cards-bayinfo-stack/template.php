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
<div class="news-list sporina-cards-stack">
	<section class="container">
		<div class="sporina-cards-stack__list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $index => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$link = $arItem["DISPLAY_PROPERTIES"]["LINK_CARD"]["VALUE"];
	$hasImage = !empty($arItem["PREVIEW_PICTURE"]["SRC"]);
	$cardStyle = "";
	if ($hasImage)
	{
		$cardStyle = '--sporina-cards-stack-bg-image: url(\'' . htmlspecialcharsbx($arItem["PREVIEW_PICTURE"]["SRC"]) . '\');';
	}
	?>
			<article class="sporina-cards-stack__item<?=($hasImage ? ' sporina-cards-stack__item--image' : '')?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.1)?>s;">
				<a class="sporina-cards-stack__link" href="<?=$link?>"<?if($cardStyle !== ""):?> style="<?=$cardStyle?>"<?endif;?>>
					<div class="sporina-cards-stack__text">
						<div class="sporina-cards-stack__number"><?=str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT)?></div>
						<h2><?echo $arItem["NAME"]?></h2>
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<p><?echo $arItem["PREVIEW_TEXT"];?></p>
						<?endif;?>
					</div>
					<div class="sporina-cards-stack__aside">
						<span class="sporina-cards-stack__circle">
							<img src="<?=SITE_TEMPLATE_PATH?>/img/arrow.svg" alt="" class="svg_color">
						</span>
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
