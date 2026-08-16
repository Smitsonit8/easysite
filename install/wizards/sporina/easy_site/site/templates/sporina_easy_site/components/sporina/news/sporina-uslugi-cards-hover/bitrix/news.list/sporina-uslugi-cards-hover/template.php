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
<div class="news-list sporina-uslugi-cards-hover">
	<div class="sporina-uslugi-cards-hover__grid">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $index => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	$pictureSrc = "";
	$pictureAlt = $arItem["NAME"];
	$pictureTitle = $arItem["NAME"];

	if (!empty($arItem["PREVIEW_PICTURE"]["SRC"]))
	{
		$pictureSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
		$pictureAlt = $arItem["PREVIEW_PICTURE"]["ALT"] ?: $pictureAlt;
		$pictureTitle = $arItem["PREVIEW_PICTURE"]["TITLE"] ?: $pictureTitle;
	}
	elseif (!empty($arItem["DETAIL_PICTURE"]["SRC"]))
	{
		$pictureSrc = $arItem["DETAIL_PICTURE"]["SRC"];
		$pictureAlt = $arItem["DETAIL_PICTURE"]["ALT"] ?: $pictureAlt;
		$pictureTitle = $arItem["DETAIL_PICTURE"]["TITLE"] ?: $pictureTitle;
	}

	$cardStyle = $pictureSrc !== ""
		? '--sporina-uslugi-card-bg: url(\'' . htmlspecialcharsbx($pictureSrc) . '\');'
		: '';
	?>
		<article class="sporina-uslugi-cards-hover__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
			<a
				class="sporina-uslugi-cards-hover__link<?=($pictureSrc !== '' ? ' sporina-uslugi-cards-hover__link--image' : '')?>"
				href="<?=$arItem["DETAIL_PAGE_URL"]?>"
				<?if($cardStyle !== ''):?>style="<?=$cardStyle?>"<?endif;?>
			>
				<div class="sporina-uslugi-cards-hover__media" aria-hidden="true"></div>
				<div class="sporina-uslugi-cards-hover__overlay"></div>
				<div class="sporina-uslugi-cards-hover__content">
					<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
						<h2 class="sporina-uslugi-cards-hover__title"><?=$arItem["NAME"]?></h2>
					<?endif;?>
					<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
						<div class="sporina-uslugi-cards-hover__text"><?=$arItem["PREVIEW_TEXT"]?></div>
					<?endif;?>
				</div>
				<?if($pictureSrc !== ''):?>
					<span class="sporina-uslugi-cards-hover__sr"><?=$pictureAlt?> <?=$pictureTitle?></span>
				<?endif;?>
			</a>
		</article>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
	</div>
</div>
