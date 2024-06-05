<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php'; // Изменено на driver.php

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare driver object
$user = new User($db); // Изменено на Driver

// set ID property of driver to be edited
$user->id_user = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of driver to be edited
$stmt = $user->read_single();

if ($stmt->rowCount() > 0) {
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  // create array
  $user_arr = array(
    "id_user" => $row['id_user'],
    "name" => $row['name'],
    "photo" => $row['photo']
  );
}
print_r(json_encode($user_arr));

