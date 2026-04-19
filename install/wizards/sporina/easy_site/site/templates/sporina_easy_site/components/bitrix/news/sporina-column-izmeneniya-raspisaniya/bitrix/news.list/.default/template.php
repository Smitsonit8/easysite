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
<!--<div class="news-list">-->
	<div class="card_padding">
		
		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?><br />
		<?endif;?>
		<?$i=0;?>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<?$i++;?>
			<?if ($i !== count($arResult["ITEMS"])):?>
				
				<div class="card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<!--<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">-->
						<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
							<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
						<?endif?>
						<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
							<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
								<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><p><?echo $arItem["NAME"]?></p></a>
							<?else:?>
								<p><?echo $arItem["NAME"]?></p>
							<?endif;?>
						<?endif;?>
						<?foreach($arItem["FIELDS"] as $code=>$value):?>
							<p>
								<?
									$pos = strpos($value, " "); // находим позицию первого пробела
									$date = substr($value, 0, $pos); // извлекаем подстроку до первого пробела
									
									echo "<span class='card_date'>$date</span>" . "<span class='card_time'>".substr($value, $pos)."</span>"; // выводим строку с выделенной красным датой
								?>
							</p>
						<?endforeach;?>
						<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
							<small>
							<?=$arProperty["NAME"]?>:&nbsp;
							<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
								<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
							<?else:?>
								<?=$arProperty["DISPLAY_VALUE"];?>
							<?endif?>
							</small><br />
						<?endforeach;?>	
					<!--</p>-->				
				</div>
				
				<?else:?>
					
					<div class="card card_bottom" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<!--<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">-->
					
						<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
							<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
						<?endif?>
						<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
							<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
								<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><p><?echo $arItem["NAME"]?></p></a>
							<?else:?>
								<p><?echo $arItem["NAME"]?></p>
							<?endif;?>
						<?endif;?>
						<?foreach($arItem["FIELDS"] as $code=>$value):?>
							<p>
								<?
									$pos = strpos($value, " "); // находим позицию первого пробела
									$date = substr($value, 0, $pos); // извлекаем подстроку до первого пробела
									
									echo "<span class='card_date'>$date</span>" . "<span class='card_time'>".substr($value, $pos)."</span>"; // выводим строку с выделенной красным датой
								?>
							</p>
						<?endforeach;?>
						<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
							<small>
							<?=$arProperty["NAME"]?>:&nbsp;
							<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
								<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
							<?else:?>
								<?=$arProperty["DISPLAY_VALUE"];?>
							<?endif?>
							</small><br />
						<?endforeach;?>
						
						<!--</p>-->
					</div>
					
			<?endif?>
		<?endforeach;?>
		<?php

		$iblockUrl = $arParams['IBLOCK_URL'] ?? '';
		?>
		<a href=<?=$iblockUrl?> class="svg">

			
			<div class="block">
				<div>
					<h4>Все изменения</h4>
				</div>
				<div class="icon_top">
					<img src="<?=SITE_TEMPLATE_PATH?>/img/arrow.svg" alt="" class="svg_color">
				</div>
			</div>
	 	</a>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<br /><?=$arResult["NAV_STRING"]?>
		<?endif;?>
	</div>
	<!--
</div>-->
