<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/crew.php'; // Изменено на crew.php

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare crew object
$crew = new Crew($db); // Изменено на Crew

// query crew
$stmt = $crew->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // crews array
    $crews_arr=array();
    $crews_arr["crews"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $crew_item=array(
            "id_crew" => $id_crew,
            "driver_name" => $driver_name,
            "doctor_name" => $doctor_name,
            "paramedic_name" => $paramedic_name,
            "orderly_name" =>  $orderly_name,
            "is_available" => $is_available
        );
        array_push($crews_arr["crews"], $crew_item);
    }
 
    echo json_encode($crews_arr["crews"]);
}
else{
    echo json_encode(array());
}
?>
