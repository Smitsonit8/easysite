<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

if (!defined("WIZARD_SITE_ID") || !defined("WIZARD_SITE_DIR"))
{
	return;
}

function ___writeToAreasFile($path, $text)
{
	$fd = @fopen($path, "wb");
	if (!$fd)
	{
		return false;
	}

	if (false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if (defined("BX_FILE_PERMISSIONS"))
	{
		@chmod($path, BX_FILE_PERMISSIONS);
	}

	return true;
}

// Получаем объект мастера
$wizard = $this->GetWizard();

// Флаг установки мастера и демо-данных
$wizardInstalled = COption::GetOptionString("sporina.easysite", "wizard_installed", "N", WIZARD_SITE_ID);
$installDemoData = (defined("WIZARD_INSTALL_DEMO_DATA") && WIZARD_INSTALL_DEMO_DATA);
$filesNotExist = !file_exists(WIZARD_SITE_PATH . "index.php");

// 1. Копирование публичной части из /site/public/ru/ на сайт 
// Копируем, если мастер ещё не устанавливался для этого сайта,
// либо явно выбрана установка демо-данных, либо на сайте ещё нет index.php.
if (
	$wizardInstalled === "N"
	|| $installDemoData
	|| $filesNotExist
)
{
	$sourcePath = WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/";
	if (file_exists($sourcePath))
	{
		CopyDirFiles(
			$sourcePath,
			WIZARD_SITE_PATH,
			$rewrite = true,
			$recursive = true,
			$delete_after_copy = false
		);

		// Отмечаем, что шаблон уже сконвертирован для этого сайта
		COption::SetOptionString("sporina.easysite", "template_converted", "Y", "", WIZARD_SITE_ID);

		// Первый запуск мастера для этого сайта
		if ($wizardInstalled === "N")
		{
			COption::SetOptionString("sporina.easysite", "wizard_installed", "Y", false, WIZARD_SITE_ID);
		}
	}
}
// 2. Ветка "конвертации", если нужно доразвернуть публичную часть
elseif (COption::GetOptionString("sporina.easysite", "template_converted", "N", WIZARD_SITE_ID) === "N")
{
	$convertPath = WIZARD_ABSOLUTE_PATH . "/site/services/main/" . LANGUAGE_ID . "/public_convert/";
	if (file_exists($convertPath))
	{
		CopyDirFiles(
			$convertPath,
			WIZARD_SITE_PATH,
			$rewrite = true,
			$recursive = true,
			$delete_after_copy = false
		);
	}
	COption::SetOptionString("sporina.easysite", "template_converted", "Y", "", WIZARD_SITE_ID);
}

// 3. Сохраняем основные текстовые настройки сайта в include-файлы
$includeDir = WIZARD_SITE_PATH . "include/";
if (!file_exists($includeDir))
{
	CheckDirPath($includeDir);
}

$siteName = $wizard->GetVar("siteName");
$siteCopy = $wizard->GetVar("siteCopy");
$siteTelephone = $wizard->GetVar("siteTelephone");

if ($siteName)
{
	___writeToAreasFile(WIZARD_SITE_PATH . "include/company_name.php", $siteName);
}
if ($siteCopy)
{
	___writeToAreasFile(WIZARD_SITE_PATH . "include/copyright.php", $siteCopy);
}
if ($siteTelephone)
{
	___writeToAreasFile(WIZARD_SITE_PATH . "include/telephone.php", $siteTelephone);
}

if (COption::GetOptionString("sporina.easysite", "wizard_installed", "N", WIZARD_SITE_ID) === "Y" && !$installDemoData)
{
	return;
}

$arDirs = array("about", "contacts", "include", "novosti-kompanii", "izmeneniya-v-raspisanii", "uslugi", "tovary", "poisk");
foreach ($arDirs as $dir)
{
	if (file_exists(WIZARD_SITE_PATH . $dir . "/"))
	{
		WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . $dir . "/", array("SITE_DIR" => WIZARD_SITE_DIR));
	}
}

// 5. Замена макросов в главной странице
// Сначала в "_index.php" — далее базовый мастер вызовет CreateNewIndex()
// и на его основе создаст / перезапишет index.php в корне сайта.
if (file_exists(WIZARD_SITE_PATH . "_index.php"))
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", array("SITE_DIR" => WIZARD_SITE_DIR));
}

// Дополнительная подстраховка: если уже есть index.php — меняем макросы и в нём
if (file_exists(WIZARD_SITE_PATH . "index.php"))
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "index.php", array("SITE_DIR" => WIZARD_SITE_DIR));
}

if (file_exists(WIZARD_SITE_PATH . ".top.menu.php"))
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . ".top.menu.php", array("SITE_DIR" => WIZARD_SITE_DIR));
}

if (file_exists(WIZARD_SITE_PATH . "/.section.php"))
{
	$siteMetaDescription = $wizard->GetVar("siteMetaDescription");
	$siteMetaKeywords = $wizard->GetVar("siteMetaKeywords");
	if ($siteMetaDescription)
	{
		CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/.section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($siteMetaDescription)));
	}
	if ($siteMetaKeywords)
	{
		CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/.section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($siteMetaKeywords)));
	}
}

// 6. Настройка ЧПУ (urlrewrite.php) с учетом каталога сайта (WIZARD_SITE_DIR).
// Нужно для корректной работы SEF_MODE у компонентов (detail страницы вида /novosti-kompanii/some-slug/ и т.п.)
$arUrlRewrite = array();
if (file_exists(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php"))
{
	include(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php");
}

$arNewUrlRewrite = array(
	array(
		"CONDITION" => "#^" . WIZARD_SITE_DIR . "novosti-kompanii/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR . "novosti-kompanii/index.php",
	),
	array(
		"CONDITION" => "#^" . WIZARD_SITE_DIR . "izmeneniya-v-raspisanii/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR . "izmeneniya-v-raspisanii/index.php",
	),
	array(
		"CONDITION" => "#^" . WIZARD_SITE_DIR . "uslugi/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR . "uslugi/index.php",
	),
	array(
		"CONDITION" => "#^" . WIZARD_SITE_DIR . "tovary/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR . "tovary/index.php",
	),
);

foreach ($arNewUrlRewrite as $arUrl)
{
	if (!in_array($arUrl, $arUrlRewrite, true))
	{
		CUrlRewriter::Add($arUrl);
	}
}
?>
