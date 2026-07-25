<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?
$hasTopPager = $arParams["DISPLAY_TOP_PAGER"] && !empty($arResult["NAV_STRING"]);
$hasBottomPager = $arParams["DISPLAY_BOTTOM_PAGER"] && !empty($arResult["NAV_STRING"]);
$itemCount = count($arResult["ITEMS"]);
?>
<section class="news-company-paper container">
	<?if($hasTopPager):?>
		<div class="sporina-news-company__pager sporina-news-company__pager--top">
			<?=$arResult["NAV_STRING"]?>
		</div>
	<?endif;?>

	<?if($itemCount > 0):?>
		<div class="news-company-paper__list">
		<?foreach($arResult["ITEMS"] as $index => $arItem):
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

			$displayDate = "";
			if (!empty($arItem["DISPLAY_ACTIVE_FROM"]))
				$displayDate = $arItem["DISPLAY_ACTIVE_FROM"];
			elseif (!empty($arItem["TIMESTAMP_X"]))
			{
				$timestamp = MakeTimeStamp($arItem["TIMESTAMP_X"]);
				$displayDate = $timestamp ? CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], $timestamp) : $arItem["TIMESTAMP_X"];
			}
			elseif (!empty($arItem["ACTIVE_FROM"]))
			{
				$timestamp = MakeTimeStamp($arItem["ACTIVE_FROM"]);
				$displayDate = $timestamp ? CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], $timestamp) : $arItem["ACTIVE_FROM"];
			}

			$previewText = "";
			if (!empty($arItem["PREVIEW_TEXT"]))
			{
				$previewText = trim(strip_tags($arItem["PREVIEW_TEXT"]));
				if ((int)$arParams["PREVIEW_TRUNCATE_LEN"] > 0)
					$previewText = TruncateText($previewText, (int)$arParams["PREVIEW_TRUNCATE_LEN"]);
			}

			$canOpenDetail = !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] === "Y" && (!$arItem["DETAIL_TEXT"] || !$arResult["USER_HAVE_ACCESS"]));
			$initial = !empty($arItem["NAME"]) ? ToUpper(mb_substr($arItem["NAME"], 0, 1)) : "";
			$previewPicture = is_array($arItem["PREVIEW_PICTURE"]) && !empty($arItem["PREVIEW_PICTURE"]["SRC"]) ? $arItem["PREVIEW_PICTURE"] : null;
			$showPicture = ($arParams["DISPLAY_PICTURE"] ?? "Y") !== "N";

			// Первая статья — на 2 колонки (шире)
			$isFirst = ($index == 0);
		?>
			<article class="news-company-paper__item<?=$isFirst ? ' news-company-paper__item--wide' : ''?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
				<?if($canOpenDetail):?><a class="news-company-paper__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?endif;?>
					<?if($showPicture):?>
					<div class="news-company-paper__media">
						<?if($previewPicture !== null):?>
							<img
								class="news-company-paper__image"
								src="<?=$previewPicture["SRC"]?>"
								alt="<?=htmlspecialcharsbx($previewPicture["ALT"] ?: $arItem["NAME"])?>"
								title="<?=htmlspecialcharsbx($previewPicture["TITLE"] ?: $arItem["NAME"])?>"
							>
						<?else:?>
							<div class="news-company-paper__placeholder"><?=$initial?></div>
						<?endif;?>
					</div>
					<?endif;?>
					<div class="news-company-paper__content">
						<?if($arParams["DISPLAY_DATE"] != "N" && $displayDate !== ""):?>
							<div class="news-company-paper__date"><?=$displayDate?></div>
						<?endif;?>
						<?if($arParams["DISPLAY_NAME"] != "N" && !empty($arItem["NAME"])):?>
							<h3 class="news-company-paper__name"><?=$arItem["NAME"]?></h3>
						<?endif;?>
						<?if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $previewText !== ""):?>
							<p class="news-company-paper__text"><?=$previewText?></p>
						<?endif;?>
					</div>
				<?if($canOpenDetail):?></a><?endif;?>
			</article>
		<?endforeach;?>
		</div>
	<?endif;?>

	<?if($hasBottomPager):?>
		<div class="sporina-news-company__pager sporina-news-company__pager--bottom">
			<?=$arResult["NAV_STRING"]?>
		</div>
	<?endif;?>
</section>
