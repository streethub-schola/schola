<?php

class Session extends Database
{

    private $table_name = "sessions";

    public $session_id;
    public $session_name;
    public $start_date;
    public $end_date;
    public $created_at;
    public $updated_at;

    public $term_id;


    public function getSession()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name . " WHERE session_id=" . $this->session_id;

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


    // Get all sessiones
    public function getAllSessions()
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
    function createSession()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (session_name, start_date, end_date) VALUES (:session_name, :start_date, :end_date) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":session_name", $this->session_name);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);


        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // update the student
    function updateSession()
    {
        $this->updated_at = date("Y:m:d H:i:sa");
        // update query
        $query = "UPDATE " . $this->table_name . " SET
                 session_name = :session_name,
                 start_date = :start_date,
                 end_date = :end_date,
                 updated_at = :updated_at
                 WHERE
                 session_id = :session_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':session_name', $this->session_name);
        $update_stmt->bindParam(":start_date", $this->start_date);
        $update_stmt->bindParam(":end_date", $this->end_date);


        $update_stmt->bindParam(':updated_at', $this->updated_at);
        $update_stmt->bindParam(':session_id', $this->session_id);

        try {
            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }

    // delete a user
    function deleteSession()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE session_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind session_id of record to delete
        $stmt->bindParam(1, $this->session_id);

        // execute query
        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // search for a particular session(es) in a given column
    function searchSession($searchstring, $col)
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

    // search for a particular session(es) in a given column
    function getCurrentSession()
    {

        // select all query
        $query = "SELECT * FROM cur_session";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        try {

            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {

            return array("output" => $e->getMessage(), "outputStatus" => 1200);
        }
    }

    // search for a particular session(es) in a given column
    function insertCurrentSession()
    {

        // select all query
        $query = "INSERT INTO cur_session (session_id, term_id) VALUES(:session_id, :term_id)";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        $update_stmt->bindParam(':session_id', $this->session_id);
        $update_stmt->bindParam(":term_id", $this->term_id);

        try {

            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {

            return array("output" => $e->getMessage(), "outputStatus" => 1200);
        }
    }

    // search for a particular session(es) in a given column
    function updateCurrentSession()
    {

        $this->updated_at = date("Y:m:d H:i:sa");

        // select all query
        $query = "UPDATE cur_session SET session_id=:session_id, term_id=:term_id, updated_at=:updated_at WHERE id=1";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':term_id', $this->term_id);
        $update_stmt->bindParam(':session_id', $this->session_id);
        $update_stmt->bindParam(':updated_at', $this->updated_at);


        try {

            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {

            return array("output" => $e->getMessage(), "outputStatus" => 1200);
        }
    }
}
