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
	if (is_array($arResult["DETAIL_PICTURE"]) && !empty($arResult["DETAIL_PICTURE"]["SRC"]))
	{
		$heroPicture = $arResult["DETAIL_PICTURE"];
	}
	elseif (!empty($arResult["FIELDS"]["DETAIL_PICTURE"]))
	{
		$heroPicture = CFile::GetFileArray($arResult["FIELDS"]["DETAIL_PICTURE"]);
	}
	elseif (is_array($arResult["PREVIEW_PICTURE"]) && !empty($arResult["PREVIEW_PICTURE"]["SRC"]))
	{
		$heroPicture = $arResult["PREVIEW_PICTURE"];
	}
	elseif (!empty($arResult["FIELDS"]["PREVIEW_PICTURE"]))
	{
		$heroPicture = CFile::GetFileArray($arResult["FIELDS"]["PREVIEW_PICTURE"]);
	}
}

$previewText = "";
if (
	$arParams["DISPLAY_PREVIEW_TEXT"] != "N"
	&& !empty($arResult["FIELDS"]["PREVIEW_TEXT"])
	&& $arResult["DETAIL_TEXT"] <> ''
)
{
	$previewText = trim($arResult["FIELDS"]["PREVIEW_TEXT"]);
}

$detailProperties = array();
foreach ($arResult["DISPLAY_PROPERTIES"] as $arProperty)
{
	if (empty($arProperty["DISPLAY_VALUE"]))
	{
		continue;
	}

	$propertyValue = is_array($arProperty["DISPLAY_VALUE"])
		? implode(" / ", $arProperty["DISPLAY_VALUE"])
		: $arProperty["DISPLAY_VALUE"];

	$detailProperties[] = array(
		"NAME" => $arProperty["NAME"],
		"VALUE" => $propertyValue,
	);
}
?>
<article class="news-company-paper-detail">
	<div class="news-company-paper-detail__hero<?=($heroPicture !== null ? " news-company-paper-detail__hero--with-media" : "")?>">
		<div class="news-company-paper-detail__hero-content">
			<?if($arParams["DISPLAY_DATE"] != "N" && $displayDate !== ""):?>
				<div class="news-company-paper-detail__meta">
					<span class="news-company-paper-detail__date"><?=$displayDate?></span>
				</div>
			<?endif;?>

			<?if($arParams["DISPLAY_NAME"] != "N" && !empty($arResult["NAME"])):?>
				<h1 class="news-company-paper-detail__title"><?=$arResult["NAME"]?></h1>
			<?endif;?>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && !empty($arResult["PREVIEW_TEXT"])):?>
			<div class="sporina-news-company__detail-preview">
			<?=$arResult["PREVIEW_TEXT"]?>
			</div>
			<?endif;?>

			<?if($previewText !== ""):?>
				<div class="news-company-paper-detail__lead"><?=$previewText?></div>
			<?endif;?>
		</div>

		<?if($heroPicture !== null):?>
			<div class="news-company-paper-detail__hero-media">
				<img
					class="news-company-paper-detail__image"
					src="<?=$heroPicture["SRC"]?>"
					alt="<?=htmlspecialcharsbx($heroPicture["ALT"] ?: $arResult["NAME"])?>"
					title="<?=htmlspecialcharsbx($heroPicture["TITLE"] ?: $arResult["NAME"])?>"
				>
			</div>
		<?endif;?>
	</div>

	<div class="news-company-paper-detail__body">
		<?if($arResult["NAV_RESULT"]):?>
			<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br><?endif;?>
			<?=$arResult["NAV_TEXT"]?>
			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br><?=$arResult["NAV_STRING"]?><?endif;?>
		<?elseif($arResult["DETAIL_TEXT"] <> ''):?>
			<?=$arResult["DETAIL_TEXT"]?>
		<?elseif($arParams["DISPLAY_PREVIEW_TEXT"] != "N"):?>
			<?=$arResult["PREVIEW_TEXT"]?>
		<?endif;?>
	</div>

	<?if(!empty($detailProperties)):?>
		<div class="news-company-paper-detail__properties">
			<?foreach($detailProperties as $property):?>
				<div class="news-company-paper-detail__property">
					<div class="news-company-paper-detail__property-name"><?=$property["NAME"]?></div>
					<div class="news-company-paper-detail__property-value"><?=$property["VALUE"]?></div>
				</div>
			<?endforeach;?>
		</div>
	<?endif;?>

	<?if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y"):?>
		<div class="news-company-paper-detail__share">
			<noindex>
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
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
			</noindex>
		</div>
	<?endif;?>
</article>
