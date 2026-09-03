<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$versions = array('sporina_easy_site' => 'v1', 'sporina_easy_site_v2' => 'v2');
$version = isset($versions[WIZARD_TEMPLATE_ID]) ? $versions[WIZARD_TEMPLATE_ID] : 'v1';

require __DIR__ . '/' . $version . '/types.php';
