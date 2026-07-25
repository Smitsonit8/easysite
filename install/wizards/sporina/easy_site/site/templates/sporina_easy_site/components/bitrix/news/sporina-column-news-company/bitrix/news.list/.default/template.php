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
<?
	$layout = $arParams['COLUMNS_LAYOUT'] ?? 'two';

	$layoutClasses = [
		'two' => 'news--default-two',
		'stacked' => 'news--default-stacked',
	];

	$layoutClass = $layoutClasses[$layout] ?? $layoutClasses['two'];
?>
<div class="card_padding <?=htmlspecialcharsbx($layoutClass)?>">

		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?><br />
		<?endif;?>
		<?$i=0;?>
		<?foreach($arResult["ITEMS"] as $index => $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$formattedFields = array();
			foreach ($arItem["FIELDS"] as $code => $value)
			{
				if (($code === "TIMESTAMP_X" || $code === "ACTIVE_FROM") && !empty($value))
				{
					$timestamp = MakeTimeStamp($value);
					$formattedFields[$code] = $timestamp ? CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], $timestamp) : $value;
				}
				else
				{
					$formattedFields[$code] = $value;
				}
			}
			?>
			<?$i++;?>
			<?if ($i !== count($arResult["ITEMS"])):?>
				<a class="card-a" href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
				<div class="card card-anim" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
					<!--<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">-->
						<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
							<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
						<?endif?>
						<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
							<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
								<p><?echo $arItem["NAME"]?></p>
							<?else:?>
								<p><?echo $arItem["NAME"]?></p>
							<?endif;?>
						<?endif;?>
						<?foreach($formattedFields as $code=>$value):?>
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
				</a>
				
				<?else:?>
					<a class="card-a" href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
					<div class="card card_bottom card-anim" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
						<!--<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">-->
					
						<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
							<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
						<?endif?>
						<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
							<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
								<p><?echo $arItem["NAME"]?></p>
							<?else:?>
								<p><?echo $arItem["NAME"]?></p>
							<?endif;?>
						<?endif;?>
						<?foreach($formattedFields as $code=>$value):?>
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
					</a>
			<?endif?>
		<?endforeach;?>

		<?php

		$iblockUrl = $arParams['IBLOCK_URL'] ?? '';
		?>
		<a href=<?=$iblockUrl?> class="svg">
			<div class="block block-margin">
				<div>
					<h4><?=GetMessage("TEXT_OPEN_ALL")?></h4>
				</div>
				<div>
					<svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_arrow">
						<path d="M15.7113 0.237988C15.4731 0.0661272 15.1784 -0.0173099 14.8814 0.00299519C14.5843 0.0233003 14.3049 0.145985 14.0943 0.348524C13.8837 0.551064 13.7562 0.819866 13.7351 1.10558C13.714 1.39129 13.8007 1.67474 13.9794 1.90389L19.299 7.0206H1.23711C0.909011 7.0206 0.594346 7.14596 0.362342 7.36912C0.130338 7.59227 0 7.89494 0 8.21053C0 8.52612 0.130338 8.82878 0.362342 9.05194C0.594346 9.27509 0.909011 9.40046 1.23711 9.40046H19.299L13.9794 14.5172C13.8007 14.7463 13.714 15.0298 13.7351 15.3155C13.7562 15.6012 13.8837 15.87 14.0943 16.0725C14.3049 16.2751 14.5843 16.3978 14.8814 16.4181C15.1784 16.4384 15.4731 16.3549 15.7113 16.1831L23.134 9.04348L24 8.21053L23.134 7.37758"></path>
					</svg>
				</div>
			</div>
	 	</a>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<br /><?=$arResult["NAV_STRING"]?>
		<?endif;?>
</div>

