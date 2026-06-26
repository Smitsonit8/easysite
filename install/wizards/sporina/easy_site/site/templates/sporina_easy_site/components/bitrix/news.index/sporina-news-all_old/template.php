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
use Bitrix\Main\Localization\Loc;

// Подключаем локализацию
Loc::loadMessages(__FILE__);
$this->setFrameMode(true);
?>
<?$LINE_ELEMENT_COUNT=1;?>
<div class="container">
	<div class="block_news-height">
		<div class="block block_news">
			<h2>Новости</h2>
		</div>
		<div class="block_between card_news-margin owl-carousel">


					<?

					foreach($arResult["IBLOCKS"] as $arIBlock):?>

									<?
									$this->AddEditAction('iblock_'.$arIBlock['ID'], $arIBlock['ADD_ELEMENT_LINK'], CIBlock::GetArrayByID($arIBlock["ID"], "ELEMENT_ADD"));
									?>

									<?foreach($arIBlock["ITEMS"] as $arItem):?>
										<?
										$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
										$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNI_ELEMENT_DELETE_CONFIRM')));
										?>

										<?if ($arItem["PROPERTIES"]["DISPLAY_BLOCK_NEWS"]["VALUE"] == "Да"):?>
										<div class="card_news" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
											<div class="card card_news-block">
												
												<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
													<p>
														<?=$arItem["NAME"]?>
													</p>
												</a> 
												<a href="">
													<p class="card_news-color">
														<?= Loc::getMessage('TEXT_ZAG') ?>
													</p>
												</a>
											</div>
											<p>
												<?
													$pos = strpos($arItem["FIELDS"]["TIMESTAMP_X"], " "); // находим позицию первого пробела
													$date = substr($arItem["FIELDS"]["TIMESTAMP_X"], 0, $pos); // извлекаем подстроку до первого пробела
													
													echo "<span class='card_date'>$date</span>" . "<span class='card_time'>".substr($arItem["FIELDS"]["TIMESTAMP_X"], $pos)."</span>"; // выводим строку с выделенной красным датой

								

												?>
												
											</p>
										</div>
										<?endif;?>
									<?endforeach;?>

						<?

						?><?
						
					endforeach;

							?>

		</div>
	</div>
</div>
<div class="news_bg">
	<div class="container news_bg-height">
		<div class="news_bg-border">
		</div>
	</div>
</div>
