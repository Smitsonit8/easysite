<?php

$root = dirname(__DIR__).'/install/wizards/sporina/easy_site/site/templates/sporina_easy_site/components/bitrix/news/staff';
$news = file_get_contents($root.'/news.php');
$parameters = file_get_contents($root.'/.parameters.php');

foreach (array('blocks.1', 'list.1', 'bitrix:news.list') as $expected) {
    if (strpos($news, $expected) === false && strpos($parameters, $expected) === false) {
        throw new RuntimeException('Missing contract: '.$expected);
    }
}

foreach (array('intec', 'FORM_ASK', 'PROJECTS_', 'REVIEWS_') as $forbidden) {
    if (stripos($news, $forbidden) !== false || stripos($parameters, $forbidden) !== false) {
        throw new RuntimeException('Forbidden feature: '.$forbidden);
    }
}
