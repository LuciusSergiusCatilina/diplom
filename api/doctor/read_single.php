<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/doctor.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare doctor object
$doctor = new Doctor($db);

// set ID property of doctor to be edited
$doctor->id_doctor = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of doctor to be edited
$stmt = $doctor->read_single();

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $doctor_arr=array(
        "id_doctor" => $row['id_doctor'],
        "name" => $row['name'],
        "number" => $row['number'],
        "specialization" => $row['specialization']
    );
}
// make it json format
print_r(json_encode($doctor_arr));
?>
