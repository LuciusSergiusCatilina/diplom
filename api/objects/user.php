<?php

class User
{
  private $conn;
  private $table_name = 'users';

  public $id_user;
  public $name;
  public $login;
  public $password;
  public $role;
  public $photo; // Добавлено свойство для фото

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getUserRole($id_user) {
    $stmt = $this->conn->prepare("SELECT role FROM users WHERE id_user = :id_user");
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ? $user['role'] : null;
  }

  public function checkUserRole($id_user, $role) {
    $userRole = $this->getUserRole($id_user);
    return $userRole === $role;
  }

  public function authenticate($login, $password) {
    $stmt = $this->conn->prepare("SELECT id_user, role, name, photo FROM users WHERE login = :login AND password = :password");
    if (!$stmt) {
      die("Ошибка аутентификации: " . $this->conn->error);
    }
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $_SESSION['user_id'] = $user['id_user'];
      $_SESSION['user_role'] = $user['role'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['photo'] = $user['photo'];
      return true;
    } else {
      return false;
    }
  }

  public function read_single(){
    $query = "SELECT id_user, name, photo FROM " . $this->table_name . " WHERE id_user = :id_user";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }

  public function update() {
    $query = "UPDATE " . $this->table_name . " SET name = :name, photo = :photo WHERE id_user = :id_user";

    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->photo = htmlspecialchars(strip_tags($this->photo));
    $this->id_user = htmlspecialchars(strip_tags($this->id_user));

    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':photo', $this->photo);
    $stmt->bindParam(':id_user', $this->id_user);

    if($stmt->execute()) {
      return true;
    }

    return false;
  }
}
