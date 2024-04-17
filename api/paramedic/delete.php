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
$paramedic->id_paramedic = $_POST['id']; // Изменено на 'id_paramedic'
 
// remove the paramedic
if($paramedic->delete()){
    $paramedic_arr=array(
        "status" => true,
        "message" => "Парамедик успешно удалён!"
    );
}
else{
    $paramedic_arr=array(
        "status" => false,
        "message" => "Парамедик не может быть удалён!"
    );
}
print_r(json_encode($paramedic_arr));
?>
