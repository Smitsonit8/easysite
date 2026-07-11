<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Security\Random;

Loc::loadMessages(__FILE__);

$templateId = 'sporina-system-settings-' . Random::getString(8);
$viewsPath = __DIR__ . '/parts/views/';

Asset::getInstance()->addCss($this->GetFolder() . '/style.css');
Asset::getInstance()->addJs($this->GetFolder() . '/script.js');
?>
<!--noindex-->
<div
    id="<?=htmlspecialcharsbx($templateId)?>"
    class="system-settings js-system-settings"
    data-action-variable="<?=htmlspecialcharsbx($arResult['ACTION_VARIABLE'])?>"
    data-sessid="<?=htmlspecialcharsbx(bitrix_sessid())?>"
    data-active-category="<?=htmlspecialcharsbx($arResult['ACTIVE_CATEGORY'])?>"
>
    <button type="button" class="system-settings-trigger" data-role="open" aria-label="<?=Loc::getMessage('SPORINA_SETTINGS_OPEN')?>" aria-controls="<?=$templateId?>-panel">
        <span aria-hidden="true">⚙</span>
    </button>
    <div class="system-settings-overlay" data-role="overlay"></div>
    <aside id="<?=$templateId?>-panel" class="system-settings-panel" data-role="panel" aria-hidden="true" aria-label="<?=Loc::getMessage('SPORINA_SETTINGS_TITLE')?>">
        <header class="system-settings-header">
            <div>
                <strong><?=Loc::getMessage('SPORINA_SETTINGS_TITLE')?></strong>
                <small><?=Loc::getMessage('SPORINA_SETTINGS_DESCRIPTION')?></small>
            </div>
            <button type="button" class="system-settings-close" data-role="close" aria-label="<?=Loc::getMessage('SPORINA_SETTINGS_CLOSE')?>">×</button>
        </header>
        <div class="system-settings-error" data-role="error" role="alert" hidden></div>
        <form class="system-settings-form" data-role="form">
            <input type="hidden" name="sessid" value="<?=htmlspecialcharsbx(bitrix_sessid())?>">
            <div class="system-settings-layout">
                <nav class="system-settings-navigation" aria-label="<?=Loc::getMessage('SPORINA_SETTINGS_CATEGORIES')?>">
                    <?php foreach ($arResult['CATEGORIES'] as $code => $name) { ?>
                        <button type="button" class="system-settings-navigation-item<?=$code === $arResult['ACTIVE_CATEGORY'] ? ' is-active' : ''?>" data-role="category" data-category="<?=htmlspecialcharsbx($code)?>">
                            <?=htmlspecialcharsbx($name)?>
                        </button>
                    <?php } ?>
                </nav>
                <div class="system-settings-content">
                    <?php foreach ($arResult['CATEGORIES'] as $code => $name) { ?>
                        <section class="system-settings-category<?=$code === $arResult['ACTIVE_CATEGORY'] ? ' is-active' : ''?>" data-role="category.panel" data-category="<?=htmlspecialcharsbx($code)?>">
                            <h2><?=htmlspecialcharsbx($name)?></h2>
                            <?php if (empty($arResult['PROPERTIES'][$code])) { ?>
                                <p class="system-settings-empty"><?=Loc::getMessage('SPORINA_SETTINGS_EMPTY')?></p>
                            <?php } else { ?>
                                <?php foreach ($arResult['PROPERTIES'][$code] as $property) { ?>
                                    <div class="system-settings-property">
                                        <h3><?=htmlspecialcharsbx($property['name'])?></h3>
                                        <?php
                                        $view = basename((string)$property['view']);
                                        $viewFile = $viewsPath . $view . '.php';
                                        if (is_file($viewFile)) {
                                            include $viewFile;
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </section>
                    <?php } ?>
                </div>
            </div>
            <footer class="system-settings-actions">
                <button type="button" class="system-settings-button system-settings-button-secondary" data-role="submit" data-action="reset"><?=Loc::getMessage('SPORINA_SETTINGS_RESET')?></button>
                <button type="button" class="system-settings-button system-settings-button-primary" data-role="submit" data-action="apply"><?=Loc::getMessage('SPORINA_SETTINGS_APPLY')?></button>
            </footer>
        </form>
    </aside>
</div>
<?php include __DIR__ . '/parts/script.php'; ?>
<!--/noindex-->
