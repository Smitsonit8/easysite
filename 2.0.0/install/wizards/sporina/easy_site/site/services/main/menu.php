<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

CModule::IncludeModule('fileman');
$arMenuTypes = GetMenuTypes(WIZARD_SITE_ID);
SetMenuTypes($arMenuTypes, WIZARD_SITE_ID);
COption::SetOptionInt("fileman", "num_menu_param", 2, false, WIZARD_SITE_ID);

$menuFile = WIZARD_SITE_PATH . ".top.menu.php";
if (!file_exists($menuFile))
{
	$aMenuLinks = array(
		array("Главная", "#SITE_DIR#", array(), array(), ""),
		array("Услуги", "#SITE_DIR#uslugi/", array(), array(), ""),
		array("Товары", "#SITE_DIR#tovary/", array(), array(), ""),
		array("Новости", "#SITE_DIR#novosti-kompanii/", array(), array(), ""),
		array("Статьи", "#SITE_DIR#izmeneniya-v-raspisanii/", array(), array(), ""),
		array("О компании", "#SITE_DIR#about/", array(), array(), ""),
		array("Контакты", "#SITE_DIR#contacts/", array(), array(), ""),
	);

	$menuContent = "<?php\n";
	$menuContent .= "\$aMenuLinks = " . var_export($aMenuLinks, true) . ";\n";

	if (@file_put_contents($menuFile, $menuContent) !== false && defined("BX_FILE_PERMISSIONS"))
	{
		@chmod($menuFile, BX_FILE_PERMISSIONS);
	}
}
?>
