<?php
require_once "includes/ProductList.class.php";
require_once "includes/helpers.inc.php";


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


$args = $_REQUEST;
$endpoint = $args['endpoint'];
$endpoints = ["lists", "list"];
if (!in_array($endpoint, $endpoints)) {
    return;
}
// TODO: documentation

switch ($endpoint) {
    case 'lists':
        // Ensure that the request method is GET
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
            case 'POST':
                $db = new Db();
                $list = new ProductList($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();
                $list->add($params);
                var_dump($params);
                // $created = $lists->add($_POST);

                $response->status = 'success';
                $response->message = 'List added';
                http_response_code(201);
                break;
            case 'DELETE':
                // TODO: validation :)
                $db = new Db();
                $list = new ProductList($db);

                $list->delete($args['id']);
                $response->status = 'success';
                $response->message = $args['id'] . " has been deleted";
                break;

            default:
                // Ensure that the 'id' parameter is set and is a positive integer
                if (!isset($args['id']) || !ctype_digit($args['id']) || $args['id'] <= 0) {
                    $response->status = 'error';
                    $response->message = 'Invalid ID parameter';
                    http_response_code(404);
                    return;
                }

                $db = new Db();
                $lists = new ProductList($db);
                $list = $lists->getById($args['id']);

                // Check if the list exists
                if (!$list) {
                    $response->status = 'error';
                    $response->message = 'List not found';
                    http_response_code(404);
                    return;
                }

                $response->status = 'success';

                $response->lists = $list;
                break;
        }

    default:

        break;
}
