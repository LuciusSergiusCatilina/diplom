<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/patient.php'; // Изменено на patient.php
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare patient object
$patient = new Patient($db); // Изменено на Patient

// set ID property of patient to be edited
$patient->id_patient = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of patient to be edited
$stmt = $patient->read_single();

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $patient_arr=array(
        "id_patient" => $row['id_patient'],
        "name" => $row['name'],
        "number" => $row['number'],
        "adress" => $row['adress'] // Изменено на 'adress'
    );
}
// make it json format
print_r(json_encode($patient_arr));
?>
