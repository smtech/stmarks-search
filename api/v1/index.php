<?php

require_once __DIR__ . '/../../common.inc.php';

/* allow particular hosts to access this API (e.g. * -- a dangerous setting that allows _everyone_ to access this!) */
header('Access-Control-Allow-Origin: *');

/*
 * parse the query out of the request string, set the action and id (if
 * present) from first two tokens of end point
 */
$endpoint = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$action = strtolower(array_shift($endpoint));
$id = filter_var(array_shift($endpoint), FILTER_SANITIZE_NUMBER_INT);

switch ($action) {
    case 'search':
        echo json_encode($search[$id]->search($_GET['query']));
        exit;
    case 'domains':
        echo json_encode(count($search));
        exit;
    default:
        http_response_code(404);
        die("Unknown endpoint: $endpoint");
}
