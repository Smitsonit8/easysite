<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if (!defined("WIZARD_TEMPLATE_ID"))
	return;

$templateDir = BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID;

// Копируем файлы темы в директорию шаблона
CopyDirFiles(
	WIZARD_THEME_ABSOLUTE_PATH,
	$_SERVER["DOCUMENT_ROOT"].$templateDir,
	$rewrite = true, 
	$recursive = true,
	$delete_after_copy = false,
	$exclude = "description.php"
);

// Сохраняем выбранную тему в настройках сайта
COption::SetOptionString("main", "wizard_sporina_easy_site_theme_id", WIZARD_THEME_ID, "", WIZARD_SITE_ID);
COption::SetOptionString("sporina.easysite", "template-color-theme", WIZARD_THEME_ID, "", WIZARD_SITE_ID);

// Устанавливаем цветовую схему для main.interface.grid/form
CUserOptions::SetOption("main.interface", "global", array("theme" => WIZARD_THEME_ID), true);
?>
