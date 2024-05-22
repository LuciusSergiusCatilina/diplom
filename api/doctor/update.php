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
$phoneNumber = $_POST['number'];

if (str_contains($phoneNumber, "+")){
    $doctor->number = substr($phoneNumber,1);
}
else {
    $doctor->number = $_POST['number'];
}

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
