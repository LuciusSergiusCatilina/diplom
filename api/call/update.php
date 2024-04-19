<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/call.php'; // Изменено на call.php
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare call object
$call = new Call($db); // Создание объекта Call
 
// set call property values
$call->id_call = $_POST['id_call'];
$call->id_crew = ($_POST['id_crew'] == '') ? null : $_POST['id_crew'];
$call->id_patient = ($_POST['id_patient'] == '') ? null : $_POST['id_patient'];
$call->adress = $_POST['adress']; // Предполагается, что adress соответствует адресу вызова
$call->number = $_POST['number']; // Предполагается, что number соответствует номеру вызова
$call->type = $_POST['type']; // Предполагается, что type соответствует типу вызова

// update the call
if($call->update()){
    $call_arr=array(
        "status" => true,
        "message" => "Данные вызова обновлены!"
    );
}
else{
    $call_arr=array(
        "status" => false,
        "message" => "Не удалось обновить данные вызова!"
    );
}
print_r(json_encode($call_arr));
?>
