<?php
class Crew
{
    // database connection and table name
    private $conn;
    private $table_name = 'crews'; // Изменено на имя таблицы в базе данных

    // object properties
    public $id_crew; // Изменено на имя столбца в базе данных
    public $id_driver; // Добавлено свойство для драйвера
    public $id_doctor; // Добавлено свойство для врача
    public $id_paramedic; // Добавлено свойство для парамедика
    public $id_orderly; // Добавлено свойство для медсестры

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all crews with their members' names
    function read()
    {
        // select all query with JOINs
        $query = "SELECT
                c.id_crew,
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

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // get single crew data with their members' names
    function read_single($id_crew)
    {
        // select all query with JOINs
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

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of crew to be updated
        $stmt->bindParam(1, $id_crew);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function create()
{
    try {
        // query to insert record
        $query = 'INSERT INTO ' . $this->table_name . ' (`id_crew`,`id_driver`, `id_doctor`, `id_paramedic`, `id_orderly`) VALUES (?,?, ?, ?, ?)';

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(1, $this->id_crew);
        $stmt->bindParam(2, $this->id_driver);
        $stmt->bindParam(3, $this->id_doctor);
        $stmt->bindParam(4, $this->id_paramedic);
        $stmt->bindParam(5, $this->id_orderly);

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
    function update()
{
    try {
        // query to update record
        $query = 'UPDATE ' . $this->table_name . ' SET id_driver=?, id_doctor=?, id_paramedic=?, id_orderly=? WHERE id_crew=?';

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(1, $this->id_driver);
        $stmt->bindParam(2, $this->id_doctor);
        $stmt->bindParam(3, $this->id_paramedic);
        $stmt->bindParam(4, $this->id_orderly);
        $stmt->bindParam(5, $this->id_crew);

        // execute query
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
        // query to delete record
        $query = 'DELETE FROM ' . $this->table_name . ' WHERE id_crew=?';

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind id of crew to be deleted
        $stmt->bindParam(1, $this->id_crew);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function getDrivers()
    {
        $query = "SELECT id_drivers, name FROM drivers";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getDoctors()
    {
        $query = "SELECT id_doctor, name FROM doctor";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getOrderly()
    {
        $query = "SELECT id_orderly, name FROM orderly";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getParamedics()
    {
        $query = "SELECT id_paramedic, name FROM paramedic";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
