<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/crew.php'; // Изменено на crew.php

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare crew object
$crew = new Crew($db); // Изменено на Crew
 
// set crew property values
$crew->id_crew = $_POST['id']; // Изменено на 'id_crew'
 
// remove the crew
if($crew->delete()){
    $crew_arr=array(
        "status" => true,
        "message" => "Экипаж успешно удалён!"
    );
}
else{
    $crew_arr=array(
        "status" => false,
        "message" => "Экипаж не может быть удалён!"
    );
}
print_r(json_encode($crew_arr));
?>
