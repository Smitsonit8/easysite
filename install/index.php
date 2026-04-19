<?php

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

Class sporina_easysite extends CModule
{
	var $MODULE_ID = "sporina.easysite";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function __construct()
	{
		$arModuleVersion = array();

		include(__DIR__.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = Loc::getMessage("SPORINA_EASY_SITE_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("SPORINA_EASY_SITE_MODULE_DESCRIPTION");
		$this->PARTNER_NAME = Loc::getMessage("SPORINA_EASY_SITE_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("SPORINA_EASY_SITE_PARTNER_URI");
	}

	function InstallDB($install_wizard = true)
	{
		RegisterModule("sporina.easysite");
		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		UnRegisterModule("sporina.easysite");
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
		// Копируем шаблон сайта в /bitrix/templates/
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/wizards/bitrix/easy_site/site/templates/sporina_easy_site",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/sporina_easy_site",
			true,
			true
		);

		// Копируем файлы в /bitrix/php_interface/
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/php_interface",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface",
			true,
			true
		);
		
		// Проверяем, существует ли init.php в целевой директории
		$targetInitFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/init.php";
		$sourceInitFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/php_interface/init.php";
		
		// Если init.php уже существует, добавляем строки перед закрывающим тегом
		if (file_exists($targetInitFile)) {
			// Проверяем, содержатся ли уже нужные строки в файле
			$content = file_get_contents($targetInitFile);
			$formHandlerLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/form_handler.php");';
			$constantsLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/constants.php");';
			
			// Добавляем строки, если их еще нет в файле
			$linesToAdd = [];
			if (strpos($content, $formHandlerLine) === false) {
				$linesToAdd[] = $formHandlerLine;
			}
			if (strpos($content, $constantsLine) === false) {
				$linesToAdd[] = $constantsLine;
			}
			
			// Если есть строки для добавления, вставляем их перед закрывающим тегом
			if (!empty($linesToAdd)) {
				// Находим позицию закрывающего тега
				$endPos = strrpos($content, '?>');
				
				if ($endPos !== false) {
					// Вставляем строки перед 
					$newContent = substr($content, 0, $endPos) . "\n" . implode("\n", $linesToAdd) . "\n" . substr($content, $endPos);
					file_put_contents($targetInitFile, $newContent);
				} else {
					// Если закрывающий не найден, добавляем строки в конец файла
					file_put_contents($targetInitFile, "\n" . implode("\n", $linesToAdd) . "\n", FILE_APPEND);
				}
			}
		}

		// Копируем wizards
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/wizards",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards",
			true,
			true
		);

		return true;
	}

	function UnInstallFiles()
	{

		// Удаляем типы инфоблоков
		if (CModule::IncludeModule("iblock"))
		{
			$arIBlockTypes = array(
				"advertising_bannerss",
				"cards_info",
				"news_and_changes",
				"services",
				"products"
			);

			foreach ($arIBlockTypes as $typeID)
			{
				$obBlocktype = new CIBlockType;
				$obBlocktype->Delete($typeID);
			}
		}

		// Удаляем веб-формы
     	$this->UnInstallForms();

		// Удаляем шаблон сайта из /bitrix/templates/
		DeleteDirFilesEx("/bitrix/templates/sporina_easy_site");

		// Удаляем файлы из /bitrix/php_interface/
		// Удаляем только те файлы, которые были установлены модулем
		// В данном случае это form_handler.php и constants.php
		
		// Удаляем только строки из init.php, а не весь файл
		$initFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/init.php";
		if (file_exists($initFile)) {
			$content = file_get_contents($initFile);
			$formHandlerLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/form_handler.php");';
			$constantsLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/constants.php");';
			
			// Удаляем строки из файла
			$content = str_replace($formHandlerLine . "\n", "", $content);
			$content = str_replace($constantsLine . "\n", "", $content);
			$content = str_replace("\n" . $formHandlerLine, "", $content);
			$content = str_replace("\n" . $constantsLine, "", $content);
			$content = str_replace($formHandlerLine, "", $content);
			$content = str_replace($constantsLine, "", $content);
			
			file_put_contents($initFile, $content);
		}

		$formHandlerFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/form_handler.php";
		if (file_exists($formHandlerFile))
		{
			@unlink($formHandlerFile);
		}

		$constantsFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/constants.php";
		if (file_exists($constantsFile))
		{
			@unlink($constantsFile);
		}

		// Удаляем wizards
		DeleteDirFilesEx("/bitrix/wizards/sporina/easy_site");

		return true;
	}

	function UnInstallForms()
	{
		// Подключаем модуль веб-форм
		if (!CModule::IncludeModule("form")) {
			return false;
		}
		
		// Удаляем форму "Заказать" по SID
		$dbForm = CForm::GetList($by="", $order="", array("SID" => "ORDER_FORM"), $is_filtered=false);
		while ($arForm = $dbForm->Fetch()) {
			CForm::Delete($arForm["ID"]);
		}
		
		// Удаляем форму "Купить" по SID
		$dbForm = CForm::GetList($by="", $order="", array("SID" => "BUY_FORM"), $is_filtered=false);
		while ($arForm = $dbForm->Fetch()) {
			CForm::Delete($arForm["ID"]);
		}
		
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;

		$this->InstallDB();
		$this->InstallEvents();
		$this->InstallFiles();
		$APPLICATION->IncludeAdminFile(GetMessage("SPORINA_MODULE_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/step.php");
		return true;
	}

	function DoUninstall()
	{
		global $APPLICATION;

		$this->UnInstallDB();
		$this->UnInstallEvents();
		$this->UnInstallFiles();

		return true;
	}

}

?>