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
    function updateStudent()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                 admin_no = :admin_no,
                 firstname = :firstname,
                 lastname = :lastname,
                 dob = :dob,
                 image = :image,
                 guardian_name = :guardian_name,
                 guardian_phone = :guardian_phone,
                 guardian_email = :guardian_email,
                 guardian_address = :guardian_address,
                 guardian_rel = :guardian_rel,
                 updated_at = :updated_at
             WHERE
                 student_id = :student_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':admin_no', $this->admin_no);
        $update_stmt->bindParam(':firstname', $this->firstname);
        $update_stmt->bindParam(':lastname', $this->lastname);
        $update_stmt->bindParam(':dob', $this->dob);
        $update_stmt->bindParam(':image', $this->image);
        $update_stmt->bindParam(':guardian_name', $this->guardian_name);
        $update_stmt->bindParam(':guardian_phone', $this->guardian_phone);
        $update_stmt->bindParam(':guardian_email', $this->guardian_email);
        $update_stmt->bindParam(':guardian_address', $this->guardian_address);
        $update_stmt->bindParam(':guardian_rel', $this->guardian_rel);
        $update_stmt->bindParam(':updated_at', $this->updated_at);
        $update_stmt->bindParam(':student_id', $this->student_id);

        try {
            if ($update_stmt->execute()) return true;

            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // execute the query


    }

    // delete a user
    function deleteStudent()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE student_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind student_id of record to delete
        $stmt->bindParam(1, $this->student_id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
