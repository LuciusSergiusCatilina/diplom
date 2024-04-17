<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/call.php'; // Изменено на call.php

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare call object
$call = new Call($db); // Создание объекта Call

// query call
$stmt = $call->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // calls array
    $calls_arr=array();
    $calls_arr["calls"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // Извлечение данных из массива $row
        $call_item=array(
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
        array_push($calls_arr["calls"], $call_item);
    }
 
    echo json_encode($calls_arr["calls"]);
}
else{
    echo json_encode(array());
}
?>