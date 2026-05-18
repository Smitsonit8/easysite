<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if(!empty($arResult["ITEMS"])):?>
<section class="sporina-news-cards">
	<div class="sporina-news-cards__head">
		<b class="sporina-news-cards__title"><?=$arResult["NAME"]?></b>
	</div>
	<div class="sporina-news-cards__grid">
	<?foreach($arResult["ITEMS"] as $index => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<article class="sporina-news-cards__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
			<a class="sporina-news-cards__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
				<span class="sporina-news-cards__flip">
					<span class="sporina-news-cards__face sporina-news-cards__face--front">
						<?if($arParams["DISPLAY_DATE"]!="N" && !empty($arItem["DISPLAY_ACTIVE_FROM"])):?>
							<span class="sporina-news-cards__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span>
						<?endif;?>
						<h3 class="sporina-news-cards__name"><?=$arItem["NAME"]?></h3>
					</span>
					<span class="sporina-news-cards__face sporina-news-cards__face--back">
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<span class="sporina-news-cards__text"><?=$arItem["PREVIEW_TEXT"]?></span>
						<?endif;?>
						<span class="sporina-news-cards__more"><?=GetMessage("SPORINA_READ_MORE")?></span>
					</span>
				</span>
			</a>
		</article>
	<?endforeach;?>
	</div>
</section>
<?endif;?>
