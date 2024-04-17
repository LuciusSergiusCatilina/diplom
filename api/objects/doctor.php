<?php
class Doctor{
 
    // database connection and table name
    private $conn;
    private $table_name = "doctor"; // Изменено на имя таблицы в базе данных
 
    // object properties
    public $id_doctor; // Изменено на имя столбца в базе данных
    public $name;
    public $number; // Изменено на имя столбца в базе данных
    public $specialization; // Изменено на имя столбца в базе данных
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read all doctors
    function read(){
    
        // select all query
        $query = "SELECT
                    `id_doctor`, `name`, `number`, `specialization`
                FROM
                    " . $this->table_name . " 
                ORDER BY
                    id_doctor DESC"; // Изменено на имя столбца в базе данных
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // get single doctor data
    function read_single(){
    
        // select all query
        $query = "SELECT
                    `id_doctor`, `name`, `number`, `specialization`
                FROM
                    " . $this->table_name . " 
                WHERE
                    id_doctor= '".$this->id_doctor."'"; // Изменено на имя столбца в базе данных
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // create doctor
    function create(){
        try{
        // query to insert record
        $query = "INSERT INTO ". $this->table_name ." 
                        (`name`, `number`, `specialization`)
                 VALUES
                        ('".$this->name."', '".$this->number."', '".$this->specialization."')"; // Изменено на имя столбца в базе данных
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            $this->id_doctor = $this->conn->lastInsertId(); // Изменено на имя столбца в базе данных
            return true;
        }

        return false;
    }
    catch (Exception $e) {
        return false;
    }
    }

    // update doctor 
    function update(){
    try{
        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name='".$this->name."', number='".$this->number."', specialization='".$this->specialization."'
                WHERE
                    id_doctor='".$this->id_doctor."'"; // Изменено на имя столбца в базе данных
    
        // prepare query
        $stmt = $this->conn->prepare($query);
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    catch (Exception $e) 
    {
        return false;
    }
    }

    // delete doctor
    function delete(){
        
        // query to insert record
        $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    id_doctor= '".$this->id_doctor."'"; // Изменено на имя столбца в базе данных
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
