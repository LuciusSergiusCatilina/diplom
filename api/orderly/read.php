<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/orderly.php'; // Убедитесь, что путь к файлу класса Orderly правильный

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare orderly object
$orderly = new Orderly($db);

// query orderly
$stmt = $orderly->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // orderlies array
    $orderlies_arr=array();
    $orderlies_arr["orderlies"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $orderly_item=array(
            "id_orderly" => $id_orderly,
            "name" => $name,
            "number" => $number // Используйте правильное имя поля
        );
        array_push($orderlies_arr["orderlies"], $orderly_item);
    }
 
    echo json_encode($orderlies_arr["orderlies"]);
}
else{
    echo json_encode(array());
}
?>
