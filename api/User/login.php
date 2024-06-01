<?php
session_start();
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$response = ["success" => false, "message" => "Неправильный логин или пароль"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    if (isset($login) && isset($password)) {
        if ($user->authenticate($login, $password)) {
            $response["success"] = true;
            $response["message"] = "Добро пожаловать!";
        }
    }
    echo json_encode($response);
}
