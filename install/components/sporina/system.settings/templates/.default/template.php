<?php

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Security\Random;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$activeCategory = $arResult['ACTIVE_CATEGORY'];
if (!isset($arResult['PANEL'][$activeCategory])) {
    $activeCategory = (string) array_key_first($arResult['PANEL']);
}

$templateId = 'sporina-system-settings-' . Random::getString(8);
Asset::getInstance()->addCss($this->GetFolder() . '/style.css');
Asset::getInstance()->addJs($this->GetFolder() . '/script.js');
?>
<div
    id="<?=htmlspecialcharsbx($templateId)?>"
    class="system-settings js-system-settings"
    data-action-variable="<?=htmlspecialcharsbx($arResult['ACTION_VARIABLE'])?>"
>
    <button class="system-settings-trigger" type="button" data-role="open" aria-controls="<?=$templateId?>-panel" aria-expanded="false">
        <span aria-hidden="true">⚙</span>
        <span><?=Loc::getMessage('SPORINA_SETTINGS_TITLE')?></span>
    </button>
    <div class="system-settings-overlay" data-role="overlay"></div>
    <aside id="<?=$templateId?>-panel" class="system-settings-panel" data-role="panel" aria-hidden="true" aria-label="<?=Loc::getMessage('SPORINA_SETTINGS_TITLE')?>">
        <header class="system-settings-header">
            <div>
                <strong><?=Loc::getMessage('SPORINA_SETTINGS_TITLE_2')?></strong>
                <small><?=Loc::getMessage('SPORINA_SETTINGS_DESCRIPTION')?></small>
            </div>
            <button class="system-settings-close" type="button" data-role="close" aria-label="<?=Loc::getMessage('SPORINA_SETTINGS_CLOSE')?>">×</button>
        </header>
        <form class="system-settings-form" method="post" action="">
            <?=bitrix_sessid_post()?>
            <input type="hidden" name="<?=htmlspecialcharsbx($arResult['ACTION_VARIABLE'])?>" value="apply">
            <div class="system-settings-layout">
                <nav class="system-settings-navigation" aria-label="<?=Loc::getMessage('SPORINA_SETTINGS_CATEGORIES')?>">
                    <?php foreach ($arResult['PANEL'] as $category => $group): ?>
                        <button class="system-settings-navigation-item<?= $category === $activeCategory ? ' is-active' : '' ?>" type="button" data-role="category" data-category="<?=htmlspecialcharsbx($category)?>">
                            <?=htmlspecialcharsbx($group['title'])?>
                        </button>
                    <?php endforeach; ?>
                </nav>
                <div class="system-settings-content">
                    <?php foreach ($arResult['PANEL'] as $category => $group): ?>
                        <section class="system-settings-category<?= $category === $activeCategory ? ' is-active' : '' ?>" data-role="category.panel" data-category="<?=htmlspecialcharsbx($category)?>">
                            <h2><?=htmlspecialcharsbx($group['title'])?></h2>
                            <?php if (empty($group['fields'])): ?>
                                <p class="system-settings-empty"><?=Loc::getMessage('SPORINA_SETTINGS_EMPTY')?></p>
                            <?php endif; ?>
                            <?php foreach ($group['fields'] as $field): ?>
                                <label class="system-settings-field" data-component-fallback="<?= !empty($field['componentFallback']) ? 'Y' : 'N' ?>" data-stored="<?= !empty($field['stored']) ? 'Y' : 'N' ?>">
                                    <span class="system-settings-field-label"><?=htmlspecialcharsbx($field['label'])?></span>
                                    <span class="system-settings-field-control">
                                        <?php if ($field['type'] === 'checkbox'): ?>
                                            <input type="hidden" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="N">
                                            <input type="checkbox" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="Y"<?= $field['value'] === 'Y' ? ' checked' : '' ?>>
                                        <?php elseif ($field['type'] === 'color'): ?>
                                            <input type="color" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="<?=htmlspecialcharsbx($field['value'])?>">
                                        <?php elseif (in_array($field['type'], ['latitude', 'longitude', 'number'], true)): ?>
                                            <input type="number" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="<?=htmlspecialcharsbx($field['value'])?>" step="<?= $field['type'] === 'number' ? '1' : 'any' ?>"<?= $field['type'] === 'latitude' ? ' min="-90" max="90"' : '' ?><?= $field['type'] === 'longitude' ? ' min="-180" max="180"' : '' ?><?= $field['type'] === 'number' ? ' min="1"' : '' ?>>
                                        <?php elseif ($field['type'] === 'text'): ?>
                                            <input type="text" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="<?=htmlspecialcharsbx($field['value'])?>" maxlength="255">
                                        <?php elseif ($field['type'] === 'select' && !empty($field['previews'])): ?>
                                            <span class="system-settings-template-list" style="--template-preview-ratio: <?=htmlspecialcharsbx($field['previewRatio'] ?? '4 / 3')?>">
                                                <?php foreach ($field['values'] as $value => $label): ?>
                                                    <?php if (isset($field['previews'][$value])): ?>
                                                        <label class="system-settings-template-option">
                                                            <input type="radio" name="settings[<?=htmlspecialcharsbx($field['key'])?>]" value="<?=htmlspecialcharsbx($value)?>"<?= $value === $field['value'] ? ' checked' : '' ?>>
                                                            <span class="system-settings-template-card">
                                                                <img src="<?=htmlspecialcharsbx($this->GetFolder() . '/' . $field['previews'][$value])?>" alt="" loading="lazy">
                                                                <span><?=htmlspecialcharsbx($label)?></span>
                                                            </span>
                                                        </label>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </span>
                                        <?php else: ?>
                                            <select name="settings[<?=htmlspecialcharsbx($field['key'])?>]">
                                                <?php foreach ($field['values'] as $value => $label): ?>
                                                    <option value="<?=htmlspecialcharsbx($value)?>"<?= $value === $field['value'] ? ' selected' : '' ?>><?=htmlspecialcharsbx($label)?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </section>
                    <?php endforeach; ?>
                </div>
            </div>
            <footer class="system-settings-actions">
                <output class="system-settings-status" data-role="status" aria-live="polite"></output>
                <button class="system-settings-button system-settings-button-secondary" type="button" data-role="reset"><?=Loc::getMessage('SPORINA_SETTINGS_RESET')?></button>
                <button class="system-settings-button system-settings-button-primary" type="submit"><?=Loc::getMessage('SPORINA_SETTINGS_APPLY')?></button>
                
            </footer>
        </form>
    </aside>
</div>
