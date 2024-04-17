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
$crew->id_crew = $_POST['id'];
$crew->id_driver = $_POST['id_driver'];
$crew->id_doctor = $_POST['id_doctor'];
$crew->id_paramedic = $_POST['id_paramedic'];
$crew->id_orderly = $_POST['id_orderly'];

// update the crew
if($crew->update()){
    $crew_arr=array(
        "status" => true,
        "message" => "Данные экипажа обновлены!"
    );
}
else{
    $crew_arr=array(
        "status" => false,
        "message" => "Не удалось обновить данные экипажа!"
    );
}
print_r(json_encode($crew_arr));
?>
