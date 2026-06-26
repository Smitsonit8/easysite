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
<?
$hasTopPager = $arParams["DISPLAY_TOP_PAGER"] && !empty($arResult["NAV_STRING"]);
$hasBottomPager = $arParams["DISPLAY_BOTTOM_PAGER"] && !empty($arResult["NAV_STRING"]);
?>
<section class="news-company-list container">
	<?if($hasTopPager):?>
		<div class="sporina-news-company__pager sporina-news-company__pager--top">
			<?=$arResult["NAV_STRING"]?>
		</div>
	<?endif;?>

	<div class="news-company-list__items">
	<?foreach($arResult["ITEMS"] as $index => $arItem):?>
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
			if ((int)$arParams["PREVIEW_TRUNCATE_LEN"] > 0)
			{
				$previewText = TruncateText($previewText, (int)$arParams["PREVIEW_TRUNCATE_LEN"]);
			}
		}

		$canOpenDetail = !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] === "Y" && (!$arItem["DETAIL_TEXT"] || !$arResult["USER_HAVE_ACCESS"]));
		?>
		<article class="news-company-list__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
			<?if($canOpenDetail):?><a class="news-company-list__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?endif;?>
				<div class="news-company-list__card">
					<?if($arParams["DISPLAY_DATE"] != "N" && $displayDate !== ""):?>
						<div class="news-company-list__date"><?=$displayDate?></div>
					<?endif;?>

					<?if($arParams["DISPLAY_NAME"] != "N" && !empty($arItem["NAME"])):?>
						<h3 class="news-company-list__name"><?=$arItem["NAME"]?></h3>
					<?endif;?>

					<?if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $previewText !== ""):?>
						<p class="news-company-list__text"><?=$previewText?></p>
					<?endif;?>
				</div>
			<?if($canOpenDetail):?></a><?endif;?>
		</article>
	<?endforeach;?>
	</div>

	<?if($hasBottomPager):?>
		<div class="sporina-news-company__pager sporina-news-company__pager--bottom">
			<?=$arResult["NAV_STRING"]?>
		</div>
	<?endif;?>
</section>
