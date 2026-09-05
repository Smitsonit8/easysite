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
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/wizards/sporina/easy_site/site/templates/sporina_easy_site",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/sporina_easy_site",
			true,
			true
		);
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/components/sporina/system.settings",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/components/sporina/system.settings",
			true,
			true
		);
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/components/sporina/news",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/components/sporina/news",
			true,
			true
		);
		foreach (["banner", "contacts", "footer", "header"] as $componentName) {
			CopyDirFiles(
				$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/components/sporina/".$componentName,
				$_SERVER["DOCUMENT_ROOT"]."/bitrix/components/sporina/".$componentName,
				true,
				true
			);
		}

		// Копируем файлы в /bitrix/php_interface/.
		// НЕ копируем init.php целиком через CopyDirFiles — это безусловно перезаписывало бы
		// пользовательский init.php минимальным init.php модуля. Вместо этого копируем
		// form_handler.php и constants.php по отдельности, а init.php только дополняем
		// строками (идемпотентно) в блоке ниже.
		$phpInterfaceSrc = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/php_interface";
		$phpInterfaceDst = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface";

		CopyDirFiles(
			$phpInterfaceSrc."/form_handler.php",
			$phpInterfaceDst."/form_handler.php",
			true,
			true
		);
		CopyDirFiles(
			$phpInterfaceSrc."/constants.php",
			$phpInterfaceDst."/constants.php",
			true,
			true
		);

		// Проверяем, существует ли init.php в целевой директории.
		$targetInitFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/init.php";

		// Строки (require_once), которые должны быть подключены из init.php.
		$formHandlerLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/form_handler.php");';
		$constantsLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/constants.php");';

		// Маркерные комментарии, чтобы UnInstallFiles() мог удалить только наш блок,
		// не трогая чужой код в пользовательском init.php.
		$blockStartMarker = "// >>> sporina.easysite";
		$blockEndMarker = "// <<< sporina.easysite";
		$blockLines = "\n" . $blockStartMarker . "\n" . $formHandlerLine . "\n" . $constantsLine . "\n" . $blockEndMarker;

		// Идемпотентность: если файл уже содержит маркерный блок, ничего не делаем —
		// это гарантирует отсутствие дублирования и при частично изменённом содержимом.
		if (file_exists($targetInitFile)
			&& strpos(file_get_contents($targetInitFile), $blockStartMarker) !== false
		) {
			// Блок уже установлен — выходим из обработки.
		} else {
			// Формируем новый контент в зависимости от состояния файла.
			// init.php — PHP-файл; отсутствие закрывающего тега допустимо и даже
			// рекомендуется, поэтому НИКОГДА не дописываем строки «как есть» в файл без
			// открывающего тега: иначе require_once выведется как HTML и сломает вывод.
			$newContent = "";

			if (file_exists($targetInitFile)) {
				$content = file_get_contents($targetInitFile);
				if ($content === false) {
					\CEventLog::Add([
						"SEVERITY" => "ERROR",
						"AUDIT_TYPE_ID" => "SPORINA_INSTALL",
						"MODULE_ID" => "sporina.easysite",
						"DESCRIPTION" => "Не удалось прочитать /bitrix/php_interface/init.php",
					]);
					return false;
				}

				// Ищем последний закрывающий тег. PHP-файл может быть без,
				// тогда вставляем блок в самый конец, не нарушая синтаксис.
				$endPos = strrpos($content, '?' . '>');

				// Проверяем наличие открывающего PHP-тега. Тег может быть
				// в вариантах php/PHP/пробел/= и т.п., поэтому надёжно ищем
				// подстроку открывающего тега. Для заведомо пустого или
				// пробельного файла он отсутствует.
				$hasOpenTag = (strpos($content, '<' . '?') !== false);

				if ($endPos !== false) {
					// Файл содержит открывающий тег и закрывающий — вставляем блок
					// перед закрывающим тегом, сохраняя его в конце.
					$newContent = substr($content, 0, $endPos) . $blockLines . "\n" . substr($content, $endPos);
				} elseif ($hasOpenTag) {
					// Есть открывающий тег, но нет закрывающего — добавляем блок
					// в конец файла, оставаясь в PHP-контексте.
					$newContent = $content . $blockLines . "\n";
				} else {
					// Открывающего тега нет вовсе (в т.ч. пустой/пробельный файл) —
					// аккуратно открываем PHP-контекст и добавляем блок в конец.
					// Тег собираем конкатенацией, чтобы не разрывать PHP-токенизатор.
					$newContent = "<" . "?php\n" . $content . $blockLines . "\n";
				}
			} else {
				// Файл не существует — создаём с открывающим PHP-тегом и сразу с блоком.
				// Без открывающего тега require_once вывелся бы как текст и сломал вывод.
				// Собираем тег конкатенацией, чтобы он не разрывал PHP-токенизатор.
				$newContent = "<" . "?php" . $blockLines . "\n";
			}

			// Атомарная запись с блокировкой и контролем результата.
			if (file_put_contents($targetInitFile, $newContent, LOCK_EX) === false) {
				\CEventLog::Add([
					"SEVERITY" => "ERROR",
					"AUDIT_TYPE_ID" => "SPORINA_INSTALL",
					"MODULE_ID" => "sporina.easysite",
					"DESCRIPTION" => "Не удалось записать /bitrix/php_interface/init.php",
				]);
				return false;
			}
		}

		// Копируем wizards
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sporina.easysite/install/wizards/sporina/easy_site",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/sporina/easy_site",
			true,
			true
		);

		return true;
	}

	function UnInstallFiles()
	{
		$this->UnInstallPublicFiles();


		// Удаляем типы инфоблоков
		if (CModule::IncludeModule("iblock"))
		{
			$arIBlockTypes = array(
				"easy_promobanners",
				"easy_cardsinfo",
				"easy_news_articles",
				"easy_infocompany",
				"easy_services",
				"easy_products"
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
		DeleteDirFilesEx("/bitrix/components/sporina/system.settings");
		DeleteDirFilesEx("/bitrix/components/sporina/news");
		foreach (["banner", "contacts", "footer", "header"] as $componentName) {
			DeleteDirFilesEx("/bitrix/components/sporina/".$componentName);
		}

		// Удаляем файлы из /bitrix/php_interface/
		// Удаляем только те файлы, которые были установлены модулем
		// В данном случае это form_handler.php и constants.php
		
		// Удаляем только строки из init.php, а не весь файл.
		// Согласовано с InstallFiles(): удаляем весь блок, ограниченный маркерными
		// комментариями // >>> sporina.easysite и // <<< sporina.easysite, чтобы не
		// трогать чужой код пользовательского init.php.
		$initFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/init.php";
		if (file_exists($initFile)) {
			$content = file_get_contents($initFile);
			$blockStartMarker = "// >>> sporina.easysite";
			$blockEndMarker = "// <<< sporina.easysite";

			// Собираем блок целиком (маркеры и строки между ними) и удаляем его
			$blockPattern = preg_quote($blockStartMarker, '/') . '.*?' . preg_quote($blockEndMarker, '/');
			$content = preg_replace('/' . $blockPattern . '/s', '', $content);

			// Если маркерный блок не найден (старая установка без маркеров), точечно
			// удаляем строки require_once как раньше
			if (strpos($content, $blockStartMarker) === false && strpos($content, $blockEndMarker) === false) {
				$formHandlerLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/form_handler.php");';
				$constantsLine = 'require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/constants.php");';
				$content = str_replace($formHandlerLine . "\n", "", $content);
				$content = str_replace($constantsLine . "\n", "", $content);
				$content = str_replace("\n" . $formHandlerLine, "", $content);
				$content = str_replace("\n" . $constantsLine, "", $content);
				$content = str_replace($formHandlerLine, "", $content);
				$content = str_replace($constantsLine, "", $content);
			}

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

	function UnInstallPublicFiles()
	{
		$publicDirectories = array(
			"about",
			"auth",
			"contacts",
			"include",
			"izmeneniya-v-raspisanii",
			"novosti-kompanii",
			"poisk",
			"tovary",
			"uslugi",
		);
		$publicFiles = array(
			".access.php",
			".top.menu.php",
			"404.php",
			"favicon.ico",
			"index_inc.php",
			"_index.php",
			"index.php",
		);

		$siteResult = CSite::GetList("sort", "asc");
		while ($site = $siteResult->Fetch())
		{
			$siteId = $site["LID"];
			if (COption::GetOptionString($this->MODULE_ID, "wizard_installed", "N", $siteId) !== "Y")
			{
				continue;
			}

			$siteDir = trim(str_replace("\\", "/", (string)$site["DIR"]), "/");
			if (strpos($siteDir, "..") !== false)
			{
				continue;
			}
			$sitePath = "/" . ($siteDir !== "" ? $siteDir . "/" : "");

			foreach ($publicDirectories as $directory)
			{
				$relativePath = $sitePath . $directory;
				if (is_dir($_SERVER["DOCUMENT_ROOT"] . $relativePath))
				{
					DeleteDirFilesEx($relativePath);
				}
			}

			foreach ($publicFiles as $file)
			{
				$absolutePath = $_SERVER["DOCUMENT_ROOT"] . $sitePath . $file;
				if (is_file($absolutePath))
				{
					@unlink($absolutePath);
				}
			}

			COption::RemoveOption($this->MODULE_ID, "wizard_installed", $siteId);
			COption::RemoveOption($this->MODULE_ID, "template_converted", $siteId);
			COption::RemoveOption($this->MODULE_ID, "install_demo_data", $siteId);
			COption::RemoveOption($this->MODULE_ID, "use_site_template", $siteId);
		}
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

		// Удаляем форму "Обратная связь" по SID
		$dbForm = CForm::GetList($by="", $order="", array("SID" => "FEEDBACK_FORM"), $is_filtered=false);
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

		$this->UnInstallFiles();
		$this->UnInstallEvents();
		$this->UnInstallDB();

		return true;
	}

}

?>
