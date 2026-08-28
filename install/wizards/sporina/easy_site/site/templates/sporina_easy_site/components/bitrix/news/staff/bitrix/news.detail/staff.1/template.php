<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$propertyValue = function ($parameter) use ($arParams, $arResult) { $code = isset($arParams[$parameter]) ? $arParams[$parameter] : ''; return $code !== '' && isset($arResult['DISPLAY_PROPERTIES'][$code]['DISPLAY_VALUE']) ? $arResult['DISPLAY_PROPERTIES'][$code]['DISPLAY_VALUE'] : ''; };
$icons = array('VK' => 'social.vk.svg', 'MAX' => 'social.max.svg', 'OK' => 'social.ok.svg', 'RUTUBE' => 'social.rutube.svg', 'DZEN' => 'social.dzen.svg');
$safeUrl = function ($url) { $url = trim(strip_tags((string)$url)); if ($url !== '' && !parse_url($url, PHP_URL_SCHEME)) $url = 'https://'.$url; $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME)); return in_array($scheme, array('http', 'https'), true) ? $url : ''; };
$picture = !empty($arResult['DETAIL_PICTURE']) ? $arResult['DETAIL_PICTURE'] : $arResult['PREVIEW_PICTURE'];
$picture = $picture ? CFile::ResizeImageGet($picture, array('width' => 300, 'height' => 300), BX_RESIZE_IMAGE_EXACT)['src'] : SITE_TEMPLATE_PATH.'/images/picture.missing.png';
$phone = $propertyValue('PROPERTY_PHONE'); $email = $propertyValue('PROPERTY_EMAIL');
?>
<article class="sporina-staff-detail">
    <div class="sporina-staff-detail__information">
        <div class="sporina-staff-detail__photo"><img src="<?= htmlspecialcharsbx($picture) ?>" alt="<?= htmlspecialcharsbx($arResult['NAME']) ?>"></div>
        <div class="sporina-staff-detail__body">
            <?php if ($position = $propertyValue('PROPERTY_POSITION')) { ?><div class="sporina-staff-detail__position"><?= htmlspecialcharsbx($position) ?></div><?php } ?>
            <h1 class="sporina-staff-detail__name"><?= htmlspecialcharsbx($arResult['NAME']) ?></h1>
            <?php if ($phone || $email) { ?><div class="sporina-staff-detail__contacts">
                <?php if ($phone) { ?><a href="tel:<?= htmlspecialcharsbx(preg_replace('/[^+0-9]/', '', strip_tags($phone))) ?>"><?= file_get_contents(__DIR__.'/svg/contact.phone.svg') ?><span><?= htmlspecialcharsbx($phone) ?></span></a><?php } ?>
                <?php if ($email) { ?><a href="mailto:<?= htmlspecialcharsbx(strip_tags($email)) ?>"><?= file_get_contents(__DIR__.'/svg/contact.email.svg') ?><span><?= htmlspecialcharsbx($email) ?></span></a><?php } ?>
            </div><?php } ?>
            <?php if ($arParams['SOCIAL_SHOW'] === 'Y') { ?><div class="sporina-staff-detail__social"><?php foreach ($icons as $name => $icon) { $value = $propertyValue('PROPERTY_SOCIAL_'.$name); $href = $safeUrl($value); if (!$href) continue; ?><a href="<?= htmlspecialcharsbx($href) ?>" target="_blank" rel="noopener noreferrer"><?= file_get_contents(__DIR__.'/svg/'.$icon) ?></a><?php } ?></div><?php } ?>
        </div>
    </div>
    <?php if (!empty($arResult['DETAIL_TEXT'])) { ?><div class="sporina-staff-detail__description"><?= $arResult['DETAIL_TEXT'] ?></div><?php } elseif (!empty($arResult['PREVIEW_TEXT'])) { ?><div class="sporina-staff-detail__description"><?= $arResult['PREVIEW_TEXT'] ?></div><?php } ?>
    <div class="sporina-staff-detail__footer"><a href="<?= htmlspecialcharsbx($arResult['LIST_PAGE_URL']) ?>"><?= file_get_contents(__DIR__.'/svg/footer.arrow.svg') ?><span><?= GetMessage('SPORINA_STAFF_BACK') ?></span></a></div>
</article>
