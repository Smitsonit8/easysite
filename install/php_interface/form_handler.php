<?php

function sporinaLogFormResultEvent($stage, array $context = array())
{
    \Bitrix\Main\Diag\Debug::writeToFile(
        array_merge(array('stage' => $stage), $context),
        '',
        $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/sporina_form_debug.log'
    );
}

function sporinaOnBeforeFormResultAdd($webFormId, &$arFields, &$arValues)
{
    $webFormId = (int)$webFormId;
    sporinaLogFormResultEvent('onBeforeResultAdd', array(
        'form_id' => $webFormId,
        'context_id' => isset($_POST['SPORINA_FORM_CONTEXT_ID']) ? (int)$_POST['SPORINA_FORM_CONTEXT_ID'] : 0,
        'context_type' => isset($_POST['SPORINA_FORM_CONTEXT_TYPE']) ? (string)$_POST['SPORINA_FORM_CONTEXT_TYPE'] : '',
        'has_name' => !empty($_POST['form_text_291']),
        'has_email' => !empty($_POST['form_email_292']),
        'has_message' => !empty($_POST['form_textarea_293']),
    ));
    $contexts = array(
        'product' => array(
            'form_id' => defined('BUY_FORM_ID') ? (int)BUY_FORM_ID : 0,
            'iblock_id' => defined('PRODUCTS_IBLOCK_ID') ? (int)PRODUCTS_IBLOCK_ID : 0,
        ),
        'service' => array(
            'form_id' => defined('ORDER_FORM_ID') ? (int)ORDER_FORM_ID : 0,
            'iblock_id' => defined('SERVICES_IBLOCK_ID') ? (int)SERVICES_IBLOCK_ID : 0,
        ),
    );

    $contextType = isset($_POST['SPORINA_FORM_CONTEXT_TYPE']) ? (string)$_POST['SPORINA_FORM_CONTEXT_TYPE'] : '';
    $elementId = isset($_POST['SPORINA_FORM_CONTEXT_ID']) ? (int)$_POST['SPORINA_FORM_CONTEXT_ID'] : 0;

    if (!isset($contexts[$contextType]) || $elementId <= 0) {
        sporinaLogFormResultEvent('skipped_invalid_context');
        return;
    }

    $context = $contexts[$contextType];
    if ($context['form_id'] !== $webFormId || $context['iblock_id'] <= 0) {
        sporinaLogFormResultEvent('skipped_form_or_iblock_mismatch', array('iblock_id' => $context['iblock_id']));
        return;
    }

    $element = CIBlockElement::GetList(
        array(),
        array(
            'ID' => $elementId,
            'IBLOCK_ID' => $context['iblock_id'],
            'ACTIVE' => 'Y',
        ),
        false,
        false,
        array('ID', 'NAME')
    )->Fetch();

    if (!$element) {
        sporinaLogFormResultEvent('skipped_element_not_found', array('element_id' => $elementId));
        return;
    }

    $orderAnswer = sporinaGetFormAnswerByFieldSid($webFormId, 'ORDER');
    if (!$orderAnswer) {
        sporinaLogFormResultEvent('skipped_order_field_not_found');
        return;
    }

    $arValues['form_' . $orderAnswer['FIELD_TYPE'] . '_' . $orderAnswer['ID']] = $element['NAME'];
    sporinaLogFormResultEvent('order_value_assigned', array('answer_id' => (int)$orderAnswer['ID']));
}

function sporinaGetFormAnswerByFieldSid($formId, $fieldSid)
{
    $by = 's_id';
    $order = 'asc';
    $isFiltered = false;
    $field = CFormField::GetList(
        $formId,
        'ALL',
        $by,
        $order,
        array('SID' => $fieldSid, 'SID_EXACT_MATCH' => 'Y'),
        $isFiltered
    )->Fetch();

    if (!$field) {
        return false;
    }

    $answer = CFormAnswer::GetList($field['ID'], $by, $order, array(), $isFiltered)->Fetch();

    return $answer ?: false;
}

AddEventHandler('form', 'onBeforeResultAdd', 'sporinaOnBeforeFormResultAdd');

function sporinaOnAfterFormResultAdd($webFormId, $resultId)
{
    $formIds = array_filter(array(
        defined('BUY_FORM_ID') ? (int)BUY_FORM_ID : 0,
        defined('ORDER_FORM_ID') ? (int)ORDER_FORM_ID : 0,
    ));

    if (in_array((int)$webFormId, $formIds, true)) {
        sporinaLogFormResultEvent('onAfterResultAdd', array(
            'form_id' => (int)$webFormId,
            'result_id' => (int)$resultId,
        ));
    }
}

AddEventHandler('form', 'onAfterResultAdd', 'sporinaOnAfterFormResultAdd');
