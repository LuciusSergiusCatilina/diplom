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
$doctor->name = $_POST['name'];
$doctor->number = $_POST['number']; // Предполагается, что 'number' соответствует 'phone' в вашей форме
$doctor->specialization = $_POST['specialization']; // Предполагается, что 'specialization' соответствует 'specialist' в вашей форме

// create the doctor
if($doctor->create()){
    $doctor_arr=array(
        "status" => true,
        "message" => "Врач успешно добавлен",
        "id_doctor" => $doctor->id_doctor,
        "name" => $doctor->name,
        "number" => $doctor->number, // Изменено на 'number'
        "specialization" => $doctor->specialization // Изменено на 'specialization'
    );
}
else{
    $doctor_arr=array(
        "status" => false,
        "message" => "Врач с такими данными уже существует"
    );
}
print_r(json_encode($doctor_arr));
?>
