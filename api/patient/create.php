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
$patient->name = $_POST['name'];
$patient->number = $_POST['number']; // Предполагается, что 'number' соответствует 'phone' в вашей форме
$patient->adress = $_POST['adress']; // Добавлено свойство adress

// create the patient
if($patient->create()){
    $patient_arr=array(
        "status" => true,
        "message" => "Пациент успешно добавлен",
        "id_patient" => $patient->id_patient,
        "name" => $patient->name,
        "number" => $patient->number,
        "adress" => $patient->adress // Изменено на 'adress'
    );
}
else{
    $patient_arr=array(
        "status" => false,
        "message" => "Пациент с такими данными уже существует"
    );
}
print_r(json_encode($patient_arr));
?>
