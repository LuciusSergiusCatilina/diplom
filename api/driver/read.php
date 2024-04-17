<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/driver.php'; // Изменено на driver.php
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare driver object
$driver = new Driver($db); // Изменено на Driver
 
// query driver
$stmt = $driver->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // drivers array
    $drivers_arr=array();
    $drivers_arr["drivers"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $driver_item=array(
            "id_drivers" => $id_drivers,
            "name" => $name,
            "phone" => $phone // Изменено на 'phone'
        );
        array_push($drivers_arr["drivers"], $driver_item);
    }
 
    echo json_encode($drivers_arr["drivers"]);
}
else{
    echo json_encode(array());
}
?>
