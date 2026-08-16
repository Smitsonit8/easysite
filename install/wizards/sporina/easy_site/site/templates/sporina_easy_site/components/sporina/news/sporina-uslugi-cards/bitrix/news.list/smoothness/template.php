<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

$componentId = 'sporina-services-' . substr(md5($this->GetEditAreaId('services')), 0, 8);
$showSectionBadge = ($arParams['SHOW_SECTION_BADGE'] ?? 'Y') !== 'N';
$badgePosition = ($arParams['SECTION_BADGE_POSITION'] ?? 'left') === 'right' ? 'right' : 'left';
$showPicture = ($arParams['DISPLAY_PICTURE'] ?? 'Y') !== 'N';
?>

<?php if (!empty($arResult['ITEMS'])): ?>
<section class="sporina-services" id="<?=htmlspecialcharsbx($componentId)?>">
    <div class="sporina-services__grid">
        <?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
            <?php
            $this->AddEditAction(
                $arItem['ID'],
                $arItem['EDIT_LINK'],
                CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT')
            );
            $this->AddDeleteAction(
                $arItem['ID'],
                $arItem['DELETE_LINK'],
                CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'),
                ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
            );

            $itemUrl = !empty($arItem['DETAIL_PAGE_URL']) ? $arItem['DETAIL_PAGE_URL'] : '#';
            $picture = !empty($arItem['PREVIEW_PICTURE']['SRC'])
                ? $arItem['PREVIEW_PICTURE']
                : ($arItem['DETAIL_PICTURE'] ?? null);
            $description = !empty($arItem['PREVIEW_TEXT'])
                ? $arItem['PREVIEW_TEXT']
                : ($arItem['DETAIL_TEXT'] ?? '');
            $sectionName = trim((string)($arItem['SECTION_NAME'] ?? ''));
            ?>
            <article
                class="sporina-services__card sporina-services__card--reveal"
                id="<?=$this->GetEditAreaId($arItem['ID'])?>"
                style="--sporina-delay: <?=($index % 6) * 90?>ms;"
            >
                <div class="sporina-services__media<?=($showPicture ? '' : ' sporina-services__media--hidden')?>">
                    <div class="sporina-services__image-box">
                        <?php if ($showSectionBadge && $sectionName !== ''): ?>
                            <span class="sporina-services__badge sporina-services__badge--<?=htmlspecialcharsbx($badgePosition)?>" title="<?=htmlspecialcharsbx($sectionName)?>">
                                <?=htmlspecialcharsbx($sectionName)?>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($picture['SRC'])): ?>
                            <img
                                class="sporina-services__image"
                                src="<?=htmlspecialcharsbx($picture['SRC'])?>"
                                alt="<?=htmlspecialcharsbx($picture['ALT'] ?: $arItem['NAME'])?>"
                                loading="lazy"
                                width="<?=isset($picture['WIDTH']) ? (int)$picture['WIDTH'] : 800?>"
                                height="<?=isset($picture['HEIGHT']) ? (int)$picture['HEIGHT'] : 560?>"
                            >
                        <?php else: ?>
                            <div class="sporina-services__placeholder" aria-hidden="true"></div>
                        <?php endif; ?>

                        <div class="sporina-services__cutout">
                            <a class="sporina-services__button" href="<?=htmlspecialcharsbx($itemUrl)?>" aria-label="<?=htmlspecialcharsbx(GetMessage('SPORINA_SERVICES_MORE_ARIA') . ': ' . $arItem['NAME'])?>">
                                <svg class="sporina-services__arrow" viewBox="0 0 24 17" aria-hidden="true" focusable="false">
                                    <path d="M15.7113.238a1.17 1.17 0 0 0-1.617.11 1.1 1.1 0 0 0-.115 1.556l5.32 5.117H1.237C.554 7.021 0 7.554 0 8.21c0 .657.554 1.19 1.237 1.19h18.062l-5.32 5.117a1.1 1.1 0 0 0 .115 1.556 1.17 1.17 0 0 0 1.617.11l7.423-7.14L24 8.21l-.866-.833-7.423-7.14Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="sporina-services__content">
                    <h3 class="sporina-services__title"><a href="<?=htmlspecialcharsbx($itemUrl)?>"><?=htmlspecialcharsbx($arItem['NAME'])?></a></h3>
                    <?php if ($arParams['DISPLAY_PREVIEW_TEXT'] !== 'N' && $description !== ''): ?>
                        <div class="sporina-services__description"><?=$description?></div>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
