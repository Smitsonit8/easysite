<?php
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$pageUrl = trim((string)($arParams['PAGE_URL'] ?? ''));
$pageTitle = trim(strip_tags((string)($arParams['PAGE_TITLE'] ?? '')));

if ($pageUrl === '') {
    return;
}

if (!preg_match('~^https?://~i', $pageUrl)) {
    $scheme = CMain::IsHTTPS() ? 'https://' : 'http://';
    $pageUrl = $scheme . ($_SERVER['HTTP_HOST'] ?? '') . $pageUrl;
}

$encodedUrl = rawurlencode($pageUrl);
$encodedTitle = rawurlencode($pageTitle);
$encodedText = rawurlencode(trim($pageTitle . ' ' . $pageUrl));

$shareLinks = [
    'max' => [
        'title' => Loc::getMessage("SHARE_MAX"),
        'href' => 'https://max.ru/:share?text=' . $encodedText,
        'label' => 'MAX',
    ],
    'vk' => [
        'title' => Loc::getMessage("SHARE_VK"),
        'href' => 'https://vk.com/share.php?url=' . $encodedUrl . '&title=' . $encodedTitle,
        'label' => 'VK',
    ],
    'ok' => [
        'title' => Loc::getMessage("SHARE_OK"),
        'href' => 'https://connect.ok.ru/offer?url=' . $encodedUrl . '&title=' . $encodedTitle,
        'label' => 'OK',
    ],
    'mail' => [
        'title' => Loc::getMessage("SHARE_MAIL"),
        'href' => 'https://connect.mail.ru/share?url=' . $encodedUrl . '&title=' . $encodedTitle,
        'label' => 'Mail',
    ],
];

$shareLinks = array_filter($shareLinks, static function ($shareLink, $network) use ($arParams) {
    return ($arParams['SHARE_' . strtoupper($network)] ?? 'Y') !== 'N';
}, ARRAY_FILTER_USE_BOTH);

if (empty($shareLinks)) {
    return;
}
?>

