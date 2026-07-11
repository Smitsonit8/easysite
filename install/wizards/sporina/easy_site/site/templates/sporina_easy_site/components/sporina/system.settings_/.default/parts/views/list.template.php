<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$key = $property['key'];
$current = (string)($arResult['SETTINGS'][$key] ?? '');
?>
<div class="system-settings-template-list">
    <?php foreach ($property['values'] as $option) { ?>
        <label class="system-settings-template-option">
            <input type="radio" name="settings[<?=htmlspecialcharsbx($key)?>]" value="<?=htmlspecialcharsbx($option['value'])?>"<?=$current === $option['value'] ? ' checked' : ''?>>
            <span class="system-settings-template-card">
                <img src="<?=htmlspecialcharsbx($option['image'])?>" alt="" loading="lazy">
                <span><?=htmlspecialcharsbx($option['name'])?></span>
            </span>
        </label>
    <?php } ?>
</div>
