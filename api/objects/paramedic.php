<?php
class Paramedic {
    private $conn;
    private $table_name = "paramedic";

    public $id_paramedic;
    public $name;
    public $number;

    public function __construct($db){
        $this->conn = $db;
    }

    protected function startTransaction(){
        $this->conn->beginTransaction();
    }

    protected function commitTransaction(){
        $this->conn->commit();
    }

    protected function rollbackTransaction(){
        $this->conn->rollback();
    }

    function read(){
        $query = "SELECT `id_paramedic`, `name`, `number` FROM ". $this->table_name. " ORDER BY id_paramedic DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function read_single(){
        $query = "SELECT `id_paramedic`, `name`, `number` FROM ". $this->table_name. " WHERE id_paramedic= :id_paramedic";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_paramedic', $this->id_paramedic, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function create(){
        try{
            $this->startTransaction();
            $query = "INSERT INTO ". $this->table_name." (`name`, `number`) VALUES (:name, :number)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':number', $this->number, PDO::PARAM_STR);
            if($stmt->execute()){
                $this->id_paramedic = $this->conn->lastInsertId();
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

    function update(){
        try{
            $this->startTransaction();
            $query = "UPDATE ". $this->table_name. " SET name=:name, number=:number WHERE id_paramedic=:id_paramedic";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':number', $this->number, PDO::PARAM_STR);
            $stmt->bindParam(':id_paramedic', $this->id_paramedic, PDO::PARAM_INT);
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

    function delete(){
        try{
            $this->startTransaction();
            $query = "DELETE FROM ". $this->table_name. " WHERE id_paramedic= :id_paramedic";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_paramedic', $this->id_paramedic, PDO::PARAM_INT);
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
