<?php
class Driver {
    private $conn;
    private $table_name = "drivers";
    public $id_drivers;
    public $name;
    public $phone;

    public function __construct($db){
        $this->conn = $db;
    }

    // Начало транзакции перед каждым изменением данных
    protected function startTransaction(){
        $this->conn->beginTransaction();
    }

    // Завершение транзакции после успешного выполнения всех операций
    protected function commitTransaction(){
        $this->conn->commit();
    }

    // Откат транзакции в случае ошибки
    protected function rollbackTransaction(){
        $this->conn->rollback();
    }

    // Функция для чтения всех водителей
    function read(){
        $query = "SELECT `id_drivers`, `name`, `phone` FROM ". $this->table_name. " ORDER BY id_drivers DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Функция для получения данных одного водителя
    function read_single(){
        $query = "SELECT `id_drivers`, `name`, `phone` FROM ". $this->table_name. " WHERE id_drivers= :id_drivers";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_drivers', $this->id_drivers, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Создание нового водителя
    function create(){
        try{
            $this->startTransaction();
            $query = "INSERT INTO ". $this->table_name." (`name`, `phone`) VALUES (:name, :phone)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
            if($stmt->execute()){
                $this->id_drivers = $this->conn->lastInsertId();
                $this->commitTransaction();
                return true;
            }
            $this->rollbackTransaction();
            return false;
        } catch (Exception $e) {
            $this->rollbackTransaction();
            return false;
        }
    }

    // Обновление данных водителя
    function update(){
        try{
            $this->startTransaction();
            $query = "UPDATE ". $this->table_name. " SET name=:name, phone=:phone WHERE id_drivers=:id_drivers";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
            $stmt->bindParam(':id_drivers', $this->id_drivers, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->commitTransaction();
                return true;
            }
            $this->rollbackTransaction();
            return false;
        } catch (Exception $e) {
            $this->rollbackTransaction();
            return false;
        }
    }

    // Удаление водителя
    function delete(){
        try{
            $this->startTransaction();
            $query = "DELETE FROM ". $this->table_name. " WHERE id_drivers= :id_drivers";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_drivers', $this->id_drivers, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->commitTransaction();
                return true;
            }
            $this->rollbackTransaction();
            return false;
        } catch (Exception $e) {
            $this->rollbackTransaction();
            return false;
        }
    }
}
