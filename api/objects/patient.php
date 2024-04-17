<?php
class Patient{
 
    // database connection and table name
    private $conn;
    private $table_name = "patient"; // Изменено на имя таблицы в базе данных
 
    // object properties
    public $id_patient; // Изменено на имя столбца в базе данных
    public $name;
    public $number; // Изменено на имя столбца в базе данных
    public $adress; // Изменено на имя столбца в базе данных
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read all patients
    function read(){
    
        // select all query
        $query = "SELECT
                    `id_patient`, `name`, `number`, `adress`
                FROM
                    " . $this->table_name . " 
                ORDER BY
                    id_patient DESC"; // Изменено на имя столбца в базе данных
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // get single patient data
    function read_single(){
    
        // select all query
        $query = "SELECT
                    `id_patient`, `name`, `number`, `adress`
                FROM
                    " . $this->table_name . " 
                WHERE
                    id_patient= '".$this->id_patient."'"; // Изменено на имя столбца в базе данных
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // create patient
    function create(){
        try{
        // query to insert record
        $query = "INSERT INTO ". $this->table_name ." 
                        (`name`, `number`, `adress`)
                 VALUES
                        ('".$this->name."', '".$this->number."', '".$this->adress."')"; // Изменено на имя столбца в базе данных
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            $this->id_patient = $this->conn->lastInsertId(); // Изменено на имя столбца в базе данных
            return true;
        }

        return false;
    }
    catch (Exception $e) {
        return false;
    }
    }

    // update patient 
    function update(){
    try{
        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name='".$this->name."', number='".$this->number."', adress='".$this->adress."'
                WHERE
                    id_patient='".$this->id_patient."'"; // Изменено на имя столбца в базе данных
    
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

    // delete patient
    function delete(){
    try{
        // query to insert record
        $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    id_patient= '".$this->id_patient."'"; // Изменено на имя столбца в базе данных
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    catch (Exception $e) {
        return false;
    }
    }
}
