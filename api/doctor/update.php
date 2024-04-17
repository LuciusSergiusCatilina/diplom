<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/doctor.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare doctor object
$doctor = new Doctor($db);
 
// set doctor property values
$doctor->id_doctor = $_POST['id'];
$doctor->name = $_POST['name'];
$doctor->number = $_POST['number']; // Assuming 'number' is the new field for phone number
$doctor->specialization = $_POST['specialization']; // Assuming 'specialization' is the new field for specialist
 
// create the doctor
if($doctor->update()){
    $doctor_arr=array(
        "status" => true,
        "message" => "Данные изменены!"
    );
}
else{
    $doctor_arr=array(
        "status" => false,
        "message" => "Данные не получилось изменить!"
    );
}
print_r(json_encode($doctor_arr));
?>
