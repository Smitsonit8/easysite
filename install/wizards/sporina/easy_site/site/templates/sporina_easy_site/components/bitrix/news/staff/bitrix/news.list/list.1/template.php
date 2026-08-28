<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
if (empty($arResult['ITEMS'])) return;
$propertyValue = function ($item, $parameter) use ($arParams) { $code = isset($arParams[$parameter]) ? $arParams[$parameter] : ''; return $code !== '' && isset($item['DISPLAY_PROPERTIES'][$code]['DISPLAY_VALUE']) ? $item['DISPLAY_PROPERTIES'][$code]['DISPLAY_VALUE'] : ''; };
$icons = array('VK' => 'social.vk.svg', 'MAX' => 'social.max.svg', 'OK' => 'social.ok.svg', 'RUTUBE' => 'social.rutube.svg', 'DZEN' => 'social.dzen.svg');
$safeUrl = function ($url) { $url = trim(strip_tags((string)$url)); if ($url !== '' && !parse_url($url, PHP_URL_SCHEME)) $url = 'https://'.$url; $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME)); return in_array($scheme, array('http', 'https'), true) ? $url : ''; };
?>
<div class="sporina-staff sporina-staff--list">
    <?php if ($arParams['DISPLAY_TOP_PAGER'] === 'Y') echo $arResult['NAV_STRING']; ?>
    <?php foreach ($arResult['ITEMS'] as $item) {
        $id = $this->GetEditAreaId($item['ID']); $this->AddEditAction($item['ID'], $item['EDIT_LINK']); $this->AddDeleteAction($item['ID'], $item['DELETE_LINK']);
        $picture = !empty($item['PREVIEW_PICTURE']) ? $item['PREVIEW_PICTURE'] : $item['DETAIL_PICTURE']; $picture = $picture ? CFile::ResizeImageGet($picture, array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_EXACT)['src'] : SITE_TEMPLATE_PATH.'/images/picture.missing.png';
        $phone = $propertyValue($item, 'PROPERTY_PHONE'); $email = $propertyValue($item, 'PROPERTY_EMAIL');
    ?>
    <article id="<?= $id ?>" class="sporina-staff__row">
        <a class="sporina-staff__avatar" href="<?= $item['DETAIL_PAGE_URL'] ?>"><img src="<?= htmlspecialcharsbx($picture) ?>" alt="<?= htmlspecialcharsbx($item['NAME']) ?>"></a>
        <div class="sporina-staff__body">
            <?php if ($position = $propertyValue($item, 'PROPERTY_POSITION')) { ?><div class="sporina-staff__position"><?= htmlspecialcharsbx($position) ?></div><?php } ?>
            <a class="sporina-staff__name" href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= htmlspecialcharsbx($item['NAME']) ?></a>
            <?php if ($phone || $email) { ?><div class="sporina-staff__contacts"><?php if ($email) { ?><a href="mailto:<?= htmlspecialcharsbx(strip_tags($email)) ?>"><?= file_get_contents(__DIR__.'/svg/contact.email.svg') ?><span><?= htmlspecialcharsbx($email) ?></span></a><?php } ?><?php if ($phone) { ?><a href="tel:<?= htmlspecialcharsbx(preg_replace('/[^+0-9]/', '', strip_tags($phone))) ?>"><?= file_get_contents(__DIR__.'/svg/contact.phone.svg') ?><span><?= htmlspecialcharsbx($phone) ?></span></a><?php } ?></div><?php } ?>
            <?php if ($arParams['SOCIAL_SHOW'] === 'Y') { ?><div class="sporina-staff__social"><?php foreach ($icons as $name => $icon) { $value = $propertyValue($item, 'PROPERTY_SOCIAL_'.$name); $href = $safeUrl($value); if (!$href) continue; ?><a href="<?= htmlspecialcharsbx($href) ?>" target="_blank" rel="noopener noreferrer"><?= file_get_contents(__DIR__.'/svg/'.$icon) ?></a><?php } ?></div><?php } ?>
            <?php if (!empty($item['PREVIEW_TEXT'])) { ?><div class="sporina-staff__preview"><?= $item['PREVIEW_TEXT'] ?></div><?php } ?>
        </div>
    </article>
    <?php } ?>
    <?php if ($arParams['DISPLAY_BOTTOM_PAGER'] === 'Y') echo $arResult['NAV_STRING']; ?>
</div>
