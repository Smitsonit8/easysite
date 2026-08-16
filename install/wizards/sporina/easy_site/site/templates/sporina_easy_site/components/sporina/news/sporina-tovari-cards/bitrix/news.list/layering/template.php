<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }
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
$productVariant = 'layering';

$galleryCode = (string)($arParams['GALLERY_PROPERTY_CODE'] ?? 'GALLERY');
?>
<?php if (!empty($arResult['ITEMS'])): ?>
<section class="sporina-product-list sporina-product-list--<?=htmlspecialcharsbx($productVariant)?>">
    <div class="sporina-product-list__grid">
        <?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
            $images = [];
            if (!empty($arItem['PREVIEW_PICTURE']['SRC'])) { $images[] = $arItem['PREVIEW_PICTURE']; }
            $gallery = $arItem['PROPERTIES'][$galleryCode]['VALUE'] ?? [];
            foreach ((array)$gallery as $fileId) { if ($file = CFile::GetFileArray($fileId)) { $images[] = $file; } }
            $images = array_values(array_filter($images, static function ($image) { return !empty($image['SRC']); }));
            $url = $arItem['DETAIL_PAGE_URL'] ?: '#';
            $price = trim((string)($arItem['PROPERTIES']['PRICE']['VALUE'] ?? ''));
            ?>
            <article class="sporina-product-card sporina-product-card--reveal" id="<?=$this->GetEditAreaId($arItem['ID'])?>" data-product-card style="--product-delay: <?=($index % 8) * 70?>ms">
                <div class="sporina-product-card__media" data-product-gallery>
                    <?php foreach ($images as $imageIndex => $image): ?>
                        <a class="sporina-product-card__image<?= $imageIndex ? '' : ' is-active' ?>" href="<?=htmlspecialcharsbx($url)?>" data-product-slide>
                            <img src="<?=htmlspecialcharsbx($image['SRC'])?>" alt="<?=htmlspecialcharsbx($image['ALT'] ?: $arItem['NAME'])?>" loading="lazy">
                        </a>
                    <?php endforeach; ?>
                    <?php if (empty($images)): ?><span class="sporina-product-card__placeholder" aria-hidden="true"></span><?php endif; ?>
                    <?php if ($productVariant === 'layering' && $price !== ''): ?><p class="sporina-product-card__price sporina-product-card__price--cutout"><?=htmlspecialcharsbx($price)?></p><?php endif; ?>
                    <?php if (count($images) > 1): ?>
                        <button class="sporina-product-card__nav sporina-product-card__nav--prev" type="button" data-product-prev aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_PREVIOUS'))?>">‹</button>
                        <button class="sporina-product-card__nav sporina-product-card__nav--next" type="button" data-product-next aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_NEXT'))?>">›</button>
                        <span class="sporina-product-card__counter" data-product-counter>1 / <?=count($images)?></span>
                    <?php endif; ?>
                </div>
                <div class="sporina-product-card__content">
                    <?php if ($productVariant !== 'layering' && $price !== ''): ?><p class="sporina-product-card__price"><?=htmlspecialcharsbx($price)?></p><?php endif; ?>
                    <h3 class="sporina-product-card__title"><a href="<?=htmlspecialcharsbx($url)?>"><?=htmlspecialcharsbx($arItem['NAME'])?></a></h3>
                    <?php if ($arParams['DISPLAY_PREVIEW_TEXT'] !== 'N' && $arItem['PREVIEW_TEXT'] !== ''): ?><div class="sporina-product-card__description"><?=$arItem['PREVIEW_TEXT']?></div><?php endif; ?>
                    <a class="sporina-product-card__link" href="<?=htmlspecialcharsbx($url)?>"><?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_DETAILS'))?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if ($arParams['DISPLAY_BOTTOM_PAGER'] === 'Y'): ?><div class="sporina-product-list__pager"><?=$arResult['NAV_STRING']?></div><?php endif; ?>
</section>
<?php endif; ?>

