<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$key = $property['key'];
$current = (string)($arResult['SETTINGS'][$key] ?? '#ffffff');
?>
<div class="system-settings-color" data-role="color">
    <div class="system-settings-color-palette">
        <?php foreach ($property['palette'] as $color) { ?>
            <button type="button" class="system-settings-color-swatch<?=$current === $color ? ' is-active' : ''?>" style="--swatch: <?=htmlspecialcharsbx($color)?>" data-color="<?=htmlspecialcharsbx($color)?>" aria-label="<?=htmlspecialcharsbx($color)?>"></button>
        <?php } ?>
    </div>
    <input type="color" value="<?=htmlspecialcharsbx($current)?>" data-role="color.picker">
    <input type="text" name="settings[<?=htmlspecialcharsbx($key)?>]" value="<?=htmlspecialcharsbx($current)?>" maxlength="7" pattern="#[0-9a-fA-F]{6}" data-role="color.value">
</div>
