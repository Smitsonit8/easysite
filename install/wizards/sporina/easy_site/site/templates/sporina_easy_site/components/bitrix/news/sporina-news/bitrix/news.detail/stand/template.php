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

$heroPicture = null;
if ($arParams["DISPLAY_PICTURE"] != "N")
{
	if (!empty($arResult["DETAIL_PICTURE"]) && is_array($arResult["DETAIL_PICTURE"]))
	{
		$heroPicture = $arResult["DETAIL_PICTURE"];
	}
	elseif (!empty($arResult["PREVIEW_PICTURE"]) && is_array($arResult["PREVIEW_PICTURE"]))
	{
		$heroPicture = $arResult["PREVIEW_PICTURE"];
	}
}
?>
<article class="sporina-news-company-stand__detail">
	<?if($arParams["DISPLAY_DATE"] != "N" && $displayDate !== ""):?>
		<div class="sporina-news-company-stand__detail-date"><?=$displayDate?></div>
	<?endif;?>

	<?if($arParams["DISPLAY_NAME"] != "N" && !empty($arResult["NAME"])):?>
		<h1 class="sporina-news-company-stand__detail-title"><?=$arResult["NAME"]?></h1>
	<?endif;?>

	<?if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && !empty($arResult["PREVIEW_TEXT"])):?>
		<div class="sporina-news-company-stand__detail-preview">
		<?=$arResult["PREVIEW_TEXT"]?>
		</div>
	<?endif;?>

	<?if($heroPicture !== null):?>
		<div class="sporina-news-company-stand__detail-image-wrap">
			<img
				class="sporina-news-company-stand__detail-image"
				src="<?=$heroPicture["SRC"]?>"
				alt="<?=htmlspecialcharsbx($heroPicture["ALT"] ?: $arResult["NAME"])?>"
				title="<?=htmlspecialcharsbx($heroPicture["TITLE"] ?: $arResult["NAME"])?>"
				loading="lazy"
			>
		</div>
	<?endif;?>

	<div class="sporina-news-company-stand__detail-body">
		<?if($arResult["NAV_RESULT"]):?>
			<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
			<?=$arResult["NAV_TEXT"]?>
			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
		<?elseif($arResult["DETAIL_TEXT"] <> ''):?>
			<?=$arResult["DETAIL_TEXT"]?>
		<?elseif($arParams["DISPLAY_PREVIEW_TEXT"] != "N"):?>
			<?=$arResult["PREVIEW_TEXT"]?>
		<?endif;?>
	</div>

	<?if(($arParams["USE_SHARE"] ?? "N") === "Y"):?>
		<div class="sporina-news-company-stand__detail-share">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.share",
				"sporina-social-share",
				array(
					"SHARE_MAX" => $arParams["SHARE_MAX"] ?? "Y",
					"SHARE_VK" => $arParams["SHARE_VK"] ?? "Y",
					"SHARE_OK" => $arParams["SHARE_OK"] ?? "Y",
					"SHARE_MAIL" => $arParams["SHARE_MAIL"] ?? "Y",
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
		</div>
	<?endif;?>
</article>
