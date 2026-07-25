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
$isEditMode = false;
if (is_object($APPLICATION) && method_exists($APPLICATION, "GetShowIncludeAreas"))
{
	$isEditMode = (bool)$APPLICATION->GetShowIncludeAreas();
}
?>
<?
	$layout = $arParams['COLUMNS_LAYOUT'] ?? 'two';

	$layoutClasses = [
		'two' => 'sporina-news-cards--two',
		'stacked' => 'sporina-news-cards--stacked',
	];

	$layoutClass = $layoutClasses[$layout] ?? $layoutClasses['two'];
?>

<?if(!empty($arResult["ITEMS"])):?>
<section class="sporina-news-cards <?=htmlspecialcharsbx($layoutClass)?>">
	<div class="sporina-news-cards__head">
		<b class="sporina-news-cards__title"><?=$arResult["NAME"]?></b>
	</div>
	<div class="sporina-news-cards__grid">
	<?foreach($arResult["ITEMS"] as $index => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		$displayDate = "";
		if (!empty($arItem["DISPLAY_ACTIVE_FROM"]))
		{
			$displayDate = $arItem["DISPLAY_ACTIVE_FROM"];
		}
		elseif (!empty($arItem["TIMESTAMP_X"]))
		{
			$timestamp = MakeTimeStamp($arItem["TIMESTAMP_X"]);
			if ($timestamp)
			{
				$displayDate = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], $timestamp);
			}
			else
			{
				$displayDate = $arItem["TIMESTAMP_X"];
			}
		}
		elseif (!empty($arItem["ACTIVE_FROM"]))
		{
			$timestamp = MakeTimeStamp($arItem["ACTIVE_FROM"]);
			if ($timestamp)
			{
				$displayDate = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], $timestamp);
			}
			else
			{
				$displayDate = $arItem["ACTIVE_FROM"];
			}
		}
		?>
		<article class="sporina-news-cards__item<?=($isEditMode ? ' sporina-news-cards__item--edit' : '')?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="animation-delay: <?=($index * 0.08)?>s;">
			<?if($isEditMode):?>
				<a class="sporina-news-cards__link sporina-news-cards__link--edit" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
					<span class="sporina-news-cards__edit-card">
						<?if($arParams["DISPLAY_DATE"]!="N" && $displayDate !== ""):?>
							<span class="sporina-news-cards__date"><?=$displayDate?></span>
						<?endif;?>
						<h3 class="sporina-news-cards__name"><?=$arItem["NAME"]?></h3>
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<span class="sporina-news-cards__text sporina-news-cards__text--edit"><?=$arItem["PREVIEW_TEXT"]?></span>
						<?endif;?>
						<span class="sporina-news-cards__more sporina-news-cards__more--edit"><?=GetMessage("SPORINA_READ_MORE")?></span>
					</span>
				</a>
			<?else:?>
				<a class="sporina-news-cards__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
					<span class="sporina-news-cards__flip">
						<span class="sporina-news-cards__face sporina-news-cards__face--front">
							<?if($arParams["DISPLAY_DATE"]!="N" && $displayDate !== ""):?>
								<span class="sporina-news-cards__date"><?=$displayDate?></span>
							<?endif;?>
							<h3 class="sporina-news-cards__name"><?=$arItem["NAME"]?></h3>
						</span>
						<span class="sporina-news-cards__face sporina-news-cards__face--back">
							<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
								<span class="sporina-news-cards__text"><?=$arItem["PREVIEW_TEXT"]?></span>
							<?endif;?>
							<span class="sporina-news-cards__more"><?=GetMessage("SPORINA_READ_MORE")?></span>
						</span>
					</span>
				</a>
			<?endif;?>
		</article>
	<?endforeach;?>
	</div>
	<?$listPageUrl = "";
	if (!empty($arParams["LIST_PAGE_URL"]))
	{
		$listPageUrl = $arParams["LIST_PAGE_URL"];
	}
	elseif (!empty($arResult["IBLOCK_URL"]))
	{
		$listPageUrl = $arResult["IBLOCK_URL"];
	}
	?>
	<?if(($arParams["SHOW_MORE_BUTTON"] ?? "Y") !== "N" && $listPageUrl !== ""):?>
		<div class="sporina-news-cards__actions">
			<a class="sporina-news-cards__all button" href="<?=$listPageUrl?>"><?=GetMessage("SPORINA_SHOW_MORE")?></a>
		</div>
	<?endif;?>
</section>
<?endif;?>
