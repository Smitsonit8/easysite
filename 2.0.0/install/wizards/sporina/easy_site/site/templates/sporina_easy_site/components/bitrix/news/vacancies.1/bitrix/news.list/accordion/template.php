<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$this->addExternalJs($templateFolder . '/script.js');
$sections = isset($arResult['SPORINA_SECTIONS']) ? $arResult['SPORINA_SECTIONS'] : array();
$uid = 'sporina-vacancies-'.substr(md5($this->GetFolder()), 0, 8);
?>
<?php if (!empty($sections)): ?>
<section class="sporina-vacancies" id="<?=$uid?>">
    <?php foreach ($sections as $section): ?>
    <section class="sporina-vacancies__section">
        <h2 class="sporina-vacancies__section-title"><?=htmlspecialcharsbx($section['NAME'])?></h2>
        <? 
        foreach ($section['ITEMS'] as $item): 
            $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT')); 
            $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <article class="sporina-vacancies__item" id="<?=$this->GetEditAreaId($item['ID'])?>">
            <button class="sporina-vacancies__toggle" type="button" aria-expanded="false">
                <span class="sporina-vacancies__title"><?=$item['NAME']?></span>
                <span class="sporina-vacancies__salary"><?=isset($item['PROPERTIES'][$arParams['PROPERTY_SALARY']]['VALUE']) ? $item['PROPERTIES'][$arParams['PROPERTY_SALARY']]['VALUE'] : ''?></span>
                <span class="sporina-vacancies__indicators" aria-hidden="true">
                    <span class="sporina-vacancies-accordion__arrow">
                        <svg
                            width="24"
                            height="17"
                            viewBox="0 0 24 17"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="sporina-vacancies-accordion__arrow-svg"
                        >
                            <path d="M15.7113 0.237988C15.4731 0.0661272 15.1784 -0.0173099 14.8814 0.00299519C14.5843 0.0233003 14.3049 0.145985 14.0943 0.348524C13.8837 0.551064 13.7562 0.819866 13.7351 1.10558C13.714 1.39129 13.8007 1.67474 13.9794 1.90389L19.299 7.0206H1.23711C0.909011 7.0206 0.594346 7.14596 0.362342 7.36912C0.130338 7.59227 0 7.89494 0 8.21053C0 8.52612 0.130338 8.82878 0.362342 9.05194C0.594346 9.27509 0.909011 9.40046 1.23711 9.40046H19.299L13.9794 14.5172C13.8007 14.7463 13.714 15.0298 13.7351 15.3155C13.7562 15.6012 13.8837 15.87 14.0943 16.0725C14.3049 16.2751 14.5843 16.3978 14.8814 16.4181C15.1784 16.4384 15.4731 16.3549 15.7113 16.1831L23.134 9.04348L24 8.21053L23.134 7.37758"></path>
                        </svg>
                    </span>
                </span>
            </button>
            <div class="sporina-vacancies__description" aria-hidden="true"><?=$item['SPORINA_DESCRIPTION']?></div>
        </article>
        <?php endforeach; ?>
    </section>
    <?php endforeach; ?>
</section>

<?php endif; ?>
