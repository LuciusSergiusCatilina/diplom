<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/driver.php'; // Изменено на driver.php

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare driver object
$driver = new Driver($db); // Изменено на Driver
 
// set driver property values
$driver->id_drivers = $_POST['id']; // Изменено на 'id_drivers'
 
// remove the driver
if($driver->delete()){
    $driver_arr=array(
        "status" => true,
        "message" => "Водитель успешно удалён!"
    );
}
else{
    $driver_arr=array(
        "status" => false,
        "message" => "Водитель не может быть удалён!"
    );
}
print_r(json_encode($driver_arr));
?>
