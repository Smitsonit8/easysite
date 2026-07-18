<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$getValue = static function ($key) use ($arParams)
{
	return trim((string)($arParams[$key] ?? ""));
};

$buildContact = static function ($title, $label, $type = "")
{
	$href = "";

	if ($type === "phone")
	{
		$href = "tel:" . preg_replace("/[^0-9+]/", "", $title);
	}
	elseif ($type === "email")
	{
		$href = "mailto:" . $title;
	}

	return array(
		"TITLE" => $title,
		"LABEL" => $label,
		"HREF" => $href,
		"SHOW" => $title !== "" || $label !== "",
	);
};

$phone1 = $buildContact($getValue("PHONE_1_VALUE"), $getValue("PHONE_1_LABEL"), "phone");
$phone2 = $buildContact($getValue("PHONE_2_VALUE"), $getValue("PHONE_2_LABEL"), "phone");
$email = $buildContact($getValue("EMAIL_VALUE"), $getValue("EMAIL_LABEL"), "email");
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
	"SOCIAL" => array(
		"SHOW" => $getValue("SOCIAL_SHOW") === "Y",
		"VK" => $getValue("SOCIAL_VK"), "MAX" => $getValue("SOCIAL_MAX"), "OK" => $getValue("SOCIAL_OK"),
		"RUTUBE" => $getValue("SOCIAL_RUTUBE"), "DZEN" => $getValue("SOCIAL_DZEN"),
	),
);

$this->IncludeComponentTemplate();
