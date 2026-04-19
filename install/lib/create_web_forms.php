<?php
/**
 * Скрипт для создания двух веб-форм в Битриксе
 * Форма 1: "Заказать" с кнопкой "Заказать"
 * Форма 2: "Купить" с кнопкой "Купить"
 *
 * Использование: разместите файл в корне сайта Битрикса и запустите через браузер
 * или выполните через командную строку: php create_web_forms.php
 */

namespace Sporina\Easy_site;

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use CForm;
use CFormField;
use CFormStatus;

define('DEBUG_FILE_NAME', 'debug.txt');

// Подключаем модуль веб-форм
if (!Loader::includeModule("form")) {
    die("Модуль веб-форм не установлен!");
}

class Create_web_forms
{
    public function createWebForm($formName, $buttonText, $sid)
    {
        $form = new \CForm();
        
        // Параметры формы
        $arFields = array(
            "SID" => $sid,
            "NAME" => $formName,
            "DESCRIPTION" => "Веб-форма: " . $formName,
            "USE_CAPTCHA" => "N",
            "BUTTON" => $buttonText,
            "C_SORT" => 100,
            "ACTIVE" => "Y",
            "arSITE" => array("s1"), // Замените на ваш SITE_ID
        );
        
        // Создаем форму
        $FORM_ID = $form->Set($arFields);
        
        if ($FORM_ID > 0) {
            //echo "Форма '{$formName}' создана с ID: {$FORM_ID}\n";
            // Создаем поля формы
        $fieldOrder = 100;
        
        // Поле "Имя"
        $arFields = array(
            "FORM_ID" => $FORM_ID,
            "ACTIVE" => "Y",
            "TITLE" => "Имя",
            "TITLE_TYPE" => "text",
            "SID" => "NAME",
            "C_SORT" => $fieldOrder,
            "ADDITIONAL" => "N",
            "REQUIRED" => "Y",
            "FIELD_TYPE" => "text",
            "IN_RESULTS_TABLE" => "Y",
            "IN_EXCEL_TABLE" => "Y",
        );
        $field = new \CFormField();
        $FIELD_ID = $field->Set($arFields, "N");
        /*
        if ($FIELD_ID > 0) {
            echo "  - Поле 'Имя' создано (ID: {$FIELD_ID})\n";
        }*/
        $fieldOrder += 100;
        
        // Поле "Email"
        $arFields = array(
            "FORM_ID" => $FORM_ID,
            "ACTIVE" => "Y",
            "TITLE" => "Email",
            "TITLE_TYPE" => "text",
            "SID" => "EMAIL",
            "C_SORT" => $fieldOrder,
            "ADDITIONAL" => "N",
            "REQUIRED" => "Y",
            "FIELD_TYPE" => "email",
            "IN_RESULTS_TABLE" => "Y",
            "IN_EXCEL_TABLE" => "Y",
        );
        $field = new \CFormField();
        $FIELD_ID = $field->Set($arFields, "N");
        /*
        if ($FIELD_ID > 0) {
            echo "  - Поле 'Email' создано (ID: {$FIELD_ID})\n";
        }*/
        $fieldOrder += 100;
        
        // Поле "Сообщение"
        $arFields = array(
            "FORM_ID" => $FORM_ID,
            "ACTIVE" => "Y",
            "TITLE" => "Сообщение",
            "TITLE_TYPE" => "text",
            "SID" => "MESSAGE",
            "C_SORT" => $fieldOrder,
            "ADDITIONAL" => "N",
            "REQUIRED" => "N",
            "FIELD_TYPE" => "textarea",
            "IN_RESULTS_TABLE" => "Y",
            "IN_EXCEL_TABLE" => "Y",
        );
        $field = new \CFormField();
        $FIELD_ID = $field->Set($arFields, "N");
        /*if ($FIELD_ID > 0) {
            echo "  - Поле 'Сообщение' создано (ID: {$FIELD_ID})\n";
        }*/
        $fieldOrder += 100;
        
        // Поле "Заказ"
        $arFields = array(
            "FORM_ID" => $FORM_ID,
            "ACTIVE" => "Y",
            "TITLE" => "Заказ",
            "TITLE_TYPE" => "text",
            "SID" => "ORDER",
            "C_SORT" => $fieldOrder,
            "ADDITIONAL" => "N",
            "REQUIRED" => "N",
            "FIELD_TYPE" => "hidden",
            "IN_RESULTS_TABLE" => "Y",
            "IN_EXCEL_TABLE" => "Y",
        );
        $field = new \CFormField();
        $FIELD_ID = $field->Set($arFields, "N");
        /*
        if ($FIELD_ID > 0) {
            echo "  - Поле 'Заказ' создано (ID: {$FIELD_ID})\n";
        }*/
        
        // Проверяем наличие статуса Default, если нет - создаем
        $status = new \CFormStatus();
        $dbStatus = \CFormStatus::GetList($FORM_ID, "by_sort", "asc", array("ACTIVE" => "Y"));
        $defaultExists = false;
        while ($arStatus = $dbStatus->Fetch()) {
            if ($arStatus["DEFAULT_VALUE"] == "Y") {
                $defaultExists = true;
                //echo "  - Статус 'Default' уже существует\n";
                break;
            }
        }
        
        if (!$defaultExists) {
            // Создаем статус Default
            $arStatusFields = array(
                "FORM_ID" => $FORM_ID,
                "ACTIVE" => "Y",
                "TITLE" => "Default",
                "C_SORT" => 100,
                "DEFAULT_VALUE" => "Y",
            );
            $STATUS_ID = $status->Set($arStatusFields);
            /*if ($STATUS_ID > 0) {
                echo "  - Статус 'Default' создан (ID: {$STATUS_ID})\n";
            }*/
        }
        
        return $FORM_ID;
        } else {
        //echo "Ошибка при создании формы '{$formName}': " . $form->LAST_ERROR . "\n";
            writeToLog($form->LAST_ERROR, "Ошибка при создании формы '{$formName}': ");
            return false;
        }
    }
    
    // Метод для создания форм, который будет вызываться по событию
    public function createForms()
    {
        // Создаем первую форму "Заказать"
        $form1Id = $this->createWebForm("Форма заказа", "Заказать", "ORDER_FORM");

        // Создаем вторую форму "Купить"
        $form2Id = $this->createWebForm("Форма покупки", "Купить", "BUY_FORM");
        
        return true;
    }
    
    // Метод для удаления форм при удалении модуля
    public function deleteForms()
    {
        $formSids = array("ORDER_FORM", "BUY_FORM");
        
        foreach ($formSids as $sid) {
            $dbForm = \CForm::GetList("", "", array("SID" => $sid));
            if ($arForm = $dbForm->Fetch()) {
                $formId = $arForm["ID"];
                if (\CForm::Delete($formId)) {
                    // Форма успешно удалена
                } else {
                    writeToLog("Ошибка удаления формы с SID: " . $sid, "Ошибка удаления формы: ");
                }
            }
        }
        
        return true;
    }
}

//Функция записи в файл
function writeToLog($data, $title = '')
{
	if (!DEBUG_FILE_NAME)
	return false;
    
    if ($data == ""){
        $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s")."\n";
        $log .= $title."\n";
        $log .= "Ничего'"."\n";
        $log .= "\n------------------------\n";
    }
    else{
	    $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s")."\n";
        $log .= $title."\n";
	    $log .= print_r($data, 1);
	    $log .= "\n------------------------\n";
    }
	file_put_contents(__DIR__."/".DEBUG_FILE_NAME, $log, FILE_APPEND);

	return true;

}

?>
