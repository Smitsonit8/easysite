<?php
define('DEBUG_FILE_NAME', 'debug_i.txt');
/**
 * Обработчик события onBeforeResultAdd для передачи значения из детальной страницы в форму
 * 
 * Подключить в /bitrix/php_interface/init.php:
 * require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/form_handler.php");
 * или
 * require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/form_handler.php");
 */

// use Bitrix\Main\Loader; // Не используем напрямую для совместимости

/**
 * Обработчик события onBeforeResultAdd
 * Передает значение из сессии в поле формы с символьным кодом USLUGA
 * 
 * @param int $WEB_FORM_ID ID веб-формы
 * @param array $arFields Массив полей результата для записи в БД
 * @param array $arrVALUES Массив значений ответов результата веб-формы
 */
function onBeforeResultAdd_AddUslugaField($WEB_FORM_ID, &$arFields, &$arrVALUES)
{
	global $APPLICATION;
	$form_order = getFormBySID("ORDER_FORM");
	$form_buy = getFormBySID("BUY_FORM");
	if ($WEB_FORM_ID == $form_order) 
	{
		//writeToLog($arrVALUES, '$arrVALUES');
		// Получаем значение из сессии
		$uslugaName = isset($_SESSION['FORM_USLUGA_NAME']) ? $_SESSION['FORM_USLUGA_NAME'] : '';
		//writeToLog($uslugaName, '$uslugaName');
		if (!empty($uslugaName)) 
		{
			// Получаем ID поля по символьному коду ORDER
			$fieldId = getFormFieldIdByCode($WEB_FORM_ID, 'ORDER');
			//writeToLog($fieldId, '$fieldId');
			if ($fieldId) 
			{
				// Определяем тип поля и формируем имя поля
				$fieldType = getFormFieldType($WEB_FORM_ID, $fieldId);
				
				if ($fieldType) 
				{
					// Формируем имя поля в зависимости от типа
					// Например: form_text_123, form_textarea_123, form_dropdown_123 и т.д.
					$fieldName = 'form_' . $fieldType;
					//writeToLog($fieldName, '$fieldName');
					
					// Записываем значение в массив значений формы
					$arrVALUES[$fieldName] = $uslugaName;
					//writeToLog($arrVALUES, '$arrVALUES-результат');
					
					// Очищаем значение из сессии после использования
					unset($_SESSION['FORM_USLUGA_NAME']);
				}
			}
		}
	}
	if ($WEB_FORM_ID == $form_buy) 
	{
		//writeToLog($arrVALUES, '$arrVALUES');
		// Получаем значение из сессии
		$uslugaName = isset($_SESSION['FORM_TOVAR_NAME']) ? $_SESSION['FORM_TOVAR_NAME'] : '';
		
		if (!empty($uslugaName)) 
		{
			// Получаем ID поля по символьному коду ORDER
			$fieldId = getFormFieldIdByCode($WEB_FORM_ID, 'ORDER');
			
			if ($fieldId) 
			{
				// Определяем тип поля и формируем имя поля
				$fieldType = getFormFieldType($WEB_FORM_ID, $fieldId);
				
				if ($fieldType) 
				{
					// Формируем имя поля в зависимости от типа
					// Например: form_text_123, form_textarea_123, form_dropdown_123 и т.д.
					$fieldName = 'form_' . $fieldType;
					//writeToLog($fieldName, '$fieldName');
					
					// Записываем значение в массив значений формы
					$arrVALUES[$fieldName] = $uslugaName;
					//writeToLog($arrVALUES, '$arrVALUES-результат');
					
					// Очищаем значение из сессии после использования
					unset($_SESSION['FORM_TOVAR_NAME']);
				}
			}
		}
	}
}

//Поиск ид формы по SID
function getFormBySID($sid) {
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

/**
 * Получает ID поля формы по символьному коду
 * 
 * @param int $formId ID формы
 * @param string $code Символьный код поля
 * @return int|false ID поля или false
 */
function getFormFieldIdByCode($formId, $code)
{
	// Подключаем модуль формы (совместимость со старыми и новыми версиями Bitrix)
	if (class_exists('Bitrix\Main\Loader')) {
		if (!\Bitrix\Main\Loader::includeModule('form')) {
			return false;
		}
	} else {
		if (!CModule::IncludeModule('form')) {
			return false;
		}
	}
	
	$by = "s_id";
	$order = "asc";
	$arFilter = [
		'SID' => $code,
		'SID_EXACT_MATCH' => 'Y'  // Точное совпадение по символьному коду
	];
	$isFiltered = false;
	$rsFields = CFormField::GetList(
		$formId,
		'ALL',
		$by,
		$order,
		$arFilter,
		$isFiltered
	);
	
	if ($arField = $rsFields->Fetch()) 
	{
		//writeToLog($arField, '$arField');
		return $arField['ID'];
	}
	
	return false;
}

/**
 * Получает тип поля формы по ID
 * 
 * @param int $formId ID формы
 * @param int $fieldId ID поля
 * @return string|false Тип поля или false
 */
function getFormFieldType($formId, $fieldId)
{
	// Подключаем модуль формы (совместимость со старыми и новыми версиями Bitrix)
	if (class_exists('Bitrix\Main\Loader')) {
		if (!\Bitrix\Main\Loader::includeModule('form')) {
			return false;
		}
	} else {
		if (!CModule::IncludeModule('form')) {
			return false;
		}
	}
	$isFiltered = false;
	$rsAnswers = CFormAnswer::GetList(
	$fieldId, 
	$by="s_id", 
	$order="desc", 
	$arFilter = [], 
	$isFiltered
	);

	if ($arAnswer = $rsAnswers->Fetch()) 
	{
		//writeToLog($arAnswer, '$arAnswer');
		// Возвращаем тип ответа (text, textarea, dropdown и т.д.)
		return $arAnswer['FIELD_TYPE'].'_'.$arAnswer['ID'];
	}
	
	return false;
}

function writeToLog($data, $title = '')
{
	if (!DEBUG_FILE_NAME)
	return false;

	$log = "\n------------------------\n";
	$log .= date("Y.m.d G:i:s")."\n";
	$log .= (strlen($title) > 0 ? $title : 'DEBUG')."\n";
	$log .= print_r($data, 1);
	$log .= "\n------------------------\n";

	file_put_contents(__DIR__."/".DEBUG_FILE_NAME, $log, FILE_APPEND);

	return true;
}


// Регистрируем обработчик события
AddEventHandler('form', 'onBeforeResultAdd', 'onBeforeResultAdd_AddUslugaField');