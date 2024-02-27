<?php

class Subject extends Database
{

    private $table_name = "subjects";

    public $subject_id;
    public $subject_name;
    public $subject_code;
    public $created_at;
    public $updated_at;


    public function getSubject()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name . " WHERE subject_id=" . $this->subject_id;

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


    // Get all subjectes
    public function getAllSubjects()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

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
    function createSubject()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (subject_name, subject_code) VALUES (:subject_name, :subject_code) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":subject_name", $this->subject_name);
        $stmt->bindParam(":subject_code", $this->subject_code);

        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // update the student
    function updateSubject()
    {
        $this->subject_code = strtoupper($this->subject_code);
        $this->updated_at = date("Y:m:d H:i:sa");

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                 subject_name = :subject_name,
                 subject_code = :subject_code,
                 updated_at = :updated_at
                 WHERE
                 subject_id = :subject_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':subject_name', $this->subject_name);
        $update_stmt->bindParam(':subject_code', $this->subject_code);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        $update_stmt->bindParam(':subject_id', $this->subject_id);

        try {
            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }

    // delete a user
    function deleteSubject()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE subject_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind subject_id of record to delete
        $stmt->bindParam(1, $this->subject_id);

        try {

            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {

            return array("output" => $e->getMessage(), "outputStatus" => 1200);
        }
    }


    // search for a particular subject(s) in a given column
    function searchSubject($searchstring, $col)
    {

        // select all query
        // $query = "SELECT * FROM " . $this->table_name . " WHERE '$col' LIKE '%$searchstring%'";
        $query = "SELECT * FROM " . $this->table_name . " WHERE $col LIKE '%$searchstring%'";


        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        try {
            // execute query
            $update_stmt->execute();

            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {

            return array("output" => $e->getMessage(), "outputStatus" => 1200);
        }
    }
}
