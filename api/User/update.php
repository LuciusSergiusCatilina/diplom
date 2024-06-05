<?php
session_start();

if ($_SESSION['user_id'] != $_POST['id']) {
  header("location:../notenoughpermission.php");
  exit;
}

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->id_user = $_POST['id'];
$user->name = $_POST['name'];

// Define the project root relative to the current script directory
$project_root = realpath(__DIR__ . '/../../');

// Handle file upload
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
  // Use project root to create the target directory path
  $target_dir = $project_root . "/dist/img/";

  if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0777, true)) {
      echo json_encode(array("message" => "Failed to create directory."));
      exit;
    }
  }

  $target_file = $target_dir . uniqid() . '_' . basename($_FILES["profilePicture"]["name"]);

  if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
    $user->photo = str_replace($project_root, '', $target_file); // Store relative path
  } else {
    echo json_encode(array("message" => "Sorry, there was an error uploading your file."));
    exit;
  }
} else {
  if (isset($_POST['existingPhoto'])) {
    $user->photo = $_POST['existingPhoto'];
  } else {
    echo json_encode(array("message" => "No file uploaded and no existing photo provided."));
    exit;
  }
}

if ($user->update()) {
   $_SESSION['user_name'] = $user->name;
   $_SESSION['photo'] = $user->photo;
   header("Location: /dashboard.php");
   exit;
} else {
  echo json_encode(array("message" => "Unable to update user."));
}
?>
