<?php

require_once 'common.inc.php';

use smtech\StMarksSmarty\StMarksSmarty;

$smarty = new StMarksSmarty(__DIR__ . '/templates');
$smarty->setFramed(true);
$smarty->addStylesheet('css/index.css');
$smarty->addScript('js/index.js');

$smarty->assign([
    'title' => $search->getName(),
    'formMethod' => 'GET',
    'search' => $search,
    'domains' => $search->getDomains()
]);

if (!empty($_REQUEST['query'])) {
    $smarty->assign([
        'query' => $_REQUEST['query'],
        'results' => $search->search($_REQUEST['query'])
    ]);
}

$smarty->display('home.tpl');
