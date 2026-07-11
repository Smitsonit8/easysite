<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<section class="sporina-news-company-stand__list">
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<div class="sporina-news-company-stand__pager sporina-news-company-stand__pager--top">
			<?=$arResult["NAV_STRING"]?>
		</div>
	<?endif;?>

	<div class="sporina-news-company-stand__items">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

		$displayDate = "";
		if (!empty($arItem["DISPLAY_ACTIVE_FROM"]))
		{
			$displayDate = $arItem["DISPLAY_ACTIVE_FROM"];
		}
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
			$truncateLen = (int)$arParams["PREVIEW_TRUNCATE_LEN"];
			if ($truncateLen <= 0)
			{
				$truncateLen = 200;
			}
			$previewText = TruncateText($previewText, $truncateLen);
		}

		$canOpenDetail = !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] === "Y" && (!$arItem["DETAIL_TEXT"] || !$arResult["USER_HAVE_ACCESS"]));
		$previewPicture = is_array($arItem["PREVIEW_PICTURE"]) && !empty($arItem["PREVIEW_PICTURE"]["SRC"]) ? $arItem["PREVIEW_PICTURE"] : null;
		?>
		<article class="sporina-news-company-stand__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($previewPicture !== null):?>
				<div class="sporina-news-company-stand__item-image-wrap">
					<?if($canOpenDetail):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?endif;?>
						<img
							class="sporina-news-company-stand__item-image"
							src="<?=$previewPicture["SRC"]?>"
							alt="<?=htmlspecialcharsbx($previewPicture["ALT"] ?: $arItem["NAME"])?>"
							title="<?=htmlspecialcharsbx($previewPicture["TITLE"] ?: $arItem["NAME"])?>"
							loading="lazy"
						>
					<?if($canOpenDetail):?></a><?endif;?>
				</div>
			<?endif;?>
			<div class="sporina-news-company-stand__item-content">
				<?if($arParams["DISPLAY_DATE"] != "N" && $displayDate !== ""):?>
					<div class="sporina-news-company-stand__item-date"><?=$displayDate?></div>
				<?endif;?>
				<?if($arParams["DISPLAY_NAME"] != "N" && !empty($arItem["NAME"])):?>
					<h3 class="sporina-news-company-stand__item-title">
						<?if($canOpenDetail):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?endif;?>
							<?=$arItem["NAME"]?>
						<?if($canOpenDetail):?></a><?endif;?>
					</h3>
				<?endif;?>
				<?if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $previewText !== ""):?>
					<div class="sporina-news-company-stand__item-preview"><?=$previewText?></div>
				<?endif;?>
				<?if($canOpenDetail):?>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="sporina-news-company-stand__item-detail-link">
						<?=Loc::getMessage("SPORINA_NEWS_COMPANY_STAND_DETAIL_LINK")?>
					</a>
				<?endif;?>
			</div>
		</article>
	<?endforeach;?>
	</div>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<div class="sporina-news-company-stand__pager sporina-news-company-stand__pager--bottom">
			<?=$arResult["NAV_STRING"]?>
		</div>
	<?endif;?>
</section>