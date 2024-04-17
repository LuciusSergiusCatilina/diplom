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
$driver->id_drivers = $_POST['id'];
$driver->name = $_POST['name'];
$driver->phone = $_POST['phone']; // Предполагается, что 'phone' соответствует 'phone' в вашей форме

// update the driver
if($driver->update()){
    $driver_arr=array(
        "status" => true,
        "message" => "Данные изменены!"
    );
}
else{
    $driver_arr=array(
        "status" => false,
        "message" => "Данные не получилось изменить!"
    );
}
print_r(json_encode($driver_arr));
?>
