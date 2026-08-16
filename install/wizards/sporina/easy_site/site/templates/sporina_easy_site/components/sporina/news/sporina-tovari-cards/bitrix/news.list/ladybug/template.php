<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$galleryCode = (string)($arParams['GALLERY_PROPERTY_CODE'] ?? 'GALLERY');
?>
<?php if (!empty($arResult['ITEMS'])): ?>
<section class="sporina-ladybug-list">
    <div class="sporina-ladybug-list__grid">
        <?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
            $images = [];
            if (!empty($arItem['PREVIEW_PICTURE']['SRC'])) { $images[] = $arItem['PREVIEW_PICTURE']; }
            foreach ((array)($arItem['PROPERTIES'][$galleryCode]['VALUE'] ?? []) as $fileId) {
                if ($file = CFile::GetFileArray($fileId)) { $images[] = $file; }
            }
            $images = array_values(array_filter($images, static function ($image) { return !empty($image['SRC']); }));
            $url = $arItem['DETAIL_PAGE_URL'] ?: '#';
            $price = trim((string)($arItem['PROPERTIES']['PRICE']['VALUE'] ?? ''));
            ?>
            <article class="sporina-ladybug-card" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                <div class="sporina-ladybug-card__media" data-product-gallery>
                    <?php foreach ($images as $imageIndex => $image): ?>
                        <a class="sporina-ladybug-card__image<?=$imageIndex ? '' : ' is-active'?>" href="<?=htmlspecialcharsbx($url)?>" data-product-slide>
                            <img src="<?=htmlspecialcharsbx($image['SRC'])?>" alt="<?=htmlspecialcharsbx($image['ALT'] ?: $arItem['NAME'])?>" loading="lazy">
                        </a>
                    <?php endforeach; ?>
                    <?php if (empty($images)): ?><span class="sporina-ladybug-card__placeholder" aria-hidden="true"></span><?php endif; ?>
                    <?php if (count($images) > 1): ?>
                        <button class="sporina-ladybug-card__nav sporina-ladybug-card__nav--prev" type="button" data-product-prev aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_PRODUCT_PREVIOUS'))?>">‹</button>
                        <button class="sporina-ladybug-card__nav sporina-ladybug-card__nav--next" type="button" data-product-next aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_PRODUCT_NEXT'))?>">›</button>
                        <span class="sporina-ladybug-card__counter" data-product-counter role="status" aria-live="polite">1 / <?=count($images)?></span>
                    <?php endif; ?>
                </div>
                <div class="sporina-ladybug-card__content">
                    <div class="sporina-ladybug-card__heading">
                        <h3 class="sporina-ladybug-card__title"><a href="<?=htmlspecialcharsbx($url)?>"><?=htmlspecialcharsbx($arItem['NAME'])?></a></h3>
                        <?php if ($price !== ''): ?><span class="sporina-ladybug-card__price"><?=htmlspecialcharsbx($price)?></span><?php endif; ?>
                    </div>
                    <?php if ($arParams['DISPLAY_PREVIEW_TEXT'] !== 'N' && $arItem['PREVIEW_TEXT'] !== ''): ?><div class="sporina-ladybug-card__description"><?=$arItem['PREVIEW_TEXT']?></div><?php endif; ?>
                    <a class="sporina-ladybug-card__link" href="<?=htmlspecialcharsbx($url)?>"><?=htmlspecialcharsbx(Loc::getMessage('SPORINA_PRODUCT_DETAILS'))?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if ($arParams['DISPLAY_BOTTOM_PAGER'] === 'Y'): ?><div class="sporina-ladybug-list__pager"><?=$arResult['NAV_STRING']?></div><?php endif; ?>
</section>
<?php endif; ?>
