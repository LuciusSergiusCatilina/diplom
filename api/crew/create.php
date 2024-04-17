<?php
 
include_once '../config/database.php';
include_once '../objects/crew.php'; // Изменено на crew.php
 
$database = new Database();
$db = $database->getConnection();
 
$crew = new Crew($db); // Изменено на Crew
 
// Предполагается, что данные для создания экипажа получены из формы или другого источника
$crew->id_crew = $_POST['id_crew'];
$crew->id_driver = $_POST['id_driver'];
$crew->id_doctor = $_POST['id_doctor'];
if ($_POST['id_paramedic'] == ''){
    $crew->id_paramedic = null;
}
else {
    $crew->id_paramedic = $_POST['id_paramedic'];
}
$crew->id_orderly = $_POST['id_orderly'];
  
if ($crew->create()) {
     $crew_arr = array(
         "status" => true,
         "message" => "Экипаж успешно добавлен",
         "id_crew" => $crew->id_crew,
         "id_driver" => $crew->id_driver,
         "id_doctor" => $crew->id_doctor,
         "id_paramedic" => $crew->id_paramedic,
         "id_orderly" => $crew->id_orderly
     );
} else {
     $crew_arr = array(
         "status" => false,
         "message" => "Ошибка при добавлении экипажа"
     );
}
print_r(json_encode($crew_arr));