<nav class="sporina-social-share" aria-label="<?=Loc::getMessage("SHARE_LABEL")?>">
    <span class="sporina-social-share__label"><?=Loc::getMessage("SHARE_LABEL")?></span>
    <div class="sporina-social-share__links">
        <?php foreach ($shareLinks as $network => $shareLink): ?>
            <a
                class="sporina-social-share__link sporina-social-share__link--<?=$network?>"
                href="<?=htmlspecialcharsbx($shareLink['href'])?>"
                target="_blank"
                rel="noopener noreferrer"
                title="<?=htmlspecialcharsbx($shareLink['title'])?>"
                aria-label="<?=htmlspecialcharsbx($shareLink['title'])?>"
            >
                <span aria-hidden="true" class="sporina-social-share__svg">
                <? if ($network === 'vk'): ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" fill=""></rect>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.6329 8.6094C19.7442 8.25816 19.6329 8 19.1035 8H17.3531C16.908 8 16.703 8.22299 16.5917 8.46895C16.5917 8.46895 15.7015 10.5239 14.4404 11.8587C14.0325 12.2452 13.847 12.368 13.6245 12.368C13.5132 12.368 13.3522 12.2452 13.3522 11.8939V8.6094C13.3522 8.18782 13.223 8 12.8521 8H10.1014C9.82336 8 9.65607 8.19563 9.65607 8.38108C9.65607 8.78075 10.2865 8.87288 10.3515 9.99693V12.4384C10.3515 12.9737 10.2495 13.0708 10.0269 13.0708C9.43352 13.0708 7.99018 11.0065 7.13398 8.64457C6.96619 8.18545 6.7979 8 6.35055 8H4.60014C4.10002 8 4 8.22299 4 8.46895C4 8.90805 4.59351 11.0861 6.76314 13.9665C8.20973 15.9335 10.2475 17 12.1019 17C13.2147 17 13.3522 16.7632 13.3522 16.3552V14.8684C13.3522 14.3947 13.4576 14.3002 13.8098 14.3002C14.0696 14.3002 14.5146 14.4232 15.5532 15.3716C16.74 16.4955 16.9355 17 17.6032 17H19.3536C19.8537 17 20.1038 16.7632 19.9595 16.2957C19.8017 15.8299 19.2351 15.1542 18.4831 14.3529C18.0752 13.8962 17.4631 13.4044 17.2778 13.1585C17.0182 12.8424 17.0923 12.7019 17.2778 12.421C17.2778 12.421 19.4103 9.57559 19.6329 8.60951V8.6094Z"></path>
                    </svg>
                <? endif; ?>
                <? if ($network === 'ok'): ?>
                    <svg class="social-icon-svg-styles" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g transform="scale(0.7741935484)">
                            <path fill="" fill-rule="evenodd" clip-rule="evenodd" d="M17.2052 11.75C17.2052 10.8368 16.4356 10.0942 15.4895 10.0942C14.5442 10.0942 13.7738 10.8368 13.7738 11.75C13.7738 12.6626 14.5442 13.4057 15.4895 13.4057C16.4356 13.4057 17.2052 12.6626 17.2052 11.75ZM19.6332 11.75C19.6332 13.9551 17.7752 15.7488 15.4896 15.7488C13.2044 15.7488 11.346 13.9551 11.346 11.75C11.346 9.54419 13.2044 7.75 15.4896 7.75C17.7752 7.75 19.6332 9.54419 19.6332 11.75ZM19.5828 18.0517C18.8336 18.5059 18.0201 18.8281 17.1767 19.0135L19.4931 21.2497C19.9676 21.7069 19.9676 22.4492 19.4931 22.9068C19.019 23.3644 18.2507 23.3644 17.7772 22.9068L15.4997 20.7094L13.2242 22.9068C12.987 23.1354 12.6761 23.2498 12.3651 23.2498C12.0547 23.2498 11.7443 23.1354 11.5071 22.9068C11.033 22.4492 11.033 21.7073 11.5066 21.2497L13.8232 19.0135C12.9798 18.8281 12.1663 18.5054 11.4171 18.0517C10.8501 17.7066 10.6797 16.9836 11.037 16.4358C11.3933 15.8873 12.1425 15.7221 12.7105 16.0672C14.4068 17.0973 16.5921 17.0975 18.2894 16.0672C18.8574 15.7221 19.6064 15.8873 19.9634 16.4358C20.3207 16.9831 20.1498 17.7066 19.5828 18.0517Z"></path>
                        </g>
                    </svg>
                <? endif; ?>
                <? if ($network === 'max'): ?>
                    <svg class="social-icon-svg-styles" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <svg class="social-icon-svg-styles" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"></svg>
                        <g transform="scale(0.7741935484)" clip-path="url(#clip0_385_151)">
                            <g clip-path="url(#clip1_385_151)">
                                <path fill="" fill-rule="evenodd" clip-rule="evenodd" d="M15.7546 27.2281C13.4294 27.2281 12.3488 26.8887 10.4705 25.5309C9.28248 27.0584 5.52028 28.2521 5.35621 26.2098C5.35621 24.6766 5.01677 23.3811 4.63206 21.9667C4.17381 20.2242 3.65332 18.2837 3.65332 15.472C3.65332 8.75657 9.16368 3.70447 15.6924 3.70447C22.2267 3.70447 27.3467 9.0055 27.3467 15.5342C27.3687 21.9619 22.1823 27.1939 15.7546 27.2281ZM15.8508 9.50901C12.6713 9.34495 10.1933 11.5457 9.64456 14.9967C9.19196 17.8538 9.99532 21.3331 10.6799 21.5141C11.008 21.5933 11.834 20.9257 12.3488 20.4109C13.2001 20.999 14.1914 21.3522 15.2228 21.4349C18.5173 21.5934 21.3323 19.0853 21.5535 15.7944C21.6823 12.4966 19.1457 9.70339 15.8508 9.51467L15.8508 9.50901Z"></path>
                            </g>
                        </g>
                        <defs>
                            <clipPath id="clip0_385_151">
                                <rect width="31" height="31" fill="white"></rect>
                            </clipPath>
                            <clipPath id="clip1_385_151">
                                <rect width="31" height="31" fill="white"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                <? endif; ?>
                <? if ($network === 'mail'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><title>mail-ru</title><path d="M15.45 11.91c-.11-2.21-1.75-3.54-3.73-3.54h-.08c-2.29 0-3.55 1.8-3.55 3.84c0 2.29 1.53 3.74 3.54 3.74c2.25 0 3.72-1.65 3.83-3.59m-3.81-5.97c1.53 0 2.97.68 4.02 1.74c0-.51.33-.89.83-.89h.11c.74 0 .89.7.89.92v7.9c-.04.52.54.78.87.44c1.27-1.29 2.78-6.69-.79-9.81c-3.33-2.92-7.8-2.44-10.18-.8c-2.52 1.74-4.14 5.61-2.57 9.22c1.71 3.95 6.61 5.13 9.52 3.95c1.48-.59 2.15 1.4.65 2.05c-2.34.99-8.77.89-11.78-4.32c-2.03-3.52-1.93-9.71 3.46-12.92C10.81 1.42 16.24 2.1 19.5 5.5c3.45 3.6 3.25 10.3-.1 12.91c-1.51 1.18-3.76.03-3.74-1.7l-.02-.56a5.611 5.611 0 0 1-3.99 1.66C8.63 17.81 6 15.15 6 12.13c0-3.05 2.63-5.74 5.65-5.74z" fill=""/></svg>
                <? endif; ?>
                </span>

            </a>
        <?php endforeach; ?>
    </div>
</nav>
