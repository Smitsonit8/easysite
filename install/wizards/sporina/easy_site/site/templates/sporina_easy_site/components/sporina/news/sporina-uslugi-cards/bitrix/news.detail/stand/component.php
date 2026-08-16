<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// ✅ Отключаем кеш на уровне компонента — это ключевое
$this->SetResultCacheKeys(['CACHE_TYPE' => 'N', 'CACHE_TIME' => 0]);

// ✅ Обязательно: запускаем сессию (Bitrix не делает этого автоматически)
if (!isset($_SESSION)) {
    \Bitrix\Main\Session\Session::start();
}

// ✅ Лог для проверки — убедитесь, что файл загружается
\Bitrix\Main\Diag\Debug::writeToFile(
    'component.php executed at ' . date('c') . ' | ELEMENT_ID: ' . ($this->arResult['ID'] ?? 'unknown'),
    'news_detail_component.log'
);

$this->IncludeComponentTemplate();