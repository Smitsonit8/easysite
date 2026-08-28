<?php

function sporinaOnBeforeFormResultAdd($webFormId, &$arFields, &$arValues)
{
    $webFormId = (int)$webFormId;
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
        return;
    }

    $context = $contexts[$contextType];
    if ($context['form_id'] !== $webFormId || $context['iblock_id'] <= 0) {
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
        return;
    }

    $orderAnswer = sporinaGetFormAnswerByFieldSid($webFormId, 'ORDER');
    if (!$orderAnswer) {
        return;
    }

    $arValues['form_' . $orderAnswer['FIELD_TYPE'] . '_' . $orderAnswer['ID']] = $element['NAME'];
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
