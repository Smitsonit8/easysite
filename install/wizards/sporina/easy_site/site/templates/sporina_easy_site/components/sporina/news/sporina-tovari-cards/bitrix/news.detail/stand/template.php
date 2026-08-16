<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$galleryCode = (string)($arParams['GALLERY_PROPERTY_CODE'] ?? 'GALLERY');
$images = [];
$primaryImage = !empty($arResult['DETAIL_PICTURE']['SRC'])
    ? $arResult['DETAIL_PICTURE']
    : ($arResult['PREVIEW_PICTURE'] ?? null);

if (!empty($primaryImage['SRC'])) {
    $images[] = $primaryImage;
}

foreach ((array)($arResult['PROPERTIES'][$galleryCode]['VALUE'] ?? []) as $fileId) {
    $image = CFile::GetFileArray($fileId);
    if (!empty($image['SRC'])) {
        $images[] = $image;
    }
}

$images = array_values(array_filter($images, static function ($image) {
    return !empty($image['SRC']);
}));
$price = trim((string)($arResult['PROPERTIES']['PRICE']['VALUE'] ?? ''));
$productName = (string)($arResult['NAME'] ?? '');
?>
<article class="sporina-stand-product" data-detail-gallery>
    <?php if ($arParams['DISPLAY_NAME'] !== 'N' && $productName !== ''): ?>
        <h1 class="sporina-stand-product__title"><?=htmlspecialcharsbx($productName)?></h1>
    <?php endif; ?>

    <div class="sporina-stand-product__layout">
        <div class="sporina-stand-product__gallery">
            <div class="sporina-stand-product__media">
                <?php foreach ($images as $index => $image): ?>
                    <button class="sporina-stand-product__slide<?=$index ? '' : ' is-active'?>" type="button" data-detail-slide aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_OPEN_IMAGE') . ' ' . ($index + 1))?>">
                        <img src="<?=htmlspecialcharsbx($image['SRC'])?>" alt="<?=htmlspecialcharsbx($image['ALT'] ?: $productName)?>">
                    </button>
                <?php endforeach; ?>
                <?php if (empty($images)): ?>
                    <span class="sporina-stand-product__placeholder" aria-hidden="true"></span>
                <?php endif; ?>
                <?php if (count($images) > 1): ?>
                    <button class="sporina-stand-product__nav sporina-stand-product__nav--prev" type="button" data-detail-prev aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_PREVIOUS'))?>">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					        <path d="M5 12H19"></path>
				            <path d="M13 6L19 12L13 18"></path> 
				        </svg>
                    </button>
                    <button class="sporina-stand-product__nav sporina-stand-product__nav--next" type="button" data-detail-next aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_NEXT'))?>">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					        <path d="M5 12H19"></path>
				            <path d="M13 6L19 12L13 18"></path> 
				        </svg>
                    </button>
                <?php endif; ?>
            </div>

            <?php if (count($images) > 1): ?>
                <div class="sporina-stand-product__thumbs" aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_GALLERY'))?>">
                    <?php foreach ($images as $index => $image): ?>
                        <button class="sporina-stand-product__thumb<?=$index ? '' : ' is-active'?>" type="button" data-detail-thumb aria-current="<?=$index ? 'false' : 'true'?>" aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_IMAGE') . ' ' . ($index + 1))?>">
                            <img src="<?=htmlspecialcharsbx($image['SRC'])?>" alt="">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="sporina-stand-product__content">
            <?php if ($arParams['DISPLAY_PREVIEW_TEXT'] !== 'N' && $arResult['PREVIEW_TEXT'] !== ''): ?>
                <div class="sporina-stand-product__lead"><?=$arResult['PREVIEW_TEXT']?></div>
            <?php endif; ?>
            <?php if ($arResult['DETAIL_TEXT'] !== ''): ?>
                <div class="sporina-stand-product__text"><?=$arResult['DETAIL_TEXT']?></div>
            <?php endif; ?>
            <?php if ($price !== ''): ?>
                <p class="sporina-stand-product__price"><span class="sporina-stand-product__price-value"><?=htmlspecialcharsbx($price)?></span></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="sporina-stand-product__modal" data-product-modal hidden role="dialog" aria-modal="true" aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_GALLERY'))?>">
        <div class="sporina-stand-product__backdrop" data-modal-close></div>
        <div class="sporina-stand-product__modal-content">
            <button class="sporina-stand-product__modal-close" type="button" data-modal-close aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_CLOSE'))?>">
                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.11 2.697L2.698 4.11 6.586 8l-3.89 3.89 1.415 1.413L8 9.414l3.89 3.89 1.413-1.415L9.414 8l3.89-3.89-1.415-1.413L8 6.586l-3.89-3.89z" fill=""></path>
                </svg>
            </button>
            <img data-modal-image src="" alt="">
            <?php if (count($images) > 1): ?>
                <button class="sporina-stand-product__modal-nav sporina-stand-product__modal-nav--prev" type="button" data-modal-prev aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_PREVIOUS'))?>">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 12H19"></path>
				    <path d="M13 6L19 12L13 18"></path> 
				    </svg>
                </button>
                <button class="sporina-stand-product__modal-nav sporina-stand-product__modal-nav--next" type="button" data-modal-next aria-label="<?=htmlspecialcharsbx(Loc::getMessage('SPORINA_STAND_NEXT'))?>">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					    <path d="M5 12H19"></path>
				        <path d="M13 6L19 12L13 18"></path> 
				    </svg>
                </button>
            <?php endif; ?>
        </div>
    </div>
</article>
<?php
$session = Application::getInstance()->getSession();
if (!$session->isStarted()) {
    $session->start();
}
$session->set('FORM_TOVAR_NAME', trim($productName));
?>
