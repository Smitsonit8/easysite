<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$arParams["ENABLE_PERSONAL_DATA_CONSENT"] = "Y";
require dirname(__DIR__) . "/sporina-form-order/template.php";
