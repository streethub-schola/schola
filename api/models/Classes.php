<?php

class Classes {

    private $table_name = "classes";

    public $class_id;
    public $class_name;
    public $created_at;
    public $updated_at;


    public function getClass(){

            // select query if student ID is provided
            $query = "SELECT *  FROM " . $this->table_name . " WHERE class_id=" . $this->class_id;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt;
    }

    
}