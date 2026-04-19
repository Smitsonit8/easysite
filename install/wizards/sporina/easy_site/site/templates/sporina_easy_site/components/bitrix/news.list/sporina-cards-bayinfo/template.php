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
	<section class="container">
		<div class="block_between block_between--margin">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?if($arItem["PREVIEW_PICTURE"]["SRC"]):?>
		<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="block_info block_info--bgImg bgImg_schedule bgImg">
				<a href='<?=$arItem["DISPLAY_PROPERTIES"]["LINK_CARD"]["VALUE"]?>' class="svg">
					<div class="block">
                        <div>
                            <h2><?echo $arItem["NAME"]?></h2>
                        </div>
                        <div class="icon_top">
                            <img src="<?=SITE_TEMPLATE_PATH?>/img/arrow.svg" alt="" class="svg_color">
                        </div>
                    </div>
                    <div>
                        <p>
							<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
								<?echo $arItem["PREVIEW_TEXT"];?>
							<?endif;?>
						</p>

                    </div>
                    <div class="bgImg-position">
						<img
							class="preview_picture"
							border="0"
							src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"

							alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
							title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
							style="float:left; margin:auto;"
						/>
                    </div>
				</a>
			</div>
		</p>
		<?else:?>
		<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="block_info block_info--bgWhite">
				<a href='<?=$arItem["DISPLAY_PROPERTIES"]["LINK_CARD"]["VALUE"]?>' class="svg">
					<div class="block">
                        <div>
                            <h2><?echo $arItem["NAME"]?></h2>
                        </div>
                        <div class="icon_top">
                            <img src="<?=SITE_TEMPLATE_PATH?>/img/arrow.svg" alt="" class="svg_color">
                        </div>
                    </div>
                    <div>
                        <p>
							<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
								<?echo $arItem["PREVIEW_TEXT"];?>
							<?endif;?>
						</p>
                    </div>
				</a>
			</div>
		</p>	
	<?endif;?>
	
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
		</div>
	</section>
</div>
