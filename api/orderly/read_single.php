<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/orderly.php'; // Убедитесь, что путь к файлу класса Orderly правильный

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare orderly object
$orderly = new Orderly($db);

// set ID property of orderly to be edited
// Предполагается, что в вашем запросе есть параметр 'id', который уникально идентифицирует запись
// Например, если вы используете 'id_orderly' для идентификации, код будет выглядеть так:
$orderly->id_orderly = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of orderly to be edited
$stmt = $orderly->read_single();

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $orderly_arr=array(
        "id_orderly" => $row['id_orderly'],
        "name" => $row['name'],
        "number" => $row['number'] // Используйте правильное имя поля
    );
}
// make it json format
print_r(json_encode($orderly_arr));
?>
