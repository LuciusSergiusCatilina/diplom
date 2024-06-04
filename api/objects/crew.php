<?php
class Crew
{
  // database connection and table name
  private $conn;
  private $table_name = 'crews';

  // object properties
  public $id_crew;
  public $id_driver;
  public $id_doctor;
  public $id_paramedic;
  public $id_orderly;
  public $is_available;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // read all crews with their members' names
  function read()
  {
    $query = "SELECT
                c.id_crew,
                c.is_available,
                d.name as driver_name,
                doc.name as doctor_name,
                o.name as orderly_name,
                p.name as paramedic_name
              FROM
                crews c
              INNER JOIN
                drivers d ON c.id_driver = d.id_drivers
              INNER JOIN
                doctor doc ON c.id_doctor = doc.id_doctor
              INNER JOIN
                orderly o ON c.id_orderly = o.id_orderly
              LEFT JOIN
                paramedic p ON c.id_paramedic = p.id_paramedic
              ORDER BY
                c.id_crew DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  // get single crew data with their members' names
  function read_single($id_crew)
  {
    $query = "SELECT
                c.id_crew, c.id_driver, c.id_doctor, c.id_paramedic, c.id_orderly,
                d.name as driver_name,
                doc.name as doctor_name,
                o.name as orderly_name,
                p.name as paramedic_name
              FROM
                crews c
              INNER JOIN
                drivers d ON c.id_driver = d.id_drivers
              INNER JOIN
                doctor doc ON c.id_doctor = doc.id_doctor
              INNER JOIN
                orderly o ON c.id_orderly = o.id_orderly
              LEFT JOIN
                paramedic p ON c.id_paramedic = p.id_paramedic
              WHERE
                c.id_crew = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $id_crew);
    $stmt->execute();

    return $stmt;
  }

  // create new crew
  function create()
  {
    try {
      $query = 'INSERT INTO ' . $this->table_name . ' (id_crew, id_driver, id_doctor, id_paramedic, id_orderly) VALUES (?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->id_crew);
      $stmt->bindParam(2, $this->id_driver);
      $stmt->bindParam(3, $this->id_doctor);
      $stmt->bindParam(4, $this->id_paramedic);
      $stmt->bindParam(5, $this->id_orderly);

      if ($stmt->execute()) {
        return true;
      }

      return false;
    } catch (Exception $e) {
      return false;
    }
  }

  // update crew
  function update()
  {
    try {
      $query = 'UPDATE ' . $this->table_name . ' SET id_driver=?, id_doctor=?, id_paramedic=?, id_orderly=? WHERE id_crew=?';
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->id_driver);
      $stmt->bindParam(2, $this->id_doctor);
      $stmt->bindParam(3, $this->id_paramedic);
      $stmt->bindParam(4, $this->id_orderly);
      $stmt->bindParam(5, $this->id_crew);

      if ($stmt->execute()) {
        return true;
      }

      return false;
    } catch (Exception $e) {
      return false;
    }
  }

  // update crew status
  function update_status()
  {
    try {
      $query = 'UPDATE ' . $this->table_name . ' SET is_available = ? WHERE id_crew=?';
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->is_available);
      $stmt->bindParam(2, $this->id_crew);

      if ($stmt->execute()) {
        return true;
      }

      return false;
    } catch (Exception $e) {
      return false;
    }
  }

  // delete crew
  function delete()
  {
    $query = 'DELETE FROM ' . $this->table_name . ' WHERE id_crew=?';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_crew);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  // get all drivers
  function getDrivers()
  {
    $query = "SELECT id_drivers, name FROM drivers";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // get all doctors
  function getDoctors()
  {
    $query = "SELECT id_doctor, name FROM doctor";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // get all orderlies
  function getOrderly()
  {
    $query = "SELECT id_orderly, name FROM orderly";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // get all paramedics
  function getParamedics()
  {
    $query = "SELECT id_paramedic, name FROM paramedic";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
