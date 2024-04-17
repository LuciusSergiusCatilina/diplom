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
$orderly->name = $_POST['name'];
$orderly->number = $_POST['number']; // Убедитесь, что в вашей форме есть поле 'number'

// create the orderly
if($orderly->create()){
    $orderly_arr=array(
        "status" => true,
        "message" => "Запись успешно добавлена",
        "id_orderly" => $orderly->id_orderly, // Используйте правильное имя поля
        "name" => $orderly->name,
        "number" => $orderly->number // Используйте правильное имя поля
    );
}
else{
    $orderly_arr=array(
        "status" => false,
        "message" => "Запись с такими данными уже существует"
    );
}
print_r(json_encode($orderly_arr));
?>
