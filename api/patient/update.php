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
$patient->id_patient = $_POST['id'];
$patient->name = $_POST['name'];
$phoneNumber = $_POST['number'];
if (str_contains($phoneNumber, "+")){
    $patient->number = substr($phoneNumber,1);
}
else {
    $patient->number = $_POST['number'];
}
$patient->adress = $_POST['adress']; // Добавлено свойство adress
 
// update the patient
if($patient->update()){
    $patient_arr=array(
        "status" => true,
        "message" => "Данные изменены!"
    );
}
else{
    $patient_arr=array(
        "status" => false,
        "message" => "Данные не получилось изменить!"
    );
}
print_r(json_encode($patient_arr));
?>
