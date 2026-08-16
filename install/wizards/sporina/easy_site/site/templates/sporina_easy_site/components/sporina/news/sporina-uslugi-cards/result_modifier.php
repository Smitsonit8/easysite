<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}
/** @var array $arParams */
$arParams['USE_SHARE'] = (string)($arParams['USE_SHARE'] ?? 'N');
$arParams['USE_SHARE'] = $arParams['USE_SHARE'] === 'Y' ? 'Y' : 'N';
$arParams['SHARE_HIDE'] = (string)($arParams['SHARE_HIDE'] ?? 'N');
$arParams['SHARE_HIDE'] = $arParams['SHARE_HIDE'] === 'Y' ? 'Y' : 'N';
$arParams['SHARE_TEMPLATE'] = trim((string)($arParams['SHARE_TEMPLATE'] ?? '')) ?: 'sporina-social-share';
$arParams['SHARE_MAX'] = ($arParams['SHARE_MAX'] ?? 'Y') === 'N' ? 'N' : 'Y';
$arParams['SHARE_VK'] = ($arParams['SHARE_VK'] ?? 'Y') === 'N' ? 'N' : 'Y';
$arParams['SHARE_OK'] = ($arParams['SHARE_OK'] ?? 'Y') === 'N' ? 'N' : 'Y';
$arParams['SHARE_MAIL'] = ($arParams['SHARE_MAIL'] ?? 'Y') === 'N' ? 'N' : 'Y';
$arParams['SHARE_HANDLERS'] ??= [];
$arParams['SHARE_HANDLERS'] = is_array($arParams['SHARE_HANDLERS']) ? $arParams['SHARE_HANDLERS'] : [];
$arParams['SHARE_SHORTEN_URL_LOGIN'] = (string)($arParams['SHARE_SHORTEN_URL_LOGIN'] ?? 'N');
$arParams['SHARE_SHORTEN_URL_KEY'] = (string)($arParams['SHARE_SHORTEN_URL_KEY'] ?? 'N');
