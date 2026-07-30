<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }
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

use Bitrix\Main\Localization\Loc; 
Loc::loadMessages(__FILE__);

 $productVariant='smoothness';

$galleryCode = (string)($arParams['GALLERY_PROPERTY_CODE'] ?? 'GALLERY');
$images = [];
$primary = !empty($arResult['DETAIL_PICTURE']['SRC']) ? $arResult['DETAIL_PICTURE'] : ($arResult['PREVIEW_PICTURE'] ?? null);
if (!empty($primary['SRC'])) { $images[] = $primary; }
foreach ((array)($arResult['PROPERTIES'][$galleryCode]['VALUE'] ?? []) as $fileId) { if ($file = CFile::GetFileArray($fileId)) { $images[] = $file; } }
$images = array_values(array_filter($images, static function ($image) { return !empty($image['SRC']); }));
$price = trim((string)($arResult['PROPERTIES']['PRICE']['VALUE'] ?? ''));
?>
<article class="sporina-product-detail sporina-product-detail--<?=htmlspecialcharsbx($productVariant)?>" data-detail-gallery>
 <div class="sporina-product-detail__layout">
  <div class="sporina-product-detail__media">
   <?php foreach ($images as $index => $image): ?>
    <button class="sporina-product-detail__image<?= $index ? '' : ' is-active' ?>" type="button" data-detail-slide data-open-modal="<?=$index?>">
        <img src="<?=htmlspecialcharsbx($image['SRC'])?>" alt="<?=htmlspecialcharsbx($image['ALT'] ?: $arResult['NAME'])?>">
    </button><?php endforeach; ?>
   <?php if (empty($images)): ?><span class="sporina-product-detail__placeholder" aria-hidden="true"></span><?php endif; ?>
   <?php if (count($images)>1): ?>
    <button class="sporina-product-detail__nav sporina-product-detail__nav--prev" type="button" data-detail-prev aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_PREVIOUS'))?>">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
			<path d="M5 12H19"></path>
			<path d="M13 6L19 12L13 18"></path> 
		</svg>
    </button>
    <button class="sporina-product-detail__nav sporina-product-detail__nav--next" type="button" data-detail-next aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_NEXT'))?>">
		<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
			<path d="M5 12H19"></path>
			<path d="M13 6L19 12L13 18"></path> 
		</svg>
    </button><?php endif; ?>
  </div>
  <div class="sporina-product-detail__content">
   <?php if ($price !== ''): ?><p class="sporina-product-detail__price"><?=htmlspecialcharsbx($price)?></p><?php endif; ?>
   <?php if ($arParams['DISPLAY_NAME'] !== 'N'): ?><h1 class="sporina-product-detail__title"><?=htmlspecialcharsbx($arResult['NAME'])?></h1><?php endif; ?>
   <?php if ($arParams['DISPLAY_PREVIEW_TEXT'] !== 'N' && $arResult['PREVIEW_TEXT'] !== ''): ?><div class="sporina-product-detail__lead"><?=$arResult['PREVIEW_TEXT']?></div><?php endif; ?>
   <?php if ($arResult['DETAIL_TEXT'] !== ''): ?><div class="sporina-product-detail__text"><?=$arResult['DETAIL_TEXT']?></div><?php endif; ?>
  </div>
 </div>
 <?php if (count($images)>1): ?>
    <div class="sporina-product-detail__thumbs"><?php foreach($images as $index=>$image): ?>
        <button class="sporina-product-detail__thumb<?= $index ? '' : ' is-active' ?>" type="button" data-detail-thumb="<?=$index?>" aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_IMAGE') . ' ' . ($index + 1))?>" aria-current="<?=$index ? 'false' : 'true'?>">
            <img src="<?=htmlspecialcharsbx($image['SRC'])?>" alt="">
        </button><?php endforeach; ?>
    </div><?php endif; ?>
    <div class="sporina-product-modal" data-product-modal hidden role="dialog" aria-modal="true" aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_GALLERY'))?>">
        <div class="sporina-product-modal__backdrop" data-modal-close></div>
        <div class="sporina-product-modal__content">
            <button class="sporina-product-modal__close" type="button" data-modal-close aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_CLOSE'))?>">×</button>
            <img data-modal-image src="" alt="">
            <button class="sporina-product-modal__nav sporina-product-modal__nav--prev" type="button" data-modal-prev aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_PREVIOUS'))?>">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
			        <path d="M5 12H19"></path>
			        <path d="M13 6L19 12L13 18"></path> 
		        </svg>
            </button>
            <button class="sporina-product-modal__nav sporina-product-modal__nav--next" type="button" data-modal-next aria-label="<?=htmlspecialcharsbx(\Bitrix\Main\Localization\Loc::getMessage('SPORINA_PRODUCT_NEXT'))?>">
				<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 12H19"></path>
				    <path d="M13 6L19 12L13 18"></path> 
				</svg>
            </button>

        </div>
    </div>
</article>
<?php $session = \Bitrix\Main\Application::getInstance()->getSession(); 
if (!$session->isStarted()) { $session->start(); } $session->set('FORM_TOVAR_NAME', trim((string)$arResult['NAME'])); 
?>
