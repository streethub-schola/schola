<?php

class Term extends Database
{

    private $table_name = "terms";

    public $term_id;
    public $term_name;
    public $created_at;
    public $updated_at;


    public function getTerm()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name . " WHERE term_id=" . $this->term_id;

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


    // Get all termes
    public function getAllTerms()
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
    function createTerm()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (term_name) VALUES (:term_name) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":term_name", $this->term_name);

        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // update the student
    function updateTerm()
    {
        $this->updated_at = date("Y:m:d H:i:sa");
        // update query
        $query = "UPDATE " . $this->table_name . " SET
                 term_name = :term_name,
                 updated_at = :updated_at
                 WHERE
                 term_id = :term_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':term_name', $this->term_name);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        $update_stmt->bindParam(':term_id', $this->term_id);

        try {
            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }

    // delete a user
    function deleteTerm()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE term_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind term_id of record to delete
        $stmt->bindParam(1, $this->term_id);

        // execute query
        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // search for a particular term(es) in a given column
    function searchTerm($searchstring, $col)
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE $col LIKE '%$searchstring%'";


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
