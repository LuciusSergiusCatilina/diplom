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
// Предполагается, что в вашей форме или запросе есть параметр 'id', который уникально идентифицирует запись
// Например, если вы используете 'id_orderly' для идентификации, код будет выглядеть так:
$orderly->id_orderly = $_POST['id']; // Используйте правильное имя поля

// remove the orderly
if($orderly->delete()){
    $orderly_arr=array(
        "status" => true,
        "message" => "Запись успешно удалена!"
    );
}
else{
    $orderly_arr=array(
        "status" => false,
        "message" => "Запись не может быть удалена!"
    );
}
print_r(json_encode($orderly_arr));
?>
