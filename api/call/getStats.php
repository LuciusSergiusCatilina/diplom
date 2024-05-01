<?php
include_once '../config/database.php';
include_once '../objects/call.php';

$database = new Database();
$db = $database->getConnection();

$call = new Call($db);
$procent = $call->getStats();

echo json_encode($procent);
?>