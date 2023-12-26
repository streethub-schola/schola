<?php
// include('../config/database.php');

class Student extends Database
{

    // database connection and table name
    // private $conn;
    private $table_name = "students";

    // object properties
    public $student_id;
    public $admin_no;
    public $firstname;
    public $lastname;
    public $dob;
    public $image;
    public $guardian_name;
    public $guardian_phone;
    public $guardian_email;
    public $guardian_address;
    public $guardian_rel;
    public $password;
    public $user_code;
    public $active;
    public $created_at;
    public $updated_at;

    // constructor with $db as database connection
    // public function __construct($db)
    // {
    //     $this->conn = $db;
    // }


    // read a single user
    function getStudent()
    {
        $query = '';

        if ($this->student_id != NULL) {

            // select query if student ID is provided
            $query = "SELECT student_id, admin_no, firstname, lastname, dob, image, guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, active, created_at, updated_at  FROM " . $this->table_name . " WHERE student_id=" . $this->student_id;

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt;
        } elseif ($this->admin_no != null) {

            // select query if student admin no is provided 
            $query = "SELECT student_id, admin_no, firstname, lastname, dob, image, guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, active, created_at, updated_at  FROM " . $this->table_name . " WHERE admin_no=:admin_no";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind values
            $stmt->bindParam(":admin_no", $this->admin_no);


            // execute query
            $stmt->execute();

            return $stmt;
        } else {

            return "No valid Student ID or Admission number provided";
        }
    }

    // read users
    function getStudents()
    {
        // select all query
        $query = "SELECT student_id, admin_no, firstname, lastname, dob, image, guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, active, created_at, updated_at  FROM " . $this->table_name;


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // create user
    function admitStudent()
    {
        // Generate and set new user code
        $this->generateCode();

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (admin_no, firstname, lastname, dob, image, guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, password, user_code) VALUES (:admin_no, :firstname, :lastname, :dob, :image, :guardian_name, :guardian_phone, :guardian_email, :guardian_address, :guardian_rel, :password, :user_code) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        $admission_no = "MIS/";

        // bind values
        $stmt->bindParam(":admin_no", $admission_no);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":guardian_name", $this->guardian_name);
        $stmt->bindParam(":guardian_phone", $this->guardian_phone);
        $stmt->bindParam(":guardian_email", $this->guardian_email);
        $stmt->bindParam(":guardian_address", $this->guardian_address);
        $stmt->bindParam(":guardian_rel", $this->guardian_rel);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":user_code", $this->user_code);


        try {
            // execute query
            if ($stmt->execute()) {

                $setId = $this->setLastStudentId($this->conn->lastInsertId());

                if (is_string($setId)) {
                    return $setId;
                } elseif ($setId) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    function generateCode()
    {
        $this->user_code = substr(md5(time()), 0, 18) . substr(md5(time()), 0, 18);

        return;
    }

    function setTimeNow()
    {
        $this->updated_at = date("Y:m:d H:i:sa");
        return;
    }

    function generateSessionCode()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
              user_code = :user_code,
              updated_at = :updated_at
          WHERE
              admin_no = :admin_no";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        $this->setTimeNow();

        // bind new values
        $update_stmt->bindParam(':admin_no', $this->admin_no);
        $update_stmt->bindParam(':user_code', $this->user_code);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        try {

            if ($update_stmt->execute()) return true;

            return false;

        } catch (Exception $e) {

            return $e->getMessage();

        }
     
    }


    // update the product
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


    // search for a particular in a given column
    function searchStudent($searchstring, $col)
    {
        // select all query
        $query = "SELECT student_id, admin_no, firstname, lastname, dob, image, guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, active, created_at, updated_at FROM " . $this->table_name . " WHERE " . $col . "=:searchstring";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        $update_stmt->bindParam(':searchstring', $searchstring);

        try {
            // execute query
            $update_stmt->execute();

            return $update_stmt;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


     // search for a particular in a given column
     function groupSearch($searchstring, $col)
     {

         // select all query
         $query = "SELECT student_id, admin_no, firstname, lastname, dob, 'image', guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, active, created_at, updated_at FROM " . $this->table_name . " WHERE $col LIKE '%$searchstring%'";

        //  $query = "SELECT * FROM $this->table_name WHERE $col LIKE '%$searchstring%'";

        
         // prepare query statement
         $update_stmt = $this->conn->prepare($query);
 
        //  $update_stmt->bindParam(':searchstring', $searchstring);
 
         try {

             // execute query
             $update_stmt->execute();

             return $update_stmt;

         } catch (Exception $e) {

             return $e->getMessage();

         }

     }


    // update the product
    function changePassword()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    password = :password,
                    updated_at = :updated_at
                WHERE
                    admin_no = :admin_no";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // Emcrypt password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // bind new values
        $update_stmt->bindParam(':admin_no', $this->admin_no);
        $update_stmt->bindParam(':password', $this->password);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        try {
            if ($update_stmt->execute()) return true;

            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // execute the query

    }


    // Email verification handler
    public function changeActiveStatus($evcode)
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    active = " . $evcode . " WHERE
                    admin_no = :admin_no";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':admin_no', $this->admin_no);

        try {
            // execute the query
            if ($update_stmt->execute()) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function studentLogin()
    {

        $sql = "SELECT * FROM $this->table_name WHERE admin_no=:admin_no";

        // prepare query statement
        $login_stmt = $this->conn->prepare($sql);

        // bind new values
        $login_stmt->bindParam(':admin_no', $this->admin_no);

        try {
            // execute the query
            if ($login_stmt->execute()) {

                return $login_stmt;
            } else {

                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    // read a single user
    function setLastStudentId($lastId)
    {
        $offsetId = $lastId + 13;
        // update query
        $query = "UPDATE " . $this->table_name . " SET
        admin_no = :admin_no WHERE student_id = :student_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        $admission_no = "";

        if ($lastId < 10) {
            $admission_no = "MIS/" . date("Y") . "/000" . $offsetId;
        } elseif ($lastId >= 10 && $lastId < 100) {
            $admission_no = "MIS/" . date("Y") . "/00" . $offsetId;
        } elseif ($lastId >= 100) {
            $admission_no = "MIS/" . date("Y") . "/0" . $offsetId;
        } else {
            $admission_no = "MIS/" . date("Y") . "/" . $offsetId;
        }

        // bind new values
        $update_stmt->bindParam(':student_id', $lastId);
        $update_stmt->bindParam(':admin_no', $admission_no);


        try {

            if ($update_stmt->execute()) return true;
            return false;

        } catch (Exception $e) {

            return $e->getMessage();

        }
    }


    // Verify password
    function verifyPass($user_pass, $db_pass)
    {

        if (password_verify($user_pass, $db_pass)) return true;

        return false;
    }
}
