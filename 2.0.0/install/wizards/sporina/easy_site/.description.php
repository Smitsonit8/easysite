<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Описание мастера установки сайта sporina.easysite

if(!defined("WIZARD_DEFAULT_SITE_ID") && !empty($_REQUEST["wizardSiteID"]))
	define("WIZARD_DEFAULT_SITE_ID", $_REQUEST["wizardSiteID"]);

$arWizardDescription = array(
    "NAME" => GetMessage("SPORINA_EASY_SITE_PORTAL_WIZARD_NAME"),
    "DESCRIPTION" => GetMessage("SPORINA_EASY_SITE_PORTAL_WIZARD_DESC"),
    "VERSION" => "1.0.0",
    "START_TYPE" => "WINDOW",
    "WIZARD_TYPE" => "INSTALL",
    "IMAGE" => "/images/".LANGUAGE_ID."/solution.png",
    "PARENT" => "wizard_sol",
    "TEMPLATES" => array(
        array("SCRIPT" => "wizard_sol")
    ),
    "STEPS" => array(
        "SelectSiteStep",
        "SelectTemplateStep",
        "SelectThemeStep",
        "SiteSettingsStep",
        "DataInstallStep",
        "FinishStep"
    )
);

if (defined("ADDITIONAL_INSTALL"))
{
	$arWizardDescription["STEPS"] = array(
		"SelectTemplateStep",
		"SelectThemeStep",
		"SiteSettingsStep",
		"DataInstallStep",
		"FinishStep"
	);
}
elseif (defined("WIZARD_DEFAULT_SITE_ID"))
{
	$arWizardDescription["STEPS"] = array(
		"SelectTemplateStep",
		"SelectThemeStep",
		"SiteSettingsStep",
		"DataInstallStep",
		"FinishStep"
	);
}

if(!defined("WIZARD_DEFAULT_TEMPLATES_PATH"))
	define("WIZARD_DEFAULT_TEMPLATES_PATH", "/bitrix/templates/");
?>