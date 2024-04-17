<?php
class Driver {
    // database connection and table name
    private $conn;
    private $table_name = "drivers"; // Изменено на имя таблицы в базе данных

    // object properties
    public $id_drivers; // Изменено на имя столбца в базе данных
    public $name;
    public $phone; // Изменено на имя столбца в базе данных

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read all drivers
    function read(){
        // select all query
        $query = "SELECT
                    `id_drivers`, `name`, `phone`
                FROM
                    " . $this->table_name . " 
                ORDER BY
                    id_drivers DESC"; // Изменено на имя столбца в базе данных

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // get single driver data
    function read_single(){
        // select all query
        $query = "SELECT
                    `id_drivers`, `name`, `phone`
                FROM
                    " . $this->table_name . " 
                WHERE
                    id_drivers= '".$this->id_drivers."'"; // Изменено на имя столбца в базе данных

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        return $stmt;
    }

    // create driver
    function create(){
        try{
            // query to insert record
            $query = "INSERT INTO ". $this->table_name ." 
                            (`name`, `phone`)
                     VALUES
                            ('".$this->name."', '".$this->phone."')"; // Изменено на имя столбца в базе данных

            // prepare query
            $stmt = $this->conn->prepare($query);

            // execute query
            if($stmt->execute()){
                $this->id_drivers = $this->conn->lastInsertId(); // Изменено на имя столбца в базе данных
                return true;
            }

            return false;
        }
        catch (Exception $e) {
            return false;
        }
    }

    // update driver 
    function update(){
        try{
            // query to insert record
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        name='".$this->name."', phone='".$this->phone."'
                    WHERE
                        id_drivers='".$this->id_drivers."'"; // Изменено на имя столбца в базе данных

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

    // delete driver
    function delete(){
        
        // query to insert record
        $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    id_drivers= '".$this->id_drivers."'"; // Изменено на имя столбца в базе данных
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>
