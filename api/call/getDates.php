<?php
include_once '../config/database.php';
include_once '../objects/call.php';

$database = new Database();
$db = $database->getConnection();

$call = new Call($db);
$dates = $call->getDates();

echo json_encode($dates);
?>