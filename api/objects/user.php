<?php

Class User
{
  private $conn;
  private $table_name = 'users';

  public $id_user;
  public $name;
  public $login;
  public $password;
  public $role;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getUserRole($id_user) {
    $stmt = $this->conn->prepare("SELECT role FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user ? $user['role'] : null;
  }

  public function checkUserRole($id_user, $role) {
    $userRole = $this->getUserRole($id_user);
    return $userRole === $role;
  }

  public function authenticate($login, $password) {
    $stmt = $this->conn->prepare("SELECT id_user, role FROM users WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
      $_SESSION['user_id'] = $user['id_user'];
      $_SESSION['user_role'] = $user['role'];
      return true;
    } else {
      return false;
    }
  }

}