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
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

$pictureSrc = "";
$pictureAlt = $arResult["NAME"];
$pictureTitle = $arResult["NAME"];

if (!empty($arResult["DETAIL_PICTURE"]["SRC"]))
{
	$pictureSrc = $arResult["DETAIL_PICTURE"]["SRC"];
	$pictureAlt = $arResult["DETAIL_PICTURE"]["ALT"] ?: $pictureAlt;
	$pictureTitle = $arResult["DETAIL_PICTURE"]["TITLE"] ?: $pictureTitle;
}
elseif (!empty($arResult["PREVIEW_PICTURE"]["SRC"]))
{
	$pictureSrc = $arResult["PREVIEW_PICTURE"]["SRC"];
	$pictureAlt = $arResult["PREVIEW_PICTURE"]["ALT"] ?: $pictureAlt;
	$pictureTitle = $arResult["PREVIEW_PICTURE"]["TITLE"] ?: $pictureTitle;
}

$heroStyle = $pictureSrc !== ""
	? 'style="background-image: url(\'' . htmlspecialcharsbx($pictureSrc) . '\');"'
	: '';
?>
<article class="sporina-uslugi-detail" id="<?=$this->GetEditAreaId($arResult['ID']);?>">
	<div class="sporina-uslugi-detail__hero<?=($pictureSrc === '' ? ' sporina-uslugi-detail__hero--no-image' : '')?>">
		<?if($pictureSrc !== ''):?>
			<div class="sporina-uslugi-detail__hero-media" <?=$heroStyle?> role="img" aria-label="<?=htmlspecialcharsbx($pictureAlt)?>"></div>
		<?endif;?>
		<div class="sporina-uslugi-detail__hero-inner">
			<div class="sporina-uslugi-detail__main">
				<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
					<div class="sporina-uslugi-detail__eyebrow"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
				<?endif;?>
				<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
					<h1 class="sporina-uslugi-detail__title"><?=$arResult["NAME"]?></h1>
				<?endif;?>
				<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["PREVIEW_TEXT"]):?>
					<p class="sporina-uslugi-detail__announce"><?=$arResult["PREVIEW_TEXT"]?></p>
				<?endif;?>
			</div>
			<div class="sporina-uslugi-detail__aside">
				<div class="sporina-uslugi-detail__badge">
					<div class="sporina-uslugi-detail__badge-label"><?=Loc::getMessage("SERVICE_BADGE_LABEL")?></div>
					<div class="sporina-uslugi-detail__badge-value"><?=$arResult["NAME"]?></div>
				</div>
			</div>
		</div>
	</div>

	<div class="sporina-uslugi-detail__body">
		<div class="sporina-uslugi-detail__content">
			<?if($arResult["DETAIL_TEXT"] <> ''):?>
				<div class="news-detail-text"><?=$arResult["DETAIL_TEXT"];?></div>
			<?elseif($arResult["PREVIEW_TEXT"] <> ''):?>
				<div class="news-detail-text"><?=$arResult["PREVIEW_TEXT"];?></div>
			<?endif;?>
		</div>
	</div>
</article>
