<?php
 
include_once '../config/database.php';
include_once '../objects/call.php'; 
$database = new Database();
$db = $database->getConnection();
 
$call = new Call($db); 
 
$call->id_crew = ($_POST['id_crew'] == '') ? null : $_POST['id_crew'];
$call->id_patient = ($_POST['id_patient'] == '') ? null : $_POST['id_patient'];
$call->adress = $_POST['adress'];
$call->number = $_POST['number'];
$call->type = $_POST['type'];

if ($call->create()) {
     $call_arr = array(
         "status" => true,
         "message" => "Вызов успешно добавлен",
         "id_crew" => $call->id_crew,
         "id_patient" => $call->id_patient,
         "adress" => $call->adress,
         "number" => $call->number,
         "type" => $call->type
     );
} else {
     $call_arr = array(
         "status" => false,
         "message" => "Ошибка при добавлении вызова"
     );
}
print_r(json_encode($call_arr));
