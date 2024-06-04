<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/crew.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare crew object
$crew = new Crew($db);

// get id and availability from POST
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
  isset($data->id_crew) &&
  isset($data->is_available)
){
    // set crew property values
    $crew->id_crew = $data->id_crew;
    $crew->is_available = $data->is_available;

    // update the crew
    if($crew->update_status()){
        // set response code - 200 ok
        http_response_code(200);

        // tell the user
        echo json_encode(array("status" => true, "message" => "Статус готовности бригады изменен!"));
    }

    // if unable to update the crew, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("status" => false, "message" => "Не удалось изменить статус готовности бригады!"));
    }
}

// tell the user data is incomplete
else{
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("status" => false, "message" => "Не хватает данных для изменения статуса готовности бригады."));
}
?>
