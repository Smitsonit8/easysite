<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

if (!$arResult["SHOW_BUTTON"] || $arResult["BUTTON_ACTION"] !== "form")
{
	return;
}

$this->addExternalCss(SITE_TEMPLATE_PATH . "/components/sporina/banner/form-modal.css");
$this->addExternalJs(SITE_TEMPLATE_PATH . "/components/sporina/banner/form-modal.js");
?>
<div id="<?=$formModalId?>" class="sporina-banner-form-modal" data-banner-form-modal hidden role="dialog" aria-modal="true" aria-label="<?=htmlspecialcharsbx($arResult["BUTTON_TEXT"])?>">
	<div class="sporina-banner-form-modal__backdrop" data-banner-form-close></div>
	<div class="sporina-banner-form-modal__content" role="document">
		<button class="sporina-banner-form-modal__close" type="button" data-banner-form-close aria-label="Закрыть">
            <svg viewBox="0 -0.5 25 25" fill="" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z" fill="#000000"></path>
            </svg>
        </button>
		<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "sporina-form-feedback", array("WEB_FORM_ID" => $arResult["FORM_ID"], "CACHE_TYPE" => "N", "CACHE_TIME" => "3600", "IGNORE_CUSTOM_TEMPLATE" => "N", "PERSONAL_DATA_URL" => trim((string)($arResult["FORM_PERSONAL_DATA_URL"] ?? "")), "USE_EXTENDED_ERRORS" => "N"));?>
	</div>
</div>
