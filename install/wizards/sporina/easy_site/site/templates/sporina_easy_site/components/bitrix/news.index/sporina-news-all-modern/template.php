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
<section class="sporina-news-all-modern">
	<div class="container">
		<div class="sporina-news-all-modern__header">
			<div>
				<div class="sporina-news-all-modern__eyebrow"><?=Loc::getMessage("BLOCK_EYEBROW")?></div>
				<h2 class="sporina-news-all-modern__title"><?=Loc::getMessage("BLOCK_TITLE")?></h2>
			</div>
			<p class="sporina-news-all-modern__description"><?=Loc::getMessage("BLOCK_DESCRIPTION")?></p>
		</div>

		<div
			class="owl-carousel js-sporina-news-slider sporina-news-all-modern__slider"
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

					$itemTag = !empty($arIBlock["NAME"])
						? $arIBlock["NAME"]
						: Loc::getMessage("TEXT_ZAG");
					?>
					<article class="sporina-news-all-modern__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<a class="sporina-news-all-modern__card" href="<?=$arItem['DETAIL_PAGE_URL']?>">
							<div class="sporina-news-all-modern__card-top">
								<span class="sporina-news-all-modern__badge"><?=$itemTag?></span>
								<?if($date !== "" || $time !== ""):?>
									<div class="sporina-news-all-modern__meta">
										<?if($date !== ""):?><span class="sporina-news-all-modern__date"><?=$date?></span><?endif;?>
										<?if($time !== ""):?><span class="sporina-news-all-modern__time"><?=$time?></span><?endif;?>
									</div>
								<?endif;?>
							</div>
							<h3 class="sporina-news-all-modern__card-title"><?=$arItem["NAME"]?></h3>
							<div class="sporina-news-all-modern__card-bottom">
								<span class="sporina-news-all-modern__more"><?=Loc::getMessage("READ_MORE")?></span>
								<span class="sporina-news-all-modern__arrow" aria-hidden="true">
									<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path d="M5 12H19" />
										<path d="M13 6L19 12L13 18" />
									</svg>
								</span>
							</div>
						</a>
					</article>
				<?endforeach;?>
			<?endforeach;?>
		</div>
	</div>
</section>
