<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if(!empty($arResult["ITEMS"])):?>
<section class="sporina-news-timeline">
	<div class="sporina-news-timeline__head">
		<b class="sporina-news-timeline__title"><?=$arResult["NAME"]?></b>
	</div>
	<div class="sporina-news-timeline__list">
	<?foreach($arResult["ITEMS"] as $index => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<article class="sporina-news-timeline__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
			<a class="sporina-news-timeline__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<div class="sporina-news-timeline__marker"></div>
				<div class="sporina-news-timeline__content">
					<?if($arParams["DISPLAY_DATE"]!="N" && !empty($arItem["DISPLAY_ACTIVE_FROM"])):?>
						<div class="sporina-news-timeline__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
					<?endif;?>
					<h3 class="sporina-news-timeline__name"><?=$arItem["NAME"]?></h3>
					<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
						<p class="sporina-news-timeline__text"><?=$arItem["PREVIEW_TEXT"]?></p>
					<?endif;?>
				</div>
			</a>
		</article>
	<?endforeach;?>
	</div>
</section>
<?endif;?>
