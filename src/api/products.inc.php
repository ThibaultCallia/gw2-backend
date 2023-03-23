<?php
require_once "includes/Product.class.php";
require_once "includes/helpers.inc.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$allowedEndpoints = ["products", "product"];

if (!in_array($endpoint, $allowedEndpoints)) {
    return;
}

switch ($endpoint) {

    case 'products':
        $db = new Db();
        $products = new Product($db);
        if (!isset($args['id']) || empty($args['id'])) {
            $response->error = "failed";
            $response->message = "need list id";
        } else {
            $response->products = $products->getAllByList($args['id']);
            $response->status = 'success';
        }
        break;
    case 'product':
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                $response->status = 'success';
                http_response_code(200);
                break;
            case 'GET':

                $db = new Db();
                $product = new Product($db);
                $response->product = $product->getById($args['id']);
                $response->status = 'success';
                break;
            case 'POST':

                $db = new Db();
                $product = new Product($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();
                // query validation
                if (queryValidation($params)) {
                    $response->status = 'error';
                    $response->message = 'Invalid data';
                    $response->errorType = queryValidation($params);
                    return;
                }
                $product->add($params);
                $response->status = 'success';
                $response->message = 'product added';
                break;

            case 'DELETE':
                $db = new Db();
                $product = new Product($db);

                $product->delete($args['id']);
                $response->status = 'success';
                $response->message = $args['id'] . " has been deleted";
                break;
            default:
                $response->status = 'failed';
                $response->message = 'Invalid request method';
                break;
        }
        break;
    default:
        break;
}
