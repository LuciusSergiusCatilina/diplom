<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/crew.php'; // Изменено на crew.php

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare crew object
$crew = new Crew($db); // Изменено на Crew

// set ID property of crew to be edited
$crew->id_crew = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of crew to be edited
$stmt = $crew->read_single($crew->id_crew);

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $crew_arr=array(
        "id_crew" => $row['id_crew'],
        "id_driver" => $row['id_driver'],
        "id_doctor" => $row['id_doctor'],
        "id_paramedic" => $row['id_paramedic'],
        "id_orderly" => $row['id_orderly']
    );
}
// make it json format
print_r(json_encode($crew_arr));
?>
