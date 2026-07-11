<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$key = $property['key'];
$current = (string)($arResult['SETTINGS'][$key] ?? '');
?>
<div class="system-settings-options">
    <?php foreach ($property['values'] as $option) { ?>
        <label class="system-settings-option">
            <input type="radio" name="settings[<?=htmlspecialcharsbx($key)?>]" value="<?=htmlspecialcharsbx($option['value'])?>"<?=$current === $option['value'] ? ' checked' : ''?>>
            <span><?=htmlspecialcharsbx($option['name'])?></span>
        </label>
    <?php } ?>
</div>
