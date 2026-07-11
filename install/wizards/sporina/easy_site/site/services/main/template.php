<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/** @var \CDataInstallWizardStep $wizard */

if (!defined("WIZARD_TEMPLATE_ID"))
	return;

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID;

CopyDirFiles(
	$_SERVER["DOCUMENT_ROOT"].WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH."/site")."/".WIZARD_TEMPLATE_ID,
	$bitrixTemplateDir,
	$rewrite = true,
	$recursive = true,
	$delete_after_copy = false
);
foreach (["banner", "contacts", "footer", "header"] as $componentName)
{
	CopyDirFiles(
		$bitrixTemplateDir."/components/sporina/".$componentName,
		$_SERVER["DOCUMENT_ROOT"]."/bitrix/components/sporina/".$componentName,
		$rewrite = true,
		$recursive = true,
		$delete_after_copy = false
	);
}
//Attach template to default site
$obSite = CSite::GetList('def', 'desc', Array("LID" => WIZARD_SITE_ID));
if ($arSite = $obSite->Fetch())
{
	$arTemplates = Array();
	$found = false;
	$foundEmpty = false;
	$obTemplate = CSite::GetTemplateList($arSite["LID"]);
	while($arTemplate = $obTemplate->Fetch())
	{
		if(!$found && trim($arTemplate["CONDITION"]) == '')
		{
			$arTemplate["TEMPLATE"] = WIZARD_TEMPLATE_ID;
			$found = true;
		}
		if($arTemplate["TEMPLATE"] == "empty")
		{
			$foundEmpty = true;
			continue;
		}
		$arTemplates[]= $arTemplate;
	}

	if (!$found)
		$arTemplates[]= Array("CONDITION" => "", "SORT" => 150, "TEMPLATE" => WIZARD_TEMPLATE_ID);

	$arFields = Array(
		"TEMPLATE" => $arTemplates,
		"NAME" => $arSite["NAME"],
	);

	$obSite = new CSite();
	$obSite->Update($arSite["LID"], $arFields);
}

$wizrdTemplateId = $wizard->GetVar("wizTemplateID");
if (!in_array($wizrdTemplateId, array("sporina_easy_site")))
	$wizrdTemplateId = "sporina_easy_site";
COption::SetOptionString("main", "wizard_template_id", $wizrdTemplateId, false, WIZARD_SITE_ID);

// Сохраняем настройки сайта в файлы
function ___writeToAreasFile($fn, $text)
{
	$fd = @fopen($fn, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);

	return true;
}

// Сохраняем название сайта
$siteName = $wizard->GetVar("siteName");
if ($siteName)
{
	___writeToAreasFile(WIZARD_SITE_PATH."include/company_name.php", $siteName);
}

// Сохраняем телефон
$siteTelephone = $wizard->GetVar("siteTelephone");
if ($siteTelephone)
{
	___writeToAreasFile(WIZARD_SITE_PATH."include/telephone.php", $siteTelephone);
}

// Сохраняем копирайт
$siteCopy = $wizard->GetVar("siteCopy");
if ($siteCopy)
{
	___writeToAreasFile(WIZARD_SITE_PATH."include/copyright.php", $siteCopy);
}

// Сохраняем метаданные
$siteMetaDescription = $wizard->GetVar("siteMetaDescription");
if ($siteMetaDescription)
{
	COption::SetOptionString("main", "meta_description", $siteMetaDescription, false, WIZARD_SITE_ID);
}

$siteMetaKeywords = $wizard->GetVar("siteMetaKeywords");
if ($siteMetaKeywords)
{
	COption::SetOptionString("main", "meta_keywords", $siteMetaKeywords, false, WIZARD_SITE_ID);
}
?>
