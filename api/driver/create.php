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
$driver->name = $_POST['name'];
$phoneNumber = $_POST['phone'];
if (str_contains($phoneNumber, "+")){
    $driver->phone = substr($phoneNumber,1);
}
else {
    $driver->phone = $_POST['phone'];
}

// create the driver
if($driver->create()){
    $driver_arr=array(
        "status" => true,
        "message" => "Водитель успешно добавлен",
        "id_drivers" => $driver->id_drivers,
        "name" => $driver->name,
        "phone" => $driver->phone
    );
}
else{
    $driver_arr=array(
        "status" => false,
        "message" => "Водитель с такими данными уже существует"
    );
}
print_r(json_encode($driver_arr));
?>
