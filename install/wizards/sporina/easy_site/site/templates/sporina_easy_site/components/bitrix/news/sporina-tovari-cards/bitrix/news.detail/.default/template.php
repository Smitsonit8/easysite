<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


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

<!--<div class="news-detail">-->
        <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
        <h1 class="h1"><?=$arResult["NAME"]?></h1>
    <?endif;?>
<div class="services-detail-container">
    
    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
        <div class="services-detail-colons">
            <section class="image-section">
                <img
                    class="detail_picture"
                    border="0"
                    src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                    width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
                    height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
                    alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                    title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                />
            </section>
            <section class="preview-text-section">
                <p><?=$arResult["PREVIEW_TEXT"];?></p>
            </section>
        </div>

    <?endif?>

    <section class="detail-text-section">
        <?if($arResult["DETAIL_TEXT"] <> ''):?>
            <p><?echo $arResult["DETAIL_TEXT"];?></p>
        <?endif?>
    </section>

    <div style="clear:both"></div>
    <br />
    <?foreach($arResult["FIELDS"] as $code=>$value):
        if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
        {
            ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
            if (!empty($value) && is_array($value))
            {
                ?><img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>"><?
            }
        }
        else
        {
            ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?><?
        }
        ?><br />
    <?endforeach;
    foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

        <h2>
        <?=$arProperty["NAME"]?>:&nbsp;
        <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
            <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
        <?else:?>
            <?=$arProperty["DISPLAY_VALUE"];?>
        <?endif?>
        </h2>
        <br />

    <?endforeach;
    if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
    {
        ?>
        <div class="news-detail-share">
            <noindex>
            <?
            $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                    "HANDLERS" => $arParams["SHARE_HANDLERS"],
                    "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
                    "PAGE_TITLE" => $arResult["~NAME"],
                    "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                    "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                    "HIDE" => $arParams["SHARE_HIDE"],
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            );
            ?>
            </noindex>
        </div>
        <?
    }

    // Запуск сессии
    if (!isset($_SESSION)) {
        Session::start();
    }

    // Запись названия новости в сессию
    if (!empty($arResult['NAME']) && is_string($arResult['NAME'])) {
        $_SESSION['FORM_TOVAR_NAME'] = trim($arResult['NAME']);
    }
    ?>
</div>