<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/driver.php'; // Изменено на driver.php
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare driver object
$driver = new Driver($db); // Изменено на Driver

// set ID property of driver to be edited
$driver->id_drivers = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of driver to be edited
$stmt = $driver->read_single();

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $driver_arr=array(
        "id_drivers" => $row['id_drivers'],
        "name" => $row['name'],
        "phone" => $row['phone'] // Изменено на 'phone'
    );
}
// make it json format
print_r(json_encode($driver_arr));
?>
