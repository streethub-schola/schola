<?php

class Assignment extends Database
{

    private $table_name = "assignments";

    public $assignment_id;
    public $class_id;
    public $subject_id;
    public $term_id;
    public $session_id;
    public $staff_id;
    public $assignment;
    public $created_at;
    public $updated_at;


    public function getAssignment()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name . " WHERE assignment_id=" . $this->assignment_id;

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


    // Get all assignmentes
    public function getAllAssignments()
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
            return array("output" => $e->getMessage(), "erorr" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }

    // create user
    function createAssignment()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (class_id, subject_id, term_id, session_id, staff_id, assignment) VALUES (:class_id, :subject_id, :term_id, :session_id, :staff_id, :assignment) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":class_id", $this->class_id);
        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":term_id", $this->term_id);
        $stmt->bindParam(":session_id", $this->session_id);
        $stmt->bindParam(":staff_id", $this->staff_id);
        $stmt->bindParam(":assignment", $this->assignment);

        try {
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // update the student
    function updateAssignment()
    {
        $this->updated_at = date("Y:m:d H:i:sa");

        // update query
        $query = "UPDATE " . $this->table_name . " SET 
                class_id = :class_id,
                subject_id = :subject_id,
                term_id = :term_id,
                session_id = :session_id,
                 staff_id = :staff_id,
                 assignment = :assignment,
                 updated_at = :updated_at
                 WHERE
                 assignment_id = :assignment_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':class_id', $this->class_id);
        $update_stmt->bindParam(':subject_id', $this->subject_id);
        $update_stmt->bindParam(':term_id', $this->term_id);
        $update_stmt->bindParam(':session_id', $this->session_id);
        $update_stmt->bindParam(':staff_id', $this->staff_id);
        $update_stmt->bindParam(':assignment', $this->assignment);

        $update_stmt->bindParam(':updated_at', $this->updated_at);

        $update_stmt->bindParam(':assignment_id', $this->assignment_id);

        try {
            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }

    // delete a user
    function deleteAssignment()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE assignment_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind assignment_id of record to delete
        $stmt->bindParam(1, $this->assignment_id);

        try {

            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {

            return array("output" => $e->getMessage(), "outputStatus" => 1200);
        }
    }


    // search for a particular assignment(s) in a given column
    function searchAssignment($searchstring, $col)
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


    // Get assignment for dashboard
    function dashboardAssignment($searchstring, $col)
    {

        // select all query
        // $query = "SELECT * FROM " . $this->table_name . " WHERE '$col' LIKE '%$searchstring%'";
        $query = "SELECT assignments.class_id, assignments.created_at, assignments.assignment_id, subjects.subject_name, staffs.firstname, staffs.lastname FROM " . $this->table_name .    " JOIN subjects ON assignments.subject_id=subjects.subject_id JOIN staffs ON assignments.staff_id=staffs.staff_id WHERE assignments.$col LIKE '%$searchstring%'";


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
