<?php
require_once "includes/Db.class.php";

$response = new StdClass;

require_once "api/lists.inc.php";
require_once "api/products.inc.php";


header('Content-Type: application/json; charset=utf-8');
print json_encode($response);
exit;
