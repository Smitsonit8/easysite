<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

CModule::IncludeModule('fileman');
$arMenuTypes = GetMenuTypes(WIZARD_SITE_ID);

// Устанавливаем типы меню для сайта
SetMenuTypes($arMenuTypes, WIZARD_SITE_ID);
COption::SetOptionInt("fileman", "num_menu_param", 2, false ,WIZARD_SITE_ID);

// Создаем файл меню, если его нет
$menuFile = WIZARD_SITE_PATH . ".top.menu.php";
if (!file_exists($menuFile))
{
	$menuContent = "<?php\n";
	$menuContent .= "\$aMenuLinks = Array(\n";
	$menuContent .= "\tArray(\n";
	$menuContent .= "\t\t\"Главная\",\n";
	$menuContent .= "\t\t\"#SITE_DIR#\",\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\t\"\"\n";
	$menuContent .= "\t),\n";
	$menuContent .= "\tArray(\n";
	$menuContent .= "\t\t\"О компании\",\n";
	$menuContent .= "\t\t\"#SITE_DIR#about/\",\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\t\"\"\n";
	$menuContent .= "\t),\n";
	$menuContent .= "\tArray(\n";
	$menuContent .= "\t\t\"Новости\",\n";
	$menuContent .= "\t\t\"#SITE_DIR#novosti-kompanii/\",\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\t\"\"\n";
	$menuContent .= "\t),\n";
	$menuContent .= "\tArray(\n";
	$menuContent .= "\t\t\"Услуги\",\n";
	$menuContent .= "\t\t\"#SITE_DIR#uslugi/\",\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\t\"\"\n";
	$menuContent .= "\t),\n";
	$menuContent .= "\tArray(\n";
	$menuContent .= "\t\t\"Контакты\",\n";
	$menuContent .= "\t\t\"#SITE_DIR#contacts/\",\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\tArray(),\n";
	$menuContent .= "\t\t\"\"\n";
	$menuContent .= "\t),\n";
	$menuContent .= ");\n";
	$menuContent .= "?>";
	
	$fd = @fopen($menuFile, "wb");
	if($fd)
	{
		fwrite($fd, $menuContent);
		fclose($fd);
		
		if(defined("BX_FILE_PERMISSIONS"))
			@chmod($menuFile, BX_FILE_PERMISSIONS);
	}
}

?>
