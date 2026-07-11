<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$useKey = $property['use_key'];
$templateKey = $property['template_key'];
$enabled = ($arResult['SETTINGS'][$useKey] ?? 'N') === 'Y';
$current = (string)($arResult['SETTINGS'][$templateKey] ?? '');
?>
<div class="system-settings-block">
    <label class="system-settings-switch">
        <input type="hidden" name="settings[<?=htmlspecialcharsbx($useKey)?>]" value="N">
        <input type="checkbox" name="settings[<?=htmlspecialcharsbx($useKey)?>]" value="Y"<?=$enabled ? ' checked' : ''?>>
        <span class="system-settings-switch-control" aria-hidden="true"></span>
        <span><?=\Bitrix\Main\Localization\Loc::getMessage('SPORINA_SETTINGS_SHOW_BLOCK')?></span>
    </label>
    <div class="system-settings-template-list">
        <?php foreach ($property['values'] as $option) { ?>
            <label class="system-settings-template-option">
                <input type="radio" name="settings[<?=htmlspecialcharsbx($templateKey)?>]" value="<?=htmlspecialcharsbx($option['value'])?>"<?=$current === $option['value'] ? ' checked' : ''?>>
                <span class="system-settings-template-card">
                    <img src="<?=htmlspecialcharsbx($option['image'])?>" alt="" loading="lazy">
                    <span><?=htmlspecialcharsbx($option['name'])?></span>
                </span>
            </label>
        <?php } ?>
    </div>
</div>
