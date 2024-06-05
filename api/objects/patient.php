<?php
class Patient{

  private $conn;
  private $table_name = "patient";

  public $id_patient;
  public $name;
  public $number;
  public $adress;

  public function __construct($db){
    $this->conn = $db;
  }

  function read(){

    $query = "SELECT `id_patient`, `name`, `number`, `adress` FROM " . $this->table_name . " ORDER BY id_patient DESC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function read_single(){

    $query = "SELECT `id_patient`, `name`, `number`, `adress` FROM " . $this->table_name . " WHERE id_patient = :id_patient";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id_patient', $this->id_patient);

    $stmt->execute();
    return $stmt;
  }

  // create patient
  function create(){
    try {
      $this->conn->beginTransaction();

      $query = "INSERT INTO " . $this->table_name . " (`name`, `number`, `adress`) VALUES (:name, :number, :adress)";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':number', $this->number);
      $stmt->bindParam(':adress', $this->adress);

      if ($stmt->execute()) {
        $this->id_patient = $this->conn->lastInsertId();
        $this->conn->commit();
        return true;
      } else {
        $this->conn->rollBack();
        return false;
      }
    } catch (Exception $e) {
      $this->conn->rollBack();
      echo "Create error: " . $e->getMessage();
      return false;
    }
  }

  // update patient
  function update(){
    try {
      $this->conn->beginTransaction();

      $query = "UPDATE " . $this->table_name . " SET name = :name, number = :number, adress = :adress WHERE id_patient = :id_patient";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':number', $this->number);
      $stmt->bindParam(':adress', $this->adress);
      $stmt->bindParam(':id_patient', $this->id_patient);

      // execute query
      if ($stmt->execute()) {
        $this->conn->commit();
        return true;
      } else {
        $this->conn->rollBack();
        return false;
      }
    } catch (Exception $e) {
      $this->conn->rollBack();
      echo "Update error: " . $e->getMessage();
      return false;
    }
  }

  // delete patient
  function delete(){
    try {
      $this->conn->beginTransaction();

      $query = "DELETE FROM " . $this->table_name . " WHERE id_patient = :id_patient";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':id_patient', $this->id_patient);

      if ($stmt->execute()) {
        $this->conn->commit();
        return true;
      } else {
        $this->conn->rollBack();
        return false;
      }
    } catch (Exception $e) {
      $this->conn->rollBack();
      echo "Delete error: " . $e->getMessage();
      return false;
    }
  }

  function getCount(){
    $query = "SELECT COUNT(*) FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
  }
}
?>
