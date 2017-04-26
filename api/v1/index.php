<?php

require_once __DIR__ . '/../../common.inc.php';

/* allow particular hosts to access this API (e.g. * -- a dangerous setting that allows _everyone_ to access this!) */
header('Access-Control-Allow-Origin: *');

/*
 * parse the query out of the request string, set the action and id (if
 * present) from first two tokens of end point
 */
$verb = strtoupper($_SERVER['REQUEST_METHOD']);
$endpoint = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$action = strtolower(array_shift($endpoint));
$id = filter_var(array_shift($endpoint), FILTER_SANITIZE_NUMBER_INT);
$parameters = json_decode(file_get_contents('php://input'), true);
if (empty($parameters)) {
    parse_str($_SERVER['QUERY_STRING'], $parameters);
}

switch ($action) {
    case 'search':
        $results = [];
        if (array_key_exists($id, $search)) {
            $results = $search[$id]->search($parameters['query']);
        }
        echo json_encode($results);
        exit;
    case 'domains':
        echo json_encode(count($search));
        exit;
    default:
        http_response_code(404);
        die("Unknown endpoint: $endpoint");
}
