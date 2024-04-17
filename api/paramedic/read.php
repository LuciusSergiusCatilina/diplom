<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/paramedic.php'; // Изменено на paramedic.php
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare paramedic object
$paramedic = new Paramedic($db); // Изменено на Paramedic
 
// query paramedic
$stmt = $paramedic->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // paramedics array
    $paramedics_arr=array();
    $paramedics_arr["paramedics"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $paramedic_item=array(
            "id_paramedic" => $id_paramedic,
            "name" => $name,
            "number" => $number
        );
        array_push($paramedics_arr["paramedics"], $paramedic_item);
    }
 
    echo json_encode($paramedics_arr["paramedics"]);
}
else{
    echo json_encode(array());
}
?>
