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
<?foreach($arResult["ITEMS"] as $index => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?if($arItem["PREVIEW_PICTURE"]["SRC"]):?>
		<p class="news-item sporina-cards-bayinfo__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
			<div class="block_info block_info--bgImg bgImg_schedule bgImg sporina-cards-bayinfo__card sporina-cards-bayinfo__card--image">
				<a href='<?=$arItem["DISPLAY_PROPERTIES"]["LINK_CARD"]["VALUE"]?>' class="svg sporina-cards-bayinfo__link">
					<div class="block">
                        <div>
                            <h3 class="service-title"><?echo $arItem["NAME"]?></h3>
                        </div>
                        <div class="icon_top sporina-cards-bayinfo__icon">
                            <!--<img src="<?=SITE_TEMPLATE_PATH?>/img/arrow.svg" alt="" class="svg_color">-->
							<svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_color">
							<path d="M15.7113 0.237988C15.4731 0.0661272 15.1784 -0.0173099 14.8814 0.00299519C14.5843 0.0233003 14.3049 0.145985 14.0943 0.348524C13.8837 0.551064 13.7562 0.819866 13.7351 1.10558C13.714 1.39129 13.8007 1.67474 13.9794 1.90389L19.299 7.0206H1.23711C0.909011 7.0206 0.594346 7.14596 0.362342 7.36912C0.130338 7.59227 0 7.89494 0 8.21053C0 8.52612 0.130338 8.82878 0.362342 9.05194C0.594346 9.27509 0.909011 9.40046 1.23711 9.40046H19.299L13.9794 14.5172C13.8007 14.7463 13.714 15.0298 13.7351 15.3155C13.7562 15.6012 13.8837 15.87 14.0943 16.0725C14.3049 16.2751 14.5843 16.3978 14.8814 16.4181C15.1784 16.4384 15.4731 16.3549 15.7113 16.1831L23.134 9.04348L24 8.21053L23.134 7.37758"/>
							</svg>
                        </div>
                    </div>
                    <div>
                        <p>
							<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
								<?echo $arItem["PREVIEW_TEXT"];?>
							<?endif;?>
						</p>

                    </div>
                    <div class="bgImg-position sporina-cards-bayinfo__media">
						<img
							class="preview_picture sporina-cards-bayinfo__image"
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
		<p class="news-item sporina-cards-bayinfo__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
			<div class="block_info block_info--bgWhite sporina-cards-bayinfo__card">
				<a href='<?=$arItem["DISPLAY_PROPERTIES"]["LINK_CARD"]["VALUE"]?>' class="svg sporina-cards-bayinfo__link">
					<div class="block">
                        <div>
                            <h3 class="service-title"><?echo $arItem["NAME"]?></h3>
                        </div>
                        <div class="icon_top sporina-cards-bayinfo__icon">
                            <!--<img src="<?=SITE_TEMPLATE_PATH?>/img/arrow.svg" alt="" class="svg_color">-->
							<svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_color">
							<path d="M15.7113 0.237988C15.4731 0.0661272 15.1784 -0.0173099 14.8814 0.00299519C14.5843 0.0233003 14.3049 0.145985 14.0943 0.348524C13.8837 0.551064 13.7562 0.819866 13.7351 1.10558C13.714 1.39129 13.8007 1.67474 13.9794 1.90389L19.299 7.0206H1.23711C0.909011 7.0206 0.594346 7.14596 0.362342 7.36912C0.130338 7.59227 0 7.89494 0 8.21053C0 8.52612 0.130338 8.82878 0.362342 9.05194C0.594346 9.27509 0.909011 9.40046 1.23711 9.40046H19.299L13.9794 14.5172C13.8007 14.7463 13.714 15.0298 13.7351 15.3155C13.7562 15.6012 13.8837 15.87 14.0943 16.0725C14.3049 16.2751 14.5843 16.3978 14.8814 16.4181C15.1784 16.4384 15.4731 16.3549 15.7113 16.1831L23.134 9.04348L24 8.21053L23.134 7.37758"/>
							</svg>
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
