<?php
// Создание веб-форм
// Этот файл будет выполнен при установке мастера

if (!defined("WIZARD_SITE_ID")) {
    return false;
}

// Подключаем модуль веб-форм
if (!CModule::IncludeModule("form")) {
    return false;
}

// Используем константу мастера для ID сайта
$siteID = WIZARD_SITE_ID;

// Создаем статус и права
function setCreatorMoveAccess($formId, $statusTitle = "Default") {
    $arStatusFields = [
        "FORM_ID" => $formId,
        "ACTIVE" => "Y",
        "TITLE" => $statusTitle,
        "C_SORT" => 100,
        "DEFAULT_VALUE" => "Y",
        "arPERMISSION_MOVE"   => array(0),
    ];

    $status = new CFormStatus();
    return $status->Set($arStatusFields);

}

// Создаем форму "Заказать"
// Проверяем, не существует ли уже форма с таким SID
$dbForm = CForm::GetList("", "", array("SID" => "ORDER_FORM"));
$arExistingForm = $dbForm->Fetch();

if (!$arExistingForm) {
    $arFields = array(
        "SID" => "ORDER_FORM",
        "NAME" => "Форма заказа",
        "DESCRIPTION" => "Веб-форма для заказа",
        "USE_CAPTCHA" => "N",
        "BUTTON" => "Заказать",
        "C_SORT" => 100,
        "ACTIVE" => "Y",
        "arSITE" => array($siteID),
    );

    $form = new CForm();
    $FORM_ID = $form->Set($arFields);
} else {
    $FORM_ID = $arExistingForm["ID"];
}

if ($FORM_ID > 0 && !$arExistingForm) {
    // Создаем поля формы "Заказать" только если форма была только что создана
    
    // Поле "Имя"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Имя",
        "TITLE_TYPE" => "text",
        "SID" => "NAME",
        "C_SORT" => 100,
        "ADDITIONAL" => "N",
        "REQUIRED" => "Y",
        "FIELD_TYPE" => "text",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Имя"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "text",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    // Поле "Email"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Email",
        "TITLE_TYPE" => "text",
        "SID" => "EMAIL",
        "C_SORT" => 200,
        "ADDITIONAL" => "N",
        "REQUIRED" => "Y",
        "FIELD_TYPE" => "email",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Email"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "email",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    // Поле "Сообщение"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Сообщение",
        "TITLE_TYPE" => "text",
        "SID" => "MESSAGE",
        "C_SORT" => 300,
        "ADDITIONAL" => "N",
        "REQUIRED" => "N",
        "FIELD_TYPE" => "textarea",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Сообщение"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "textarea",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    // Поле "Заказ"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Заказ",
        "TITLE_TYPE" => "text",
        "SID" => "ORDER",
        "C_SORT" => 400,
        "ADDITIONAL" => "N",
        "REQUIRED" => "N",
        "FIELD_TYPE" => "hidden",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Заказ"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "hidden",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    setCreatorMoveAccess($FORM_ID, "Default");
}

// Создаем форму "Купить"
// Проверяем, не существует ли уже форма с таким SID
$dbForm = CForm::GetList("", "", array("SID" => "BUY_FORM"));
$arExistingForm2 = $dbForm->Fetch();

if (!$arExistingForm2) {
    $arFields = array(
        "SID" => "BUY_FORM",
        "NAME" => "Форма покупки",
        "DESCRIPTION" => "Веб-форма для покупки",
        "USE_CAPTCHA" => "N",
        "BUTTON" => "Купить",
        "C_SORT" => 200,
        "ACTIVE" => "Y",
        "arSITE" => array($siteID),
    );

    $form = new CForm();
    $FORM_ID = $form->Set($arFields);
} else {
    $FORM_ID = $arExistingForm2["ID"];
}

if ($FORM_ID > 0 && !$arExistingForm2) {
    // Создаем поля формы "Купить" только если форма была только что создана
    
    // Поле "Имя"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Имя",
        "TITLE_TYPE" => "text",
        "SID" => "NAME",
        "C_SORT" => 100,
        "ADDITIONAL" => "N",
        "REQUIRED" => "Y",
        "FIELD_TYPE" => "text",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Имя"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "text",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    // Поле "Email"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Email",
        "TITLE_TYPE" => "text",
        "SID" => "EMAIL",
        "C_SORT" => 200,
        "ADDITIONAL" => "N",
        "REQUIRED" => "Y",
        "FIELD_TYPE" => "email",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Email"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "email",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    // Поле "Сообщение"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Сообщение",
        "TITLE_TYPE" => "text",
        "SID" => "MESSAGE",
        "C_SORT" => 300,
        "ADDITIONAL" => "N",
        "REQUIRED" => "N",
        "FIELD_TYPE" => "textarea",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Сообщение"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "textarea",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    // Поле "Заказ"
    $arFields = array(
        "FORM_ID" => $FORM_ID,
        "ACTIVE" => "Y",
        "TITLE" => "Заказ",
        "TITLE_TYPE" => "text",
        "SID" => "ORDER",
        "C_SORT" => 400,
        "ADDITIONAL" => "N",
        "REQUIRED" => "N",
        "FIELD_TYPE" => "hidden",
        "IN_RESULTS_TABLE" => "Y",
        "IN_EXCEL_TABLE" => "Y",
    );
    $field = new CFormField();
    $FIELD_ID = $field->Set($arFields, "N");
    
    // Создаем ответ для поля "Заказ"
    $arAnswer = array(
        "FIELD_ID" => $FIELD_ID,
        "ACTIVE" => "Y",
        "MESSAGE" => " ",
        "C_SORT" => 100,
        "FIELD_TYPE" => "hidden",
    );
    $answer = new CFormAnswer();
    $answer->Set($arAnswer);
    
    setCreatorMoveAccess($FORM_ID, "Default");
}

return true;
?>