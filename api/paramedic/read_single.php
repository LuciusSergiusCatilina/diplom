<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/paramedic.php'; // Изменено на paramedic.php
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare paramedic object
$paramedic = new Paramedic($db); // Изменено на Paramedic

// set ID property of paramedic to be edited
$paramedic->id_paramedic = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of paramedic to be edited
$stmt = $paramedic->read_single();

if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $paramedic_arr=array(
        "id_paramedic" => $row['id_paramedic'],
        "name" => $row['name'],
        "number" => $row['number']
    );
}
// make it json format
print_r(json_encode($paramedic_arr));
?>
