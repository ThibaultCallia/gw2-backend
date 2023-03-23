<?php
require_once "includes/ProductList.class.php";
require_once "includes/helpers.inc.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$endpoints = ["lists", "list"];
if (!in_array($endpoint, $endpoints)) {
    return;
}


switch ($endpoint) {
    case 'lists':

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $response->status = 'error';
            $response->message = 'Invalid request method';
            return;
        }
        $response->status = 'success';

        $db = new Db();
        $lists = new ProductList($db);
        $response->lists = $lists->getAll();
        break;

    case 'list':
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                $response->status = 'success';
                http_response_code(200);
                break;
            case 'POST':
                $db = new Db();
                $list = new ProductList($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();
                // query validation
                if (queryValidation($params)) {
                    $response->status = 'error';
                    $response->message = 'Invalid data';
                    $response->errorType = queryValidation($params);
                    return;
                }

                $list->add($params);
                $response->status = 'success';
                $response->message = 'List added';

                break;
            case 'DELETE':

                $db = new Db();
                $list = new ProductList($db);

                $list->delete($args['id']);
                $response->status = 'success';
                $response->message = $args['id'] . " has been deleted";
                break;

            default:
                $response->status = 'failed';
                $response->message = 'Invalid request method';
                break;
        }

    default:

        break;
}
