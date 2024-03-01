<?php

class Classes extends Database
{

    private $table_name = "classes";

    public $class_id;
    public $class_name;
    public $created_at;
    public $updated_at;


    public function getClass()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name . " WHERE class_id=" . $this->class_id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        try {
            // execute query
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // Get all classes
    public function getAllClasses()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        try {
            // execute query
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }

    // create user
    function createClass()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (class_name) VALUES (:class_name) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":class_name", $this->class_name);

        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // update the student
    function updateClass()
    {
        $this->updated_at = date("Y:m:d H:i:sa");
        // update query
        $query = "UPDATE " . $this->table_name . " SET
                 class_name = :class_name,
                 updated_at = :updated_at
                 WHERE
                 class_id = :class_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':class_name', $this->class_name);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        $update_stmt->bindParam(':class_id', $this->class_id);

        try {
            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
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
        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // search for a particular class(es) in a given column
    function searchClass($searchstring, $col)
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE $col LIKE '%$searchstring%";


        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        try {

            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {

            return array("output" => $e->getMessage(), "outputStatus" => 1200);
        }
    }
}
