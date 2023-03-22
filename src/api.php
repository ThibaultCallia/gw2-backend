<?php
require_once "includes/Db.class.php";

$response = new StdClass;

require_once "api/lists.inc.php";
require_once "api/products.inc.php";

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");



print json_encode($response);
exit;
