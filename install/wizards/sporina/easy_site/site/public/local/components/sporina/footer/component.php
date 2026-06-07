<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$getValue = static function ($key) use ($arParams)
{
	return trim((string)($arParams[$key] ?? ""));
};

$buildContact = static function ($title, $label)
{
	return array(
		"TITLE" => $title,
		"LABEL" => $label,
		"SHOW" => $title !== "" || $label !== "",
	);
};

$phone1 = $buildContact($getValue("PHONE_1_VALUE"), $getValue("PHONE_1_LABEL"));
$phone2 = $buildContact($getValue("PHONE_2_VALUE"), $getValue("PHONE_2_LABEL"));
$email = $buildContact($getValue("EMAIL_VALUE"), $getValue("EMAIL_LABEL"));
$address = $buildContact($getValue("ADDRESS_VALUE"), $getValue("ADDRESS_LABEL"));

$licenseText = $getValue("LICENSE_TEXT");
$licenseLink = $getValue("LICENSE_LINK");
$policyText = $getValue("POLICY_TEXT");
$policyLink = $getValue("POLICY_LINK");

$copyrightPrefix = $getValue("COPYRIGHT_SECONDARY_PREFIX");
$copyrightLinkText = $getValue("COPYRIGHT_SECONDARY_LINK_TEXT");
$copyrightLink = $getValue("COPYRIGHT_SECONDARY_LINK");
$copyrightSuffix = $getValue("COPYRIGHT_SECONDARY_SUFFIX");

$arResult = array(
	"PHONE_1" => $phone1,
	"PHONE_2" => $phone2,
	"EMAIL" => $email,
	"ADDRESS" => $address,
	"LICENSE" => array(
		"TEXT" => $licenseText,
		"LINK" => $licenseLink,
		"SHOW" => $licenseText !== "",
	),
	"POLICY" => array(
		"TEXT" => $policyText,
		"LINK" => $policyLink,
		"SHOW" => $policyText !== "",
	),
	"COPYRIGHT_PRIMARY" => $getValue("COPYRIGHT_PRIMARY"),
	"COPYRIGHT_SECONDARY" => array(
		"PREFIX" => $copyrightPrefix,
		"LINK_TEXT" => $copyrightLinkText,
		"LINK" => $copyrightLink,
		"SUFFIX" => $copyrightSuffix,
		"SHOW" => $copyrightPrefix !== "" || $copyrightLinkText !== "" || $copyrightSuffix !== "",
	),
	"TELEGRAM_LINK" => $getValue("TELEGRAM_LINK"),
	"GOOGLE_PLAY_LINK" => $getValue("GOOGLE_PLAY_LINK"),
	"APP_STORE_LINK" => $getValue("APP_STORE_LINK"),
);

$this->IncludeComponentTemplate();
