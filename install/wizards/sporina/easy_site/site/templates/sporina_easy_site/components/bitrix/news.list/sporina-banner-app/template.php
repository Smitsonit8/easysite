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
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	// Фон: DETAIL_PICTURE если есть, иначе просто цветной фон
	$bgStyle = '';
	if ($arItem["DETAIL_PICTURE"]["SRC"])
	{
		$bgSrc = htmlspecialcharsbx($arItem["DETAIL_PICTURE"]["SRC"]);
		$bgStyle = "background-image: linear-gradient(135deg, rgba(18, 84, 132, 0.74), rgba(0, 0, 0, 0.58)), url('{$bgSrc}'); background-position: center, center; background-repeat: no-repeat, no-repeat; background-size: auto, cover;";
	}

	// IMAGE_MOBILE
	$mobileImgSrc = '';
	if (isset($arItem["DISPLAY_PROPERTIES"]["IMAGE_MOBILE"]["FILE_VALUE"]["SRC"]))
	{
		$mobileImgSrc = $arItem["DISPLAY_PROPERTIES"]["IMAGE_MOBILE"]["FILE_VALUE"]["SRC"];
	}
	elseif (isset($arItem["DISPLAY_PROPERTIES"]["IMAGE_MOBILE"]["VALUE"]))
	{
		$mobileImgFile = CFile::GetFileArray($arItem["DISPLAY_PROPERTIES"]["IMAGE_MOBILE"]["VALUE"]);
		if ($mobileImgFile)
		{
			$mobileImgSrc = $mobileImgFile["SRC"];
		}
	}

	// NAME_BUTTON
	$nameButton = trim((string)($arItem["DISPLAY_PROPERTIES"]["NAME_BUTTON"]["DISPLAY_VALUE"] ?? ''));

	// LINK_TO
	$linkTo = trim((string)($arItem["DISPLAY_PROPERTIES"]["LINK_TO"]["DISPLAY_VALUE"] ?? ''));
	?>
	<section class="application_bg" id="<?=$this->GetEditAreaId($arItem['ID']);?>"<?if ($bgStyle):?> style="<?=$bgStyle?>"<?endif;?>>
		<?if ($mobileImgSrc):?>
			<div class="application_img-mobile">
				<img src="<?=htmlspecialcharsbx($mobileImgSrc)?>" alt="<?=htmlspecialcharsbx($arItem["NAME"])?>">
			</div>
		<?endif;?>
		<div class="container position_relative">
			<div class="block application_block">
				<div class="application">
					<h2><?=$arItem["NAME"]?></h2>
					<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
						<h4><?=$arItem["PREVIEW_TEXT"]?></h4>
					<?endif;?>
					<?if ($nameButton && $linkTo):?>
						<a href="<?=htmlspecialcharsbx($linkTo)?>" class="button block_center"><?=htmlspecialcharsbx($nameButton)?></a>
					<?endif;?>
				</div>
				<?if ($arItem["PREVIEW_PICTURE"]["SRC"]):?>
					<div class="block mobile_none">
						<img
							class="preview_picture"
							border="0"
							src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
							width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
							height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
							alt="<?=htmlspecialcharsbx($arItem["PREVIEW_PICTURE"]["ALT"])?>"
							title="<?=htmlspecialcharsbx($arItem["PREVIEW_PICTURE"]["TITLE"])?>"
						/>
					</div>
				<?endif;?>
			</div>
		</div>
	</section>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
