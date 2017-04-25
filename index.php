<?php

require_once 'common.inc.php';

use smtech\StMarksSmarty\StMarksSmarty;
use smtech\StMarksSearch\SearchResult;

$smarty = new StMarksSmarty(__DIR__ . '/templates');
$smarty->setFramed(true);
$smarty->addStylesheet('css/index.css');
$smarty->addScript('js/index.js');

$smarty->assign([
    'title' => $config->toString('/config/engine/name'),
    'formMethod' => 'GET',
    'searchDomainCount' => count($search),
]);

if (!empty($_REQUEST['query'])) {
    $results = [];
    if (is_array($search)) {
        foreach ($search as $domain) {
            $results = array_merge($results, $domain->search($_REQUEST['query']));
        }
        SearchResult::sort($results);
    }
    $smarty->assign([
        'query' => $_REQUEST['query'],
        'results' => $results
    ]);
}

$smarty->display('home.tpl');
