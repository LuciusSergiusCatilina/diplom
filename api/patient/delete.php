<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/patient.php'; // Изменено на patient.php

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare patient object
$patient = new Patient($db); // Изменено на Patient
 
// set patient property values
$patient->id_patient = $_POST['id']; // Изменено на 'id_patient'
 
// remove the patient
if($patient->delete()){
    $patient_arr=array(
        "status" => true,
        "message" => "Пациент успешно удалён!"
    );
}
else{
    $patient_arr=array(
        "status" => false,
        "message" => "Пациент не может быть удалён!"
    );
}
print_r(json_encode($patient_arr));
?>
