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
<section class="application_bg">
	<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="application_img-mobile">
			<?	
				$res = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['ID'], "sort", "asc", array("CODE" => "IMAGE_MOBILE"));
				if ($ob = $res->GetNext())
					{			
						$INSTRUCTION_VALUE = $ob['VALUE'];
						$file = CFile::GetFileArray($INSTRUCTION_VALUE);
						$INSTRUCTION_SRC = $file['SRC'];
					}
			?>
			<img src="<?=$INSTRUCTION_SRC;?>" alt="Мобильный баннер">
		</div>
		<div class="container position_relative">
			<div class="block application_block">
				<div class="application">
					<h2><?echo $arItem["NAME"]?></h2>
					<h4>		
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<?echo $arItem["PREVIEW_TEXT"];?>
						<?endif;?>
					</h4>
					<a href="<?=$arItem["DISPLAY_PROPERTIES"]["LINK_TO"]["DISPLAY_VALUE"]?>"><button class="button block_center"><?=$arItem["DISPLAY_PROPERTIES"]["NAME_BUTTON"]["DISPLAY_VALUE"]?></button></a>
				</div>
				<div class="block mobile_none">
					<img
					class="preview_picture"
					border="0"
					src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
					width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
					height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
					alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
					title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
					style="float:left; margin: 0;"
					/>
				</div>
			</div>
		</div>
	</p>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
	</div>
</section>
