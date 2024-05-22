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
$paramedic->id_paramedic = $_POST['id'];
$paramedic->name = $_POST['name'];
$phoneNumber = $_POST['number'];
if (str_contains($phoneNumber, "+")){
    $paramedic->number = substr($phoneNumber,1);
}
else {
    $paramedic->number = $_POST['number'];
}

// update the paramedic
if($paramedic->update()){
    $paramedic_arr=array(
        "status" => true,
        "message" => "Данные изменены!"
    );
}
else{
    $paramedic_arr=array(
        "status" => false,
        "message" => "Данные не получилось изменить!"
    );
}
print_r(json_encode($paramedic_arr));
?>
