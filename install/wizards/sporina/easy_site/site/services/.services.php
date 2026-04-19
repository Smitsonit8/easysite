<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Определяем сервисы для мастера установки
$arServices = array(
    "main" => array(
        "NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
        "STAGES" => array(
            "site_create.php", // Создание сайта
            "files.php",       // Копирование файлов публичной части
            "template.php",    // Установка шаблона
            "theme.php",       // Установка темы
            "menu.php",        // Создание меню
            "create_forms.php", // Создание веб-форм
        ),
    ),
    "iblock" => array(
        "NAME" => GetMessage("SERVICE_IBLOCK"),
        "STAGES" => array(
            "types.php",       // Создание типов инфоблоков
            "import.php",      // Импорт инфоблоков из XML
        ),
    ),
    /*
    "forms" => array(
        "NAME" => GetMessage("SERVICE_FORMS"),
        "STAGES" => array(
            "create_forms.php", // Создание веб-форм
        ),
    ),*/
);

?>