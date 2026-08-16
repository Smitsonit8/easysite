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
    "ID" => "easy_promobanners",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 100,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "EASY.Рекламные баннеры",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Баннеры"
        ),
        "en" => Array(
            "NAME" => "EASY.Promo Banners",
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
    "ID" => "easy_cardsinfo",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 110,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "EASY.Карточки информации",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Карточки"
        ),
        "en" => Array(
            "NAME" => "EASY.Info Cards",
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

// Тип "Новости и статьи"
$arFields = Array(
    "ID" => "easy_news_articles",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 120,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "EASY.Новости и статьи",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Элементы"
        ),
        "en" => Array(
            "NAME" => "EASY.News and articles",
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

// Тип "Информация о компании"
$arFields = Array(
    "ID" => "easy_infocompany",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 120,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "EASY.Информация о компании",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Элементы"
        ),
        "en" => Array(
            "NAME" => "EASY.Information about company",
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
    "ID" => "easy_services",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 122,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "EASY.Услуги",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Услуги"
        ),
        "en" => Array(
            "NAME" => "EASY.Services",
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
    "ID" => "easy_products",
    "SECTIONS" => "Y",
    "IN_RSS" => "N",
    "SORT" => 123,
    "LANG" => Array(
        "ru" => Array(
            "NAME" => "EASY.Товары",
            "SECTION_NAME" => "Разделы",
            "ELEMENT_NAME" => "Товары"
        ),
        "en" => Array(
            "NAME" => "EASY.Products",
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
