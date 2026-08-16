<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

$picture = !empty($arResult['DETAIL_PICTURE']['SRC'])
    ? $arResult['DETAIL_PICTURE']
    : ($arResult['PREVIEW_PICTURE'] ?? null);
$sectionName = trim((string)($arResult['SECTION_NAME'] ?? ''));
?>

<article class="sporina-services-detail">
    <header class="sporina-services-detail__hero">
        <?php if (!empty($picture['SRC']) && $arParams['DISPLAY_PICTURE'] !== 'N'): ?>
            <img
                class="sporina-services-detail__image"
                src="<?=htmlspecialcharsbx($picture['SRC'])?>"
                alt="<?=htmlspecialcharsbx($picture['ALT'] ?: $arResult['NAME'])?>"
                width="<?=isset($picture['WIDTH']) ? (int)$picture['WIDTH'] : 1600?>"
                height="<?=isset($picture['HEIGHT']) ? (int)$picture['HEIGHT'] : 900?>"
            >
        <?php else: ?>
            <div class="sporina-services-detail__placeholder" aria-hidden="true"></div>
        <?php endif; ?>

        <div class="sporina-services-detail__overlay"></div>
        <div class="sporina-services-detail__hero-content">
            <?php if ($sectionName !== ''): ?>
                <span class="sporina-services-detail__badge" title="<?=htmlspecialcharsbx($sectionName)?>"><?=htmlspecialcharsbx($sectionName)?></span>
            <?php endif; ?>
            <?php if ($arParams['DISPLAY_NAME'] !== 'N' && !empty($arResult['NAME'])): ?>
                <h1 class="sporina-services-detail__title"><?=htmlspecialcharsbx($arResult['NAME'])?></h1>
            <?php endif; ?>
        </div>
    </header>

    <div class="sporina-services-detail__body">
        <?php if ($arParams['DISPLAY_PREVIEW_TEXT'] !== 'N' && $arResult['PREVIEW_TEXT'] !== ''): ?>
            <div class="sporina-services-detail__lead"><?=$arResult['PREVIEW_TEXT']?></div>
        <?php endif; ?>
        <?php if ($arResult['DETAIL_TEXT'] !== ''): ?>
            <div class="sporina-services-detail__content"><?=$arResult['DETAIL_TEXT']?></div>
        <?php endif; ?>

        <?php if (($arParams['USE_SHARE'] ?? 'N') === 'Y'): ?>
            <div class="sporina-services-detail__share">
                <?php $APPLICATION->IncludeComponent('bitrix:main.share', $arParams['SHARE_TEMPLATE'] ?? 'sporina-social-share', [
					'SHARE_MAX' => $arParams['SHARE_MAX'] ?? 'Y',
					'SHARE_VK' => $arParams['SHARE_VK'] ?? 'Y',
					'SHARE_OK' => $arParams['SHARE_OK'] ?? 'Y',
					'SHARE_MAIL' => $arParams['SHARE_MAIL'] ?? 'Y',
                    'PAGE_URL' => $arResult['~DETAIL_PAGE_URL'],
                    'PAGE_TITLE' => $arResult['~NAME'],
                    'SHORTEN_URL_LOGIN' => $arParams['SHARE_SHORTEN_URL_LOGIN'],
                    'SHORTEN_URL_KEY' => $arParams['SHARE_SHORTEN_URL_KEY'],
                    'HIDE' => $arParams['SHARE_HIDE'],
                ], $component, ['HIDE_ICONS' => 'Y']); ?>
            </div>
        <?php endif; ?>
    </div>
</article>

<?php
if (!isset($_SESSION)) {
    Session::start();
}

if (!empty($arResult['NAME']) && is_string($arResult['NAME'])) {
    $_SESSION['FORM_USLUGA_NAME'] = trim($arResult['NAME']);
}
?>
