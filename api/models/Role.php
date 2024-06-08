<?php

class Role extends Database
{

    private $table_name = "roles";

    public $role_id;
    public $role_name;
    public $role_no;
    public $created_at;
    public $updated_at;


    public function getRole()
    {

        // select query if student ID is provided
        $query = "SELECT *  FROM " . $this->table_name . " WHERE role_id=" . $this->role_id;

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


    // Get all rolees
    public function getAllRoles()
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
    function createRole()
    {
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (role_name, role_no) VALUES (:role_name, :role_no) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":role_name", $this->role_name);
        $stmt->bindParam(":role_no", $this->role_no);

        try {
            // execute query
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


    // update the student
    function updateRole()
    {
        $this->updated_at = date("Y:m:d H:i:sa");
        // update query
        $query = "UPDATE " . $this->table_name . " SET
                 role_name = :role_name,
                 role_no = :role_no,
                 updated_at = :updated_at
                 WHERE
                 role_id = :role_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':role_name', $this->role_name);
        $update_stmt->bindParam(':role_no', $this->role_no);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        $update_stmt->bindParam(':role_id', $this->role_id);

        try {
            // execute query
            $update_stmt->execute();
            return array("output" => $update_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
        // execute the query


    }

    // delete a user
    function deleteRole()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE role_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind role_id of record to delete
        $stmt->bindParam(1, $this->role_id);

        try {
            // execute query
            $stmt->execute();
            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        };
    }


         // search for a particular role(es) in a given column
         function searchRole($searchstring, $col)
         {
     
             // select all query
             $query = "SELECT * FROM " . $this->table_name . " WHERE $col LIKE '%$searchstring%'";
     
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
    
}
