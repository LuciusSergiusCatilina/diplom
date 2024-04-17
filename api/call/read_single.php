<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/call.php'; // Изменено на call.php

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare call object
$call = new Call($db); // Изменено на Call

// set ID property of call to be edited
$call->id_call = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of call to be edited
$stmt = $call->read_single($call->id_call);

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $call_arr=array(
        "id_call" => $row['id_call'],
        "id_user" => $row['id_user'],
        "id_crew" => $row['id_crew'],
        "id_patient" => $row['id_patient'],
        "adress" => $row['adress'],
        "time" => $row['time'],
        "number" => $row['number'],
        "type" => $row['type'],
        "user_name" => $row['user_name'],
        "patient_name"=> $row['patient_name']
    );
}
// make it json format
print_r(json_encode($call_arr));
?>