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

$displayDate = "";
if (!empty($arResult["DISPLAY_ACTIVE_FROM"]))
{
	$displayDate = $arResult["DISPLAY_ACTIVE_FROM"];
}
elseif (!empty($arResult["ACTIVE_FROM"]))
{
	$timestamp = MakeTimeStamp($arResult["ACTIVE_FROM"]);
	$displayDate = $timestamp ? CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], $timestamp) : $arResult["ACTIVE_FROM"];
}
elseif (!empty($arResult["TIMESTAMP_X"]))
{
	$timestamp = MakeTimeStamp($arResult["TIMESTAMP_X"]);
	$displayDate = $timestamp ? CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], $timestamp) : $arResult["TIMESTAMP_X"];
}
?>
<div class="sporina-news-detail" itemscope itemtype="http://schema.org/NewsArticle">
	<div class="sporina-news-detail__top">
	<?if($arResult["FIELDS"]["PREVIEW_PICTURE"] || $arResult["FIELDS"]["DETAIL_PICTURE"]):
		$picture = $arResult["FIELDS"]["DETAIL_PICTURE"] ?: $arResult["FIELDS"]["PREVIEW_PICTURE"];
	?>
		<div class="sporina-news-detail__image-wrap">
			<img
				src="<?=$picture["SRC"]?>"
				alt="<?=$picture["ALT"] ?: $arResult["NAME"]?>"
				title="<?=$picture["TITLE"] ?: $arResult["NAME"]?>"
				class="sporina-news-detail__image"
				itemprop="image"
			/>
		</div>
	<?endif;?>

		<div class="sporina-news-detail__content">
		<?if($arParams["DISPLAY_DATE"]!="N" && $displayDate !== ""):?>
			<div class="sporina-news-detail__date" itemprop="datePublished">
				<?=$displayDate?>
			</div>
		<?endif;?>

		<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
			<h1 class="sporina-news-detail__title" itemprop="headline">
				<?=$arResult["NAME"]?>
			</h1>
		<?endif;?>

		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
			<div class="sporina-news-detail__preview" itemprop="description">
				<?=$arResult["FIELDS"]["PREVIEW_TEXT"]?>
			</div>
		<?endif;?>
		</div>
	</div>

	<?if($arResult["FIELDS"]["DETAIL_TEXT"]):?>
		<div class="sporina-news-detail__detail-text" itemprop="articleBody">
			<?=$arResult["FIELDS"]["DETAIL_TEXT"]?>
		</div>
	<?endif;?>

	<?if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y"):?>
		<div class="sporina-news-detail__share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent(
				"bitrix:main.share",
				"",
				Array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
	<?endif;?>

	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<div class="sporina-news-detail__pager"><?=$arResult["NAV_STRING"]?></div>
		<?endif;?>

		<?=$arResult["NAV_TEXT"]?>

		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<div class="sporina-news-detail__pager"><?=$arResult["NAV_STRING"]?></div>
		<?endif;?>
	<?elseif($arResult["FIELDS"]["DETAIL_TEXT"]):?>
		<?// detail text already shown above ?>
	<?endif;?>
</div>
