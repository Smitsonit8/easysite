<?
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
?>