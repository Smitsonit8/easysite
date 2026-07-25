<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$showSectionBadge = ($arParams['SHOW_SECTION_BADGE'] ?? 'Y') !== 'N';
$badgePosition = ($arParams['SECTION_BADGE_POSITION'] ?? 'left') === 'right' ? 'right' : 'left';
$showPicture = ($arParams['DISPLAY_PICTURE'] ?? 'Y') !== 'N';
?>

<?php if (!empty($arResult['ITEMS'])): ?>
<section class="sporina-service-cards">
    <div class="sporina-service-cards__grid">
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

            $url = $arItem['DETAIL_PAGE_URL'] ?: '#';
            $picture = $arItem['PREVIEW_PICTURE'] ?: $arItem['DETAIL_PICTURE'];
            $description = $arItem['PREVIEW_TEXT'] ?: $arItem['DETAIL_TEXT'];
            $section = $arItem['SPORINA_SECTION'] ?? null;
            ?>

            <article
                class="sporina-service-card sporina-service-card--reveal"
                id="<?=$this->GetEditAreaId($arItem['ID'])?>"
                style="--card-delay: <?=($index % 6) * 90?>ms"
            >
                <div class="sporina-service-card__outer">
                    <div class="sporina-service-card__inner">
                        <a class="sporina-service-card__media<?=($showPicture ? '' : ' sporina-service-card__media--hidden')?>" href="<?=htmlspecialcharsbx($url)?>">
                            <?php if (!empty($picture['SRC'])): ?>
                                <img
                                    class="sporina-service-card__image"
                                    src="<?=htmlspecialcharsbx($picture['SRC'])?>"
                                    alt="<?=htmlspecialcharsbx($picture['ALT'] ?: $arItem['NAME'])?>"
                                    loading="lazy"
                                >
                            <?php else: ?>
                                <span class="sporina-service-card__placeholder"></span>
                            <?php endif; ?>
                        </a>

                        <div class="sporina-service-card__content">
                            <?php if ($showSectionBadge && !empty($section['NAME'])): ?>
                                <div class="sporina-service-card__section sporina-service-card__section--<?=htmlspecialcharsbx($badgePosition)?>" title="<?=htmlspecialcharsbx($section['NAME'])?>">
                                    <?=htmlspecialcharsbx($section['NAME'])?>
                                </div>
                            <?php endif; ?>

                            <h3 class="sporina-service-card__title">
                                <a href="<?=htmlspecialcharsbx($url)?>">
                                    <?=htmlspecialcharsbx($arItem['NAME'])?>
                                </a>
                            </h3>

                            <?php if ($arParams['DISPLAY_PREVIEW_TEXT'] !== 'N' && $description !== ''): ?>
                                <div class="sporina-service-card__description">
                                    <?=$description?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <a class="sporina-service-card__more" href="<?=htmlspecialcharsbx($url)?>">
                        <span class="sporina-services__arrow-text"><?=Loc::getMessage("BUTTON_MORE");?></span>
                        <svg class="sporina-service-card__arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M20 12H5" />
                            <path d="M11 18L5 12L11 6" />
                        </svg>
                        
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
