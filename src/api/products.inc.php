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
        $response->test = 'products';
        $db = new Db();
        $products = new Product($db);
        $response->products = $products->getAll();
        $response->status = 'success';
        break;
    case 'product':
        switch ($_SERVER['REQUEST_METHOD']) {
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
                $response->message = $params['title'] . " has been added to " . $listName;
                break;
                // case 'PATCH':
                //     // TODO: validation :)
                //     $db = new Db();
                //     $todos = new Todos($db);

                //     // get PATCH data in JSON format
                //     $params = jsonDecodeInput();
                //     $todos->update($args['id'], $params);

                //     $response->status = 'success';
                //     $response->message = $params['title'] . " has been updated";
                //     break;
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
