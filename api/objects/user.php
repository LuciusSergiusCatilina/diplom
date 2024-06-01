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
        $stmt = $this->conn->prepare("SELECT id_user, role, name FROM users WHERE login = :login AND password = :password");
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
            return true;
        } else {
            return false;
        }
    }
}
