<?php
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/call.php'; // Предполагаю, что имя файла и класса - call.php и Call соответственно

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare call object
$call = new Call($db);
 
// set call property values
$call->id_call = $_POST['id']; // Предполагаю, что 'id' — это идентификатор вызова, который мы хотим удалить
 
// remove the call
if($call->delete()){
    $call_arr=array(
        "status" => true,
        "message" => "Вызов успешно удалён!"
    );
}
else{
    $call_arr=array(
        "status" => false,
        "message" => "Вызов не может быть удалён!"
    );
}
print_r(json_encode($call_arr));
?>
