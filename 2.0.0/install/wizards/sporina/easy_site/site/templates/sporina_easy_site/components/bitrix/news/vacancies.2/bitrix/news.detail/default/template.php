<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); 
$value = function($name) use ($arResult, $arParams) {
     $code=isset($arParams['PROPERTY_'.$name]) ? $arParams['PROPERTY_'.$name] : ''; 
    return $code!=='' && isset($arResult['PROPERTIES'][$code]['VALUE']) ? $arResult['PROPERTIES'][$code]['VALUE'] : '';
 };

 $value2 = function($name) use ($arResult, $arParams) {
     $code=isset($arParams['PROPERTY_'.$name]) ? $arParams['PROPERTY_'.$name] : ''; 
    return $code!=='' && isset($arResult['PROPERTIES'][$code]['NAME']) ? $arResult['PROPERTIES'][$code]['NAME'] : '';
 }; 

 ?>
<article class="sporina-vacancy-full">
        <?php if (!empty($arResult['DETAIL_PICTURE']['SRC'])): ?>
        <img class="sporina-vacancy-full__image" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['NAME']?>"><?php endif; ?>
        <h2><?=$arResult['NAME']?></h2>
        <dl class="sporina-vacancy-full__info">
            <div>
                <dt><?=$value2('CITY')?></dt>
                <dd><?=$value('CITY')?></dd>
            </div>
            <div>
                <dt><?=$value2('WAGE')?></dt>
                <dd><?=$value('WAGE')?></dd>
            </div>
            <div>
                <dt><?=$value2('EXP')?></dt>
                <dd><?=$value('EXP')?></dd>
            </div>
            <div>
                <dt><?=$value2('TYPE')?></dt>
                <dd><?=$value('TYPE')?></dd>
            </div>
        </dl>
        <div class="sporina-vacancy-full__text"><?=$arResult['DETAIL_TEXT'] ?: $arResult['PREVIEW_TEXT']?></div>
        <div class="sporina-vacancy__back-wrap">
            <a class="sporina-vacancy__back" href="<?=$arResult['LIST_PAGE_URL']?>">
                <svg class="sporina-vacancy__back-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M20 12H5"></path>
                    <path d="M11 18L5 12L11 6"></path>
                </svg>
                <span class="sporina-vacancy__back-text"><?=GetMessage('SPORINA_VACANCIES_2_DETAIL_BACK');?></span>
            </a>
        </div>

</article>
