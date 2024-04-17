<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/orderly.php'; // Убедитесь, что путь к файлу класса Orderly правильный
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare orderly object
$orderly = new Orderly($db);
 
// set orderly property values
$orderly->id_orderly = $_POST['id'];
$orderly->name = $_POST['name'];
$orderly->number = $_POST['number']; // Предполагается, что 'number' соответствует 'number' в вашей форме

// update the orderly
if($orderly->update()){
    $orderly_arr=array(
        "status" => true,
        "message" => "Данные изменены!"
    );
}
else{
    $orderly_arr=array(
        "status" => false,
        "message" => "Данные не получилось изменить!"
    );
}
print_r(json_encode($orderly_arr));
?>
