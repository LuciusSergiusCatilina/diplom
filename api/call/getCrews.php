<?php
include_once '../config/database.php';
include_once '../objects/call.php';

$database = new Database();
$db = $database->getConnection();

$call = new Call($db);
$crews = $call->getCrews();

echo json_encode($crews);
?>