<?php
include_once '../config/database.php';
include_once '../objects/call.php';

$database = new Database();
$db = $database->getConnection();

$call = new Call($db);
$count = $call->getCount();

$response = array("count" => $count);

echo json_encode($count);
?>