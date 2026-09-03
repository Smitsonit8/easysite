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
$iblockVersion = "v1";

// Права доступа для создаваемых инфоблоков
$permissions = Array(
    1 => "X",  // Администраторы - полный доступ
    2 => "R",  // Все пользователи - чтение
);

// Директория с XML файлами
$xmlDir = WIZARD_SERVICE_RELATIVE_PATH . "/v1/xml/" . LANGUAGE_ID . "/";

// Массив для импорта инфоблоков
$importList = array(
    array(
        "XML_FILE" => $xmlDir . "banners.xml",
        "IBLOCK_TYPE_ID" => "easy_promobanners",
        "IBLOCK_CODE" => "promo_banners",
        "XML_ID_PREFIX" => "promo_banners"
    ),
    array(
        "XML_FILE" => $xmlDir . "cards-info.xml",
        "IBLOCK_TYPE_ID" => "easy_cardsinfo",
        "IBLOCK_CODE" => "cards_info",
        "XML_ID_PREFIX" => "cards_info",
        "XML_FILE_ALT" => $xmlDir . "cards_info.xml" // Альтернативное название файла
    ),
    array(
        "XML_FILE" => $xmlDir . "news.xml",
        "IBLOCK_TYPE_ID" => "easy_news_articles",
        "IBLOCK_CODE" => "news_company",
        "XML_ID_PREFIX" => "news_company"
    ),
    array(
        "XML_FILE" => $xmlDir . "articles.xml",
        "IBLOCK_TYPE_ID" => "easy_news_articles",
        "IBLOCK_CODE" => "articles_company",
        "XML_ID_PREFIX" => "articles_company"
    ),
    array(
        "XML_FILE" => $xmlDir . "services.xml",
        "IBLOCK_TYPE_ID" => "easy_services",
        "IBLOCK_CODE" => "services",
        "XML_ID_PREFIX" => "services"
    ),
    array(
        "XML_FILE" => $xmlDir . "products.xml",
        "IBLOCK_TYPE_ID" => "easy_products",
        "IBLOCK_CODE" => "products",
        "XML_ID_PREFIX" => "products"
    ),
    array(
        "XML_FILE" => $xmlDir . "jobs.xml",
        "IBLOCK_TYPE_ID" => "easy_infocompany",
        "IBLOCK_CODE" => "jobs_company",
        "XML_ID_PREFIX" => "jobs_company"
    ),
    array(
        "XML_FILE" => $xmlDir . "staff.xml",
        "IBLOCK_TYPE_ID" => "easy_infocompany",
        "IBLOCK_CODE" => "staff_company",
        "XML_ID_PREFIX" => "staff_company"
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
    $iblockXmlId = $importItem["XML_ID_PREFIX"] . "_" . WIZARD_SITE_ID . "_" . $iblockVersion;
    $iblockCode = $importItem["IBLOCK_CODE"] . "_" . $iblockVersion;
    $rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockXmlId, "TYPE" => $importItem["IBLOCK_TYPE_ID"]));
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
            "XML_ID" => $iblockXmlId,
            "CODE" => $iblockCode,
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
            case "promo_banners":
                // Для баннеров не нужны страницы списка и деталей
                break;
                
            case "cards_info":
                $listPageUrl = "#SITE_DIR#/cards/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/cards/list.php?SECTION_ID=#SECTION_ID#";
                $detailPageUrl = "#SITE_DIR#/cards/detail.php?ID=#ELEMENT_ID#";
                break;
                
            case "news_company":
                $listPageUrl = "#SITE_DIR#/novosti-kompanii/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/novosti-kompanii/";
                $detailPageUrl = "#SITE_DIR#/novosti-kompanii/#ELEMENT_CODE#/";
                break;
                
            case "articles_company":
                $listPageUrl = "#SITE_DIR#/izmeneniya-v-raspisanii/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/izmeneniya-v-raspisanii/";
                $detailPageUrl = "#SITE_DIR#/izmeneniya-v-raspisanii/#ELEMENT_CODE#/";
                break;
                
            case "services":
                $listPageUrl = "#SITE_DIR#/uslugi/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/uslugi/";
                $detailPageUrl = "#SITE_DIR#/uslugi/#ELEMENT_CODE#/";
                break;
            
            case "products":
                $listPageUrl = "#SITE_DIR#/tovary/index.php?ID=#IBLOCK_ID#";
                $sectionPageUrl = "#SITE_DIR#/tovary/";
                $detailPageUrl = "#SITE_DIR#/tovary/#ELEMENT_CODE#/";
                break;
                
            case "jobs_company":
                $listPageUrl = "#SITE_DIR#/about/jobs/";
                $sectionPageUrl = "#SITE_DIR#/about/jobs/";
                $detailPageUrl = "#SITE_DIR#/about/jobs/";
                break;
            
            case "staff_company":
                $listPageUrl = "#SITE_DIR#/about/management/";
                $sectionPageUrl = "#SITE_DIR#/about/management/";
                $detailPageUrl = "#SITE_DIR#/about/management/#ELEMENT_ID#/";
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

COption::SetOptionString("sporina.easysite", "wizard_installed", "Y", false, WIZARD_SITE_ID);

return true;
?>
