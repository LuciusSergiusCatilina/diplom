<?php
class Call
{
  // database connection and table name
  private $conn;
  private $table_name = 'calls'; // Изменено на имя таблицы в базе данных

  // object properties
  public $id_call; // Изменено на имя столбца в базе данных
  public $id_user; // Добавлено свойство для драйвера
  public $id_crew; // Добавлено свойство для врача
  public $id_patient; // Добавлено свойство для парамедика
  public $adress; // Добавлено свойство для медсестры
  public $time;
  public $number;
  public $type;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {
    $query = "SELECT c.id_call, c.id_user, c.id_crew,
    p.id_patient,
    u.name AS user_name, 
    p.name AS patient_name, 
    c.adress, c.time, c.number, 
    c.type FROM calls 
    c LEFT JOIN users 
    u ON c.id_user = u.id_user 
    LEFT JOIN patient p ON c.id_patient = p.id_patient 
    ORDER BY c.time DESC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function read_single($id_call)
  {
    $query = "SELECT c.id_call, c.id_user, c.id_crew, c.id_patient, 
    u.name AS user_name, 
    p.name AS patient_name, 
    c.adress, c.time, c.number, 
    c.type FROM calls 
    c LEFT JOIN users 
    u ON c.id_user = u.id_user 
    LEFT JOIN patient p ON c.id_patient = p.id_patient 
    WHERE c.id_call = ?";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $id_call);

    $stmt->execute();

    return $stmt;
  }
 
  function create()
  {
    try {
      // query to insert record
      $query = 'INSERT INTO ' . $this->table_name . ' (`id_crew`, `id_patient`, `adress`, `number`, `type`) VALUES (?, ?, ?, ?, ?)';

      // prepare query
      $stmt = $this->conn->prepare($query);

      // bind values
      //$stmt->bindParam(1, $this->id_call);
      //$stmt->bindParam(2, $this->id_user);
      $stmt->bindParam(1, $this->id_crew);
      $stmt->bindParam(2, $this->id_patient);
      $stmt->bindParam(3, $this->adress);
      $stmt->bindParam(4, $this->number);
      $stmt->bindParam(5, $this->type);

      // execute query
      if ($stmt->execute()) {
        return true;
      }

      return false;
    } catch (Exception $e) {
      return false;
    }
  }
  // update crew
// update call
function update()
{
    try {
        $query = 'UPDATE ' . $this->table_name . ' SET id_crew=?, id_patient=?, adress=?, number=?, type=? WHERE id_call=?';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id_crew);
        $stmt->bindParam(2, $this->id_patient);
        $stmt->bindParam(3, $this->adress);
        $stmt->bindParam(4, $this->number);
        $stmt->bindParam(5, $this->type);
        $stmt->bindParam(6, $this->id_call);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

  function delete()
  {
      // query to delete record
      $query = 'DELETE FROM ' . $this->table_name . ' WHERE id_call=?';
  
      // prepare query
      $stmt = $this->conn->prepare($query);
  
      // bind id of call to be deleted
      $stmt->bindParam(1, $this->id_call);
  
      // execute query
      if ($stmt->execute()) {
          return true;
      }
  
      return false;
  }

  function getUsers()
  {
    $query = "SELECT id_users, name FROM users";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function getCrews()
  {
    $query = "SELECT id_crew FROM crews";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getPatients()
  {
    $query = "SELECT id_patient, name FROM patient";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getCount(){
    $query = "SELECT COUNT(*) FROM calls";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();         
  }

  function getCountConsultations(){
    $query = "SELECT COUNT(*) FROM calls WHERE type ='Консультация'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();         
  }

  function getCountDepartures(){
    $query = "SELECT COUNT(*) FROM calls WHERE type ='Вызов бригады'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();         
  }

}
