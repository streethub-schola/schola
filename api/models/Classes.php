<?php

class Classes extends Database
{

    private $table_name = "classes";

    public $class_id;
    public $class_name;
    public $class_level;
    public $class_extension;
    public $created_at;
    public $updated_at;


    public function getClass()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name . " WHERE class_id=" . $this->class_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // Get all classes
    public function getAllClasses()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create user
    function createClass()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (class_name, class_level, class_extension) VALUES (:class_name, :class_level, :class_extension) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":class_name", $this->class_name);
        $stmt->bindParam(":class_level", $this->class_level);
        $stmt->bindParam(":class_extension", $this->class_extension);

        try {
            // execute query
            if ($stmt->execute()) return true;
            return false;
        } catch (Exception $e) {

            // return $e->getMessage();
            return "Network issue, please try again";
        }
    }


    // update the student
    function updateClass()
    {
        $this->updated_at = date("Y:m:d H:i:sa");
        // update query
        $query = "UPDATE " . $this->table_name . " SET
                 class_name = :class_name,
                 class_level = :class_level,
                 class_extension = :class_extension,
                 updated_at = :updated_at
                 WHERE
                 class_id = :class_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':class_name', $this->class_name);
        $update_stmt->bindParam(':class_level', $this->class_level);
        $update_stmt->bindParam(':class_extension', $this->class_extension);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        $update_stmt->bindParam(':class_id', $this->class_id);

        try {
            if ($update_stmt->execute()) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            // return $e->getMessage();
            return "Network issue, please try again";

        }
        // execute the query


    }

    // delete a user
    function deleteClass()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE class_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind class_id of record to delete
        $stmt->bindParam(1, $this->class_id);

        // execute query
        if ($stmt->execute()) return true;
           return false;
    }
    
}
