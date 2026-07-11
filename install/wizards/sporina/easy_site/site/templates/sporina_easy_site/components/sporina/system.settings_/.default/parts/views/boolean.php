<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$key = $property['key'];
$checked = ($arResult['SETTINGS'][$key] ?? 'N') === 'Y';
?>
<label class="system-settings-switch">
    <input type="hidden" name="settings[<?=htmlspecialcharsbx($key)?>]" value="N">
    <input type="checkbox" name="settings[<?=htmlspecialcharsbx($key)?>]" value="Y"<?=$checked ? ' checked' : ''?>>
    <span class="system-settings-switch-control" aria-hidden="true"></span>
    <span><?=$checked ? \Bitrix\Main\Localization\Loc::getMessage('SPORINA_SETTINGS_ENABLED') : \Bitrix\Main\Localization\Loc::getMessage('SPORINA_SETTINGS_DISABLED')?></span>
</label>
