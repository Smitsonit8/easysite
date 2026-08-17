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

	// Используем стандартный API CForm::GetList вместо прямого запроса к системной
	// таблице b_form. Структура таблицы не гарантируется между мажорными версиями,
	// поэтому обход API хрупок. Паттерн (SID_EXACT_MATCH => 'Y') симметричен тому,
	// что уже используется для полей формы в form_handler.php.
	$by = "s_id";
	$order = "asc";
	$isFiltered = false;
	$arForm = CForm::GetList(
		$by,
		$order,
		array("SID" => $sid, "SID_EXACT_MATCH" => "Y"),
		$isFiltered
	)->Fetch();

	// Если форма найдена — возвращаем её ID
	if ($arForm) {
		return (int)$arForm['ID'];
	}
	return false;
}

// Определяем константы — только если ядро загружено
if (!defined('ARTICLES_IBLOCK_ID')) {
    define('ARTICLES_IBLOCK_ID', getIblockIdByCode('articles_company'));
}

if (!defined('NEWS_IBLOCK_ID')) {
    define('NEWS_IBLOCK_ID', getIblockIdByCode('news_company'));
}

if (!defined('SERVICES_IBLOCK_ID')) {
    define('SERVICES_IBLOCK_ID', getIblockIdByCode('services'));
}

if (!defined('PRODUCTS_IBLOCK_ID')) {
    define('PRODUCTS_IBLOCK_ID', getIblockIdByCode('products'));
}

if (!defined('JOBS_IBLOCK_ID')) {
    define('JOBS_IBLOCK_ID', getIblockIdByCode('jobs_company'));
}

if (!defined('STAFF_IBLOCK_ID')) {
    define('STAFF_IBLOCK_ID', getIblockIdByCode('staff_company'));
}

if (!defined('ORDER_FORM_ID')) {
    define('ORDER_FORM_ID', getFormIdBySID('ORDER_FORM'));
}

if (!defined('BUY_FORM_ID')) {
    define('BUY_FORM_ID', getFormIdBySID('BUY_FORM'));
}
?>