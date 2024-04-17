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
$doctor->id_doctor = $_POST['id']; // Изменено на 'id_doctor'
 
// remove the doctor
if($doctor->delete()){
    $doctor_arr=array(
        "status" => true,
        "message" => "Доктор успешно удалён!"
    );
}
else{
    $doctor_arr=array(
        "status" => false,
        "message" => "Доктор не может быть удалён!"
    );
}
print_r(json_encode($doctor_arr));
?>
