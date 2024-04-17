<?php
class Paramedic{
 
    // database connection and table name
    private $conn;
    private $table_name = "paramedic"; // Изменено на имя таблицы в базе данных
 
    // object properties
    public $id_paramedic; // Изменено на имя столбца в базе данных
    public $name;
    public $number; // Изменено на имя столбца в базе данных

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read all paramedics
    function read(){
    
        // select all query
        $query = "SELECT
                    `id_paramedic`, `name`, `number`
                FROM
                    " . $this->table_name . " 
                ORDER BY
                    id_paramedic DESC"; // Изменено на имя столбца в базе данных
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // get single paramedic data
    function read_single(){
    
        // select all query
        $query = "SELECT
                    `id_paramedic`, `name`, `number`
                FROM
                    " . $this->table_name . " 
                WHERE
                    id_paramedic= '".$this->id_paramedic."'"; // Изменено на имя столбца в базе данных
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }

    // create paramedic
    function create(){
        try{
        // query to insert record
        $query = "INSERT INTO ". $this->table_name ." 
                        (`name`, `number`)
                 VALUES
                        ('".$this->name."', '".$this->number."')"; // Изменено на имя столбца в базе данных
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            $this->id_paramedic = $this->conn->lastInsertId(); // Изменено на имя столбца в базе данных
            return true;
        }

        return false;
    }
    catch (Exception $e) {
        return false;
    }
    }

    // update paramedic 
    function update(){
    try{
        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name='".$this->name."', number='".$this->number."'
                WHERE
                    id_paramedic='".$this->id_paramedic."'"; // Изменено на имя столбца в базе данных
    
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

    // delete paramedic
    function delete(){
    try{
        // query to insert record
        $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    id_paramedic= '".$this->id_paramedic."'"; // Изменено на имя столбца в базе данных
        
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
?>
