<?
// Проверяем, что ядро Bitrix загружено — это ОБЯЗАТЕЛЬНО
if (!defined('BX_ROOT')) {
    return; // Ядро не инициализировано — выходим, не пытаемся использовать классы
}

// Функция для получения ID инфоблока по коду
function getIblockIdByCode($iblockCode) {
    // Убедимся, что модуль подключен — хотя в контексте BX_ROOT он уже должен быть
    if (!\CModule::IncludeModule("iblock")) {
        \Bitrix\Main\Diag\Debug::writeToFile(
            'Не удалось подключить модуль "iblock" при получении ID инфоблока: ' . $iblockCode,
            'errors.log'
        );
        return 0;
    }

    $rs = \CIBlock::GetList(
        [],
        ['CODE' => $iblockCode, 'ACTIVE' => 'Y'] // Добавляем ACTIVE => 'Y' для безопасности
    );

    if ($iblock = $rs->Fetch()) {
        return (int)$iblock['ID'];
    }

    \Bitrix\Main\Diag\Debug::writeToFile(
        'Инфоблок с CODE="' . $iblockCode . '" не найден или не активен.',
        'errors.log'
    );

    return 0;
}

//Поиск ид формы по SID
function getFormIdBySID($sid) {
	// Подключаем модуль формы
	if (class_exists('Bitrix\Main\Loader')) {
		if (!\Bitrix\Main\Loader::includeModule('form')) {
			return false;
		}
	} else {
		if (!CModule::IncludeModule('form')) {
			return false;
		}
	}
	global $DB;

	// Безопасно экранируем входные данные для предотвращения SQL-инъекций
	$safeSid = $DB->ForSql($sid);
	
	// Запрос к таблице b_form для получения ID по SID
	$rs = $DB->Query("
		SELECT ID
		FROM b_form
		WHERE SID = '{$safeSid}'
	");
	
	// Если форма найдена — возвращаем её ID
	if ($ar = $rs->Fetch()) {
		return (int)$ar['ID'];
	}
	return false;
}

// Определяем константы — только если ядро загружено
if (!defined('SCHEDULE_CHANGES_IBLOCK_ID')) {
    define('SCHEDULE_CHANGES_IBLOCK_ID', getIblockIdByCode('schedule_changes'));
}

if (!defined('NEWS_IBLOCK_ID')) {
    define('NEWS_IBLOCK_ID', getIblockIdByCode('news_companii'));
}

if (!defined('SERVICES_IBLOCK_ID')) {
    define('SERVICES_IBLOCK_ID', getIblockIdByCode('services'));
}

if (!defined('PRODUCTS_IBLOCK_ID')) {
    define('PRODUCTS_IBLOCK_ID', getIblockIdByCode('products'));
}

if (!defined('ORDER_FORM_ID')) {
    define('ORDER_FORM_ID', getFormIdBySID('ORDER_FORM'));
}

if (!defined('BUY_FORM_ID')) {
    define('BUY_FORM_ID', getFormIdBySID('BUY_FORM'));
}
?>