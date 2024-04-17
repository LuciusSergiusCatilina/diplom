<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/paramedic.php'; // Изменено на paramedic.php

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare paramedic object
$paramedic = new Paramedic($db); // Изменено на Paramedic
 
// set paramedic property values
$paramedic->name = $_POST['name'];
$paramedic->number = $_POST['number']; // Предполагается, что 'number' соответствует 'phone' в вашей форме

// create the paramedic
if($paramedic->create()){
    $paramedic_arr=array(
        "status" => true,
        "message" => "Парамедик успешно добавлен",
        "id_paramedic" => $paramedic->id_paramedic,
        "name" => $paramedic->name,
        "number" => $paramedic->number
    );
}
else{
    $paramedic_arr=array(
        "status" => false,
        "message" => "Парамедик с такими данными уже существует"
    );
}
print_r(json_encode($paramedic_arr));
?>
