<?php
 
include_once '../config/database.php';
include_once '../objects/call.php'; // Изменено на call.php
$database = new Database();
$db = $database->getConnection();
 
$call = new Call($db); // Изменено на Call
 
// Предполагается, что данные для создания вызова получены из формы или другого источника
//$call->id_call = $_POST['id_call'];
//$call->id_user = $_POST['id_user'];
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
