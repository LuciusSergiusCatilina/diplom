<?php
include_once '../config/database.php';
include_once '../objects/patient.php';

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);
$count = $patient->getCount();

$response = array("count" => $count);

echo json_encode($count);
?>