<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Создание типов инфоблоков
// Этот файл будет выполнен при установке мастера

// Подключаем модуль инфоблоков
if (!CModule::IncludeModule("iblock")) {
    return false;
}

// Используем константу мастера для ID сайта
$siteID = WIZARD_SITE_ID;

// Создаем типы инфоблоков

// Тип "Рекламные баннеры"
$arFields = Array(
    "ID" => "advertising_bannerss",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 100,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "Рекламные баннеры",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Баннеры"
        ),
        "en" => Array(
            "NAME" => "Advertising Banners",
            "SECTION_NAME" => "Sections",
            "ELEMENT_NAME" => "Banners"
        )
    )
);
$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res) {
    $DB->Rollback();
} else {
    $DB->Commit();
}

// Тип "Карточки информации"
$arFields = Array(
    "ID" => "cards_info",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 110,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "Карточки информации",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Карточки"
        ),
        "en" => Array(
            "NAME" => "Info Cards",
            "SECTION_NAME" => "Sections",
            "ELEMENT_NAME" => "Cards"
        )
    )
);
$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res) {
    $DB->Rollback();
} else {
    $DB->Commit();
}

// Тип "Новости и изменения"
$arFields = Array(
    "ID" => "news_and_changes",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 120,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "Новости и изменения",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Элементы"
        ),
        "en" => Array(
            "NAME" => "News and Changes",
            "SECTION_NAME" => "Sections",
            "ELEMENT_NAME" => "Items"
        )
    )
);
$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res) {
    $DB->Rollback();
} else {
    $DB->Commit();
}

// Тип "Услуги"
$arFields = Array(
    "ID" => "services",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 122,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "Услуги",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Услуги"
        ),
        "en" => Array(
            "NAME" => "Services",
            "SECTION_NAME" => "Sections",
            "ELEMENT_NAME" => "Services"
        )
    )
);
$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res) {
    $DB->Rollback();
} else {
    $DB->Commit();
}

// Тип "Товары"
$arFields = Array(
    "ID" => "products",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 123,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "Товары",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Товары"
        ),
        "en" => Array(
            "NAME" => "Products",
            "SECTION_NAME" => "Sections",
            "ELEMENT_NAME" => "Products"
        )
    )
);
$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res) {
    $DB->Rollback();
} else {
    $DB->Commit();
}

return true;
?>
