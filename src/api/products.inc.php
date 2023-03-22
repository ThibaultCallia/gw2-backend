<?php
require_once "includes/Product.class.php";
require_once "includes/helpers.inc.php";

$args = $_REQUEST;
$endpoint = $args['endpoint'];
$allowedEndpoints = ["products", "product"];

// TODO: documentation

if (!in_array($endpoint, $allowedEndpoints)) {
    return;
}

switch ($endpoint) {

    case 'products':
        // TODO: validation :O

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
                // TODO: validation ;)
                $db = new Db();
                $product = new Product($db);
                $response->product = $product->getById($args['id']);
                $response->status = 'success';
                break;
            case 'POST':
                // TODO: validation :D
                $db = new Db();
                $product = new Product($db);

                // get POST data in JSON format
                $params = jsonDecodeInput();
                $product->add($params);

                // TODO: add api call to get list name
                $listName = $params['list_id'];

                $response->status = 'success';
                $response->message = $params['name'] . " has been added to " . $listName;
                break;

            case 'DELETE':
                // TODO: validation :)
                $db = new Db();
                $product = new Product($db);

                $product->delete($args['id']);
                $response->status = 'success';
                $response->message = $args['id'] . " has been deleted";
                break;
            default:
                // TODO: validation :P
        }
        break;
    default:
        break;
}
