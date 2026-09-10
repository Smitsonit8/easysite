<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$contactValues = array();
if (CModule::IncludeModule("iblock"))
{
	$iblockResult = CIBlock::GetList(array(), array(
		"TYPE" => "easy_infocompany",
		"CODE" => "company_contacts",
		"ACTIVE" => "Y",
	));
	if ($iblock = $iblockResult->Fetch())
	{
		$elementResult = CIBlockElement::GetList(array(), array(
			"IBLOCK_ID" => $iblock["ID"],
			"ACTIVE" => "Y",
			"CODE" => "company_contacts",
		), false, array("nTopCount" => 1), array("ID", "IBLOCK_ID"));
		if ($element = $elementResult->GetNextElement())
		{
			foreach ($element->GetProperties() as $propertyCode => $property)
			{
				$contactValues[$propertyCode] = trim((string)($property["VALUE"] ?? ""));
			}
		}
	}
}

$propertyMap = array(
	"PHONE_1_VALUE" => "PHONE_1",
	"PHONE_1_LABEL" => "PHONE_1_LABEL",
	"PHONE_2_VALUE" => "PHONE_2",
	"PHONE_2_LABEL" => "PHONE_2_LABEL",
	"EMAIL_VALUE" => "EMAIL",
	"EMAIL_LABEL" => "EMAIL_LABEL",
	"ADDRESS_VALUE" => "ACTUAL_ADDRESS",
	"ADDRESS_LABEL" => "ACTUAL_ADDRESS_LABEL",
	"COPYRIGHT_PRIMARY" => "COPYRIGHT_PRIMARY",
	"SOCIAL_VK" => "SOCIAL_VK",
	"SOCIAL_MAX" => "SOCIAL_MAX",
	"SOCIAL_OK" => "SOCIAL_OK",
	"SOCIAL_RUTUBE" => "SOCIAL_RUTUBE",
	"SOCIAL_DZEN" => "SOCIAL_DZEN",
);

$iblockOnlyKeys = array("PHONE_1_VALUE", "PHONE_1_LABEL", "PHONE_2_VALUE", "PHONE_2_LABEL", "EMAIL_VALUE", "EMAIL_LABEL", "ADDRESS_VALUE", "ADDRESS_LABEL", "COPYRIGHT_PRIMARY");
$getValue = static function ($key) use ($arParams, $contactValues, $propertyMap, $iblockOnlyKeys)
{
	$selectedPropertyCode = trim((string)($arParams["IBLOCK_PROPERTY_" . $key] ?? ""));
	$propertyCode = $selectedPropertyCode !== "" ? $selectedPropertyCode : ($propertyMap[$key] ?? "");
	if ($propertyCode !== "" && ($contactValues[$propertyCode] ?? "") !== "")
	{
		return $contactValues[$propertyCode];
	}
	if (in_array($key, $iblockOnlyKeys, true))
	{
		return "";
	}

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
		"SHOW" => $getValue("SOCIAL_SHOW") === "Y" || $getValue("SOCIAL_VK") !== "" || $getValue("SOCIAL_MAX") !== "" || $getValue("SOCIAL_OK") !== "" || $getValue("SOCIAL_RUTUBE") !== "" || $getValue("SOCIAL_DZEN") !== "",
		"VK" => $getValue("SOCIAL_VK"), "MAX" => $getValue("SOCIAL_MAX"), "OK" => $getValue("SOCIAL_OK"),
		"RUTUBE" => $getValue("SOCIAL_RUTUBE"), "DZEN" => $getValue("SOCIAL_DZEN"),
	),
);

$this->IncludeComponentTemplate();
