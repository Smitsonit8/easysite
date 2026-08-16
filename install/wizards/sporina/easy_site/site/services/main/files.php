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
}

// 3. Сохраняем основные текстовые настройки сайта в include-файлы
$includeDir = WIZARD_SITE_PATH . "include/";
if (!file_exists($includeDir))
{
	CheckDirPath($includeDir);
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
// При повторном запуске мастера старые правила мастера удаляются и создаются заново с актуальным WIZARD_SITE_DIR.
// Не используем CUrlRewriter::Delete/DeleteByFilter, т.к. на некоторых инсталляциях Bitrix падает,
// если в существующем urlrewrite.php есть невалидные элементы.
$urlRewriteFile = WIZARD_SITE_ROOT_PATH . "/urlrewrite.php";
$arUrlRewrite = array();
if (file_exists($urlRewriteFile))
{
	include($urlRewriteFile);
}

if (!is_array($arUrlRewrite))
{
	$arUrlRewrite = array();
}

$wizardNewsPaths = array(
	WIZARD_SITE_DIR . "novosti-kompanii/index.php",
	WIZARD_SITE_DIR . "izmeneniya-v-raspisanii/index.php",
	WIZARD_SITE_DIR . "uslugi/index.php",
	WIZARD_SITE_DIR . "tovary/index.php",
);

$filteredUrlRewrite = array();
foreach ($arUrlRewrite as $rule)
{
	if (!is_array($rule))
	{
		continue;
	}

	$isWizardNewsRule = (
		array_key_exists("ID", $rule)
		&& $rule["ID"] === "bitrix:news"
		&& array_key_exists("PATH", $rule)
		&& in_array($rule["PATH"], $wizardNewsPaths, true)
	);

	if ($isWizardNewsRule)
	{
		continue;
	}

	$filteredUrlRewrite[] = $rule;
}

$arNewUrlRewrite = array(
	// Детальные страницы novosti-kompanii (SORT=90 — приоритет выше)
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "novosti-kompanii/([^/]+?)/\\??(.*)#",
		'RULE' => 'ELEMENT_CODE=$1&$2',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "novosti-kompanii/index.php",
		'SORT' => 90,
	),
	// Список novosti-kompanii (SORT=100 — ниже)
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "novosti-kompanii/\\??(.*)#",
		'RULE' => '&$1',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "novosti-kompanii/index.php",
		'SORT' => 100,
	),
	// Детальные страницы izmeneniya-v-raspisanii
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "izmeneniya-v-raspisanii/([^/]+?)/\\??(.*)#",
		'RULE' => 'ELEMENT_CODE=$1&$2',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "izmeneniya-v-raspisanii/index.php",
		'SORT' => 90,
	),
	// Список izmeneniya-v-raspisanii
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "izmeneniya-v-raspisanii/\\??(.*)#",
		'RULE' => '&$1',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "izmeneniya-v-raspisanii/index.php",
		'SORT' => 100,
	),
	// Детальные страницы uslugi
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "uslugi/([^/]+?)/\\??(.*)#",
		'RULE' => 'ELEMENT_CODE=$1&$2',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "uslugi/index.php",
		'SORT' => 90,
	),
	// Список uslugi
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "uslugi/\\??(.*)#",
		'RULE' => '&$1',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "uslugi/index.php",
		'SORT' => 100,
	),
	// Детальные страницы tovary
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "tovary/([^/]+?)/\\??(.*)#",
		'RULE' => 'ELEMENT_CODE=$1&$2',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "tovary/index.php",
		'SORT' => 90,
	),
	// Список tovary
	array(
		'CONDITION' => "#^" . WIZARD_SITE_DIR . "tovary/\\??(.*)#",
		'RULE' => '&$1',
		'ID' => "bitrix:news",
		'PATH' => WIZARD_SITE_DIR . "tovary/index.php",
		'SORT' => 100,
	),
);

foreach ($arNewUrlRewrite as $arUrl)
{
	$filteredUrlRewrite[] = $arUrl;
}

usort($filteredUrlRewrite, static function ($left, $right) {
	$leftSort = isset($left["SORT"]) ? (int)$left["SORT"] : 100;
	$rightSort = isset($right["SORT"]) ? (int)$right["SORT"] : 100;

	if ($leftSort === $rightSort)
	{
		return 0;
	}

	return ($leftSort < $rightSort) ? -1 : 1;
});

$urlRewriteContents = "<?php\n";
$urlRewriteContents .= '$arUrlRewrite = ' . var_export(array_values($filteredUrlRewrite), true) . ";\n";
$urlRewriteContents .= "?>";

___writeToAreasFile($urlRewriteFile, $urlRewriteContents);
?>
