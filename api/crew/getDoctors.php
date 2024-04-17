<?php
include_once '../config/database.php';
include_once '../objects/crew.php';

$database = new Database();
$db = $database->getConnection();

$crew = new Crew($db);
$drivers = $crew->getDoctors();

echo json_encode($drivers);
?>