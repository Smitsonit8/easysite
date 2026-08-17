<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

// Создание сайта в системе
// Этот файл будет выполнен при установке мастера

// НЕ устанавливаем флаг wizard_installed здесь, он будет установлен после копирования файлов
// Устанавливаем только флаг установки демо-данных для использования в других сервисах
$wizard =& $this->GetWizard();
$installDemoData = $wizard->GetVar("installDemoData");
if ($installDemoData == "Y")
{
	COption::SetOptionString("sporina.easysite", "install_demo_data", "Y", false, WIZARD_SITE_ID);
	if (!defined("WIZARD_INSTALL_DEMO_DATA"))
		define("WIZARD_INSTALL_DEMO_DATA", true);
}
else
{
	COption::SetOptionString("sporina.easysite", "install_demo_data", "N", false, WIZARD_SITE_ID);
	if (!defined("WIZARD_INSTALL_DEMO_DATA"))
		define("WIZARD_INSTALL_DEMO_DATA", false);
}

// Устанавливаем флаг использования шаблона сайта
COption::SetOptionString("sporina.easysite", "use_site_template", "Y", false, WIZARD_SITE_ID);

// Баннер на главной странице должен быть ВКЛЮЧЁН после установки (а также переустановки)
// мастера. Раньше запись выполнялась только при wizard_installed !== "Y", из-за чего при
// повторной установке старое значение 'N' (оставшееся от прошлой установки либо сохранённое
// через панель настроек system.settings) не перезаписывалось, и баннер оставался выключенным.
// Запись делаем безусловной, чтобы гарантировать корректное значение после каждого запуска мастера.
COption::SetOptionString("sporina.easysite", "pages-main-banner-use", "Y", false, WIZARD_SITE_ID);
?>
