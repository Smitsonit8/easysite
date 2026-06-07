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

Loc::loadMessages(__FILE__);
$this->setFrameMode(true);

$showNavigation = isset($arParams["SHOW_SLIDER_NAVIGATION"])
	? $arParams["SHOW_SLIDER_NAVIGATION"]
	: "Y";
$enableAutoplay = isset($arParams["ENABLE_SLIDER_AUTOPLAY"])
	? $arParams["ENABLE_SLIDER_AUTOPLAY"]
	: "N";
$autoplayTimeout = (int)$arParams["SLIDER_AUTOPLAY_TIMEOUT"];

if ($autoplayTimeout < 1000)
{
	$autoplayTimeout = 5000;
}
?>
<div class="sporina-news-all">
	<div class="container">
		<div class="block_news-height">
			<div class="block block_news sporina-news-all__heading">
				<h2><?=Loc::getMessage("BLOCK_TITLE")?></h2>
			</div>
			<div
				class="block_between card_news-margin owl-carousel js-sporina-news-slider sporina-news-all__slider"
				data-nav="<?=$showNavigation?>"
				data-autoplay="<?=$enableAutoplay?>"
				data-autoplay-timeout="<?=$autoplayTimeout?>"
				data-nav-prev-label="<?=htmlspecialcharsbx(Loc::getMessage("SLIDER_PREV"))?>"
				data-nav-next-label="<?=htmlspecialcharsbx(Loc::getMessage("SLIDER_NEXT"))?>"
			>
				<?foreach($arResult["IBLOCKS"] as $arIBlock):?>
					<?$this->AddEditAction('iblock_'.$arIBlock['ID'], $arIBlock['ADD_ELEMENT_LINK'], CIBlock::GetArrayByID($arIBlock["ID"], "ELEMENT_ADD"));?>
					<?foreach($arIBlock["ITEMS"] as $arItem):?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNI_ELEMENT_DELETE_CONFIRM')));

						if ($arItem["PROPERTIES"]["DISPLAY_BLOCK_NEWS"]["VALUE"] !== "Да")
						{
							continue;
						}

						$dateTime = trim((string)$arItem["FIELDS"]["TIMESTAMP_X"]);
						$date = "";
						$time = "";

						if ($dateTime !== "")
						{
							$dateParts = explode(" ", $dateTime, 2);
							$date = $dateParts[0];
							$time = isset($dateParts[1]) ? trim($dateParts[1]) : "";
						}
						?>
						<div class="card_news sporina-news-all__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
							<div class="card card_news-block sporina-news-all__card">
								<a class="sporina-news-all__link" href="<?=$arItem['DETAIL_PAGE_URL']?>">
									<p class="sporina-news-all__title">
										<?=$arItem["NAME"]?>
									</p>
								</a>
								<span class="card_news-color sporina-news-all__tag">
									<?=Loc::getMessage('TEXT_ZAG')?>
								</span>
							</div>
							<?if($date !== "" || $time !== ""):?>
								<p class="sporina-news-all__meta">
									<?if($date !== ""):?><span class="card_date"><?=$date?></span><?endif;?>
									<?if($time !== ""):?><span class="card_time"> <?=$time?></span><?endif;?>
								</p>
							<?endif;?>
						</div>
					<?endforeach;?>
				<?endforeach;?>
			</div>
		</div>
	</div>
</div>
<div class="news_bg">
	<div class="container news_bg-height">
		<div class="news_bg-border">
		</div>
	</div>
</div>
