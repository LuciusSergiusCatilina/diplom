<?php
class Patient {
  private $conn;
  private $table_name = "patient";

  public $id_patient;
  public $name;
  public $number;
  public $address;

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
    $query = "SELECT `id_patient`, `name`, `number`, `address` FROM ". $this->table_name. " ORDER BY id_patient DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function read_single(){
    $query = "SELECT `id_patient`, `name`, `number`, `address` FROM ". $this->table_name. " WHERE id_patient= :id_patient";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_patient', $this->id_patient, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }

  function create(){
    try{
      $this->startTransaction();
      $query = "INSERT INTO ". $this->table_name." (`name`, `number`, `address`) VALUES (:name, :number, :address)";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
      $stmt->bindParam(':number', $this->number, PDO::PARAM_STR);
      $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
      if($stmt->execute()){
        $this->id_patient = $this->conn->lastInsertId();
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
      $query = "UPDATE ". $this->table_name. " SET name=:name, number=:number, address=:address WHERE id_patient=:id_patient";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
      $stmt->bindParam(':number', $this->number, PDO::PARAM_STR);
      $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
      $stmt->bindParam(':id_patient', $this->id_patient, PDO::PARAM_INT);
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
      $query = "DELETE FROM ". $this->table_name. " WHERE id_patient= :id_patient";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id_patient', $this->id_patient, PDO::PARAM_INT);
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

  function getCount(){
    $query = "SELECT COUNT(*) FROM ". $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
  }
}
