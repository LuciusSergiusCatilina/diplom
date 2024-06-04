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
$crew->is_available = $_POST['is_available'];

// update the crew
if($crew->update_status()){
    $crew_arr=array(
        "status" => true,
        "message" => "Статус готовности бригады изменен!"
    );
}
else{
    $crew_arr=array(
        "status" => false,
        "message" => "Не удалось изменить статус готовности бригады!"
    );
}
print_r(json_encode($crew_arr));
?>
