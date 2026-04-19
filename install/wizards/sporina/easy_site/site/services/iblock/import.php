<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Импорт инфоблоков из XML файлов
// Этот файл будет выполнен при установке мастера

// Подключаем модуль инфоблоков
if (!CModule::IncludeModule("iblock")) {
    return false;
}

if(COption::GetOptionString("sporina.easysite", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

// Используем константу мастера для ID сайта
$siteID = WIZARD_SITE_ID;

// Права доступа для создаваемых инфоблоков
$permissions = Array(
    1 => "X",  // Администраторы - полный доступ
    2 => "R",  // Все пользователи - чтение
);

// Директория с XML файлами
$xmlDir = WIZARD_SERVICE_RELATIVE_PATH . "/xml/" . LANGUAGE_ID . "/";

// Массив для импорта инфоблоков
$importList = array(
    array(
        "XML_FILE" => $xmlDir . "banners.xml",
        "IBLOCK_TYPE_ID" => "advertising_bannerss",
        "IBLOCK_CODE" => "advertising_bannerss",
        "XML_ID_PREFIX" => "advertising_bannerss"
    ),
    array(
        "XML_FILE" => $xmlDir . "cards-info.xml",
        "IBLOCK_TYPE_ID" => "cards_info",
        "IBLOCK_CODE" => "cards_info",
        "XML_ID_PREFIX" => "cards_info",
        "XML_FILE_ALT" => $xmlDir . "cards_info.xml" // Альтернативное название файла
    ),
    array(
        "XML_FILE" => $xmlDir . "news_companii.xml",
        "IBLOCK_TYPE_ID" => "news_and_changes",
        "IBLOCK_CODE" => "news_companii",
        "XML_ID_PREFIX" => "news_companii"
    ),
    array(
        "XML_FILE" => $xmlDir . "schedule_changes.xml",
        "IBLOCK_TYPE_ID" => "news_and_changes",
        "IBLOCK_CODE" => "schedule_changes",
        "XML_ID_PREFIX" => "schedule_changes"
    ),
    array(
        "XML_FILE" => $xmlDir . "services.xml",
        "IBLOCK_TYPE_ID" => "services",
        "IBLOCK_CODE" => "services",
        "XML_ID_PREFIX" => "services"
    ),
    array(
        "XML_FILE" => $xmlDir . "products.xml",
        "IBLOCK_TYPE_ID" => "products",
        "IBLOCK_CODE" => "products",
        "XML_ID_PREFIX" => "products"
    ),
);

// Импортируем каждый инфоблок из XML файла
foreach ($importList as $importItem) {
    // Проверяем существование XML файла
    $xmlFilePath = $_SERVER["DOCUMENT_ROOT"] . $importItem["XML_FILE"];
    // Если файл не найден, пробуем альтернативное название
    if (!file_exists($xmlFilePath) && isset($importItem["XML_FILE_ALT"])) {
        $xmlFilePath = $_SERVER["DOCUMENT_ROOT"] . $importItem["XML_FILE_ALT"];
        if (file_exists($xmlFilePath)) {
            $importItem["XML_FILE"] = $importItem["XML_FILE_ALT"];
        }
    }
    if (!file_exists($xmlFilePath)) {
        continue;
    }
    
    // Проверяем, существует ли уже инфоблок с таким XML_ID
    $iblockCode = $importItem["XML_ID_PREFIX"] . "_" . WIZARD_SITE_ID;
    $rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $importItem["IBLOCK_TYPE_ID"]));
    $iblockID = false;
    if ($arIBlock = $rsIBlock->Fetch())
    {
        $iblockID = $arIBlock["ID"];
        if (WIZARD_INSTALL_DEMO_DATA)
        {
            CIBlock::Delete($arIBlock["ID"]);
            $iblockID = false;
        }
    }
    
    if($iblockID == false)
    {
        // Импортируем инфоблок из XML файла используя WizardServices::ImportIBlockFromXML
        // Это правильный метод, который создает инфоблоки со свойствами
        $iblockID = WizardServices::ImportIBlockFromXML(
            $importItem["XML_FILE"],
            $importItem["XML_ID_PREFIX"],
            $importItem["IBLOCK_TYPE_ID"],
            $siteID,
            $permissions
        );
        
        if ($iblockID < 1)
            continue;
        
        // Обновляем XML_ID инфоблока для уникальности
        $iblock = new CIBlock;
        $arFields = Array(
            "XML_ID" => $iblockCode,
            "CODE" => $importItem["IBLOCK_CODE"],
        );
        $iblock->Update($iblockID, $arFields);
    }
    else
    {
        // Если инфоблок уже существует, проверяем привязку к сайту
        $arSites = array();
        $db_res = CIBlock::GetSite($iblockID);
        while ($res = $db_res->Fetch())
            $arSites[] = $res["LID"];
        if (!in_array(WIZARD_SITE_ID, $arSites))
        {
            $arSites[] = WIZARD_SITE_ID;
            $iblock = new CIBlock;
            $iblock->Update($iblockID, array("LID" => $arSites));
        }
    }
    
    // Если импорт прошел успешно, обновляем URL'ы инфоблока
    if ($iblockID > 0) {
        $ib = new CIBlock;
        
        // Определяем URL'ы в зависимости от типа инфоблока
        $listPageUrl = "";
        $sectionPageUrl = "";
        $detailPageUrl = "";
        
        switch ($importItem["IBLOCK_CODE"]) {
            case "advertising_bannerss":
                // Для баннеров не нужны страницы списка и деталей
                break;
                
            case "cards_info":
                $listPageUrl = "#SITE_DIR#/cards/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/cards/list.php?SECTION_ID=#SECTION_ID#";
                $detailPageUrl = "#SITE_DIR#/cards/detail.php?ID=#ELEMENT_ID#";
                break;
                
            case "news_companii":
                $listPageUrl = "#SITE_DIR#/news_and_changes/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/novosti-kompanii/";
                $detailPageUrl = "#SITE_DIR#/novosti-kompanii/#ELEMENT_CODE#/";
                break;
                
            case "schedule_changes":
                $listPageUrl = "#SITE_DIR#/news_and_changes/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/izmeneniya-v-raspisanii/";
                $detailPageUrl = "#SITE_DIR#/izmeneniya-v-raspisanii/#ELEMENT_CODE#";
                break;
                
            case "services":
                $listPageUrl = "#SITE_DIR#/services/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/services/";
                $detailPageUrl = "#SITE_DIR#/services/detail.php?ID=#ELEMENT_ID#";
                break;
                
            case "products":
                $listPageUrl = "#SITE_DIR#/products/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/products/list.php?SECTION_ID=#SECTION_ID#";
                $detailPageUrl = "#SITE_DIR#/products/detail.php?ID=#ELEMENT_ID#";
                break;
        }
        
        // Обновляем URL'ы инфоблока
        if ($listPageUrl || $sectionPageUrl || $detailPageUrl) {
            $ib->Update($iblockID, array(
                "LIST_PAGE_URL" => $listPageUrl,
                "SECTION_PAGE_URL" => $sectionPageUrl,
                "DETAIL_PAGE_URL" => $detailPageUrl
            ));
        }
    }
}

return true;
?>