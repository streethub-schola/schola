<?php

class Staff extends Database
{

    // database connection and table name
    // private $conn;
    private $table_name = "staffs";

    // object properties
    public $staff_id;
    public $staff_no;
    public $firstname;
    public $lastname;
    public $dob;
    public $image;
    public $address;
    public $phone;
    public $email;
    public $class_id;


    // Next of Kin info
    public $nok_name;
    public $nok_phone;
    public $nok_email;
    public $nok_address;
    public $nok_rel;

    // Guarantor info
    public $guarantor_name;
    public $guarantor_phone;
    public $guarantor_email;
    public $guarantor_address;
    public $guarantor_rel;

    public $rank;
    public $role;

    public $password;
    public $user_code;
    public $active;
    public $created_at;
    public $updated_at;

    // read a single user
    function getStaff()
    {

        if ($this->staff_id != NULL) {

            // select query if student ID is provided
            $query = "SELECT * FROM " . $this->table_name . " WHERE staff_id=:staff_id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind values
            $stmt->bindParam(":staff_id", $this->staff_id);

            try {
                // execute query
                $stmt->execute();

                return array("output" => $stmt, "outputStatus" => 1000);
            } catch (Exception $e) {
                return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
            }
        } elseif ($this->staff_no != null) {

            // select query if student staff no is provided 
            $query = "SELECT *  FROM " . $this->table_name . " WHERE staff_no=:staff_no";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // bind values
            $stmt->bindParam(":staff_no", $this->staff_no);


            try {
                // execute query
                $stmt->execute();

                return array("output" => $stmt, "outputStatus" => 1000);
            } catch (Exception $e) {
                return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
            }
        } else {

            return array("output" => "Please provide a valid Student ID or Admission number", "outputStatus" => 1400);
        }
    }

    // read users
    function getStaffs()
    {
        // select all query
        $query = "SELECT * FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        try {
            // execute query
            $stmt->execute();

            return array("output" => $stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "eror" => "Netork issue. Please try again.", "outputStatus" => 1200);
        }
    }


    // create user
    function createStaff()
    {
        // Generate and set defualt properties
        $this->staff_no = "MIS/TS/" . date("Y") . "/";
        $this->generateUserCode();

        // Generate new student default password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // var_dump($this);
        // return;

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (staff_no, firstname, lastname, dob, image, phone, email, address, class_id, nok_name, nok_phone, nok_email, nok_address, nok_rel, guarantor_name, guarantor_phone, guarantor_email, guarantor_address, guarantor_rel, rank, role, password, user_code) VALUES (:staff_no, :firstname, :lastname, :dob, :image, :phone, :email,:address, :class_id, :nok_name, :nok_phone, :nok_email, :nok_address, :nok_rel, :guarantor_name, :guarantor_phone, :guarantor_email, :guarantor_address, :guarantor_rel, :rank, :role,:password, :user_code) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":staff_no", $this->staff_no);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":class_id", $this->class_id);


        $stmt->bindParam(":nok_name", $this->nok_name);
        $stmt->bindParam(":nok_phone", $this->nok_phone);
        $stmt->bindParam(":nok_email", $this->nok_email);
        $stmt->bindParam(":nok_address", $this->nok_address);
        $stmt->bindParam(":nok_rel", $this->nok_rel);

        $stmt->bindParam(":guarantor_name", $this->guarantor_name);
        $stmt->bindParam(":guarantor_phone", $this->guarantor_phone);
        $stmt->bindParam(":guarantor_email", $this->guarantor_email);
        $stmt->bindParam(":guarantor_address", $this->guarantor_address);
        $stmt->bindParam(":guarantor_rel", $this->guarantor_rel);

        $stmt->bindParam(":rank", $this->rank);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":user_code", $this->user_code);


        try {
            // execute query
            if ($stmt->execute()) {
                $lastInsertedId = $this->conn->lastInsertId();
                $this->staff_id = $lastInsertedId;

                $staff_id_Set = $this->setLastStaffNo($lastInsertedId);

                if ($staff_id_Set) {
                    //   return $this;
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }



    // update the product
    function updateStaff()
    {
        $querystring = "";

        if ($this->staff_id != null) {
            $querystring = "staff_id=" . $this->staff_id;
        } else {
            $querystring = "staff_no=" . $this->staff_no;
        }


        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    staff_no = :staff_no,
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
                WHERE" . $querystring;

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':staff_no', $this->staff_no);
        $update_stmt->bindParam(':firstname', $this->firstname);
        $update_stmt->bindParam(':lastname', $this->lastname);
        $update_stmt->bindParam(':dob', $this->dob);
        $update_stmt->bindParam(':image', $this->image);
        // $update_stmt->bindParam(':guardian_name', $this->guardian_name);
        // $update_stmt->bindParam(':guardian_phone', $this->guardian_phone);
        // $update_stmt->bindParam(':guardian_email', $this->guardian_email);
        // $update_stmt->bindParam(':guardian_address', $this->guardian_address);
        // $update_stmt->bindParam(':guardian_rel', $this->guardian_rel);
        $update_stmt->bindParam(':updated_at', $this->updated_at);
        $update_stmt->bindParam(':staff_id', $this->staff_id);

        try {
            if ($update_stmt->execute()) return true;

            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // execute the query


    }

    // delete a user
    function deleteStaff()
    {
        $stmt = null;

        if ($this->staff_id != null) {
            // delete query
            $query = "DELETE FROM " . $this->table_name . " WHERE staff_id = ?";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // bind staff_id of record to delete
            $stmt->bindParam(1, $this->staff_id);
        } else {
            $query = "DELETE FROM " . $this->table_name . " WHERE staff_no = ?";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // bind staff_id of record to delete
            $stmt->bindParam(1, $this->staff_no);
        }

        try {
            // execute query
            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    // search for a particular in a given column
    function searchStaff($searchstring, $col)
    {
        // select all query
        $query = "SELECT staff_id, staff_no, firstname, lastname, dob, image, guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, active, created_at, updated_at EXCEPT password, user_code FROM " . $this->table_name . " WHERE '$col'=:searchstring";

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
        $query = "SELECT staff_id, staff_no, firstname, lastname, dob, 'image', guardian_name, guardian_phone, guardian_email, guardian_address, guardian_rel, active, created_at, updated_at FROM " . $this->table_name . " WHERE $col LIKE '%$searchstring%'";

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
                    staff_no = :staff_no";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // Emcrypt password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // bind new values
        $update_stmt->bindParam(':staff_no', $this->staff_no);
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
                    staff_no = :staff_no";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':staff_no', $this->staff_no);

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



    public function staffLogin()
    {

        $sql = "SELECT * FROM $this->table_name WHERE staff_no=:staff_no";

        // prepare query statement
        $login_stmt = $this->conn->prepare($sql);

        // bind new values
        $login_stmt->bindParam(':staff_no', $this->staff_no);

        try {
            // execute the query
            $login_stmt->execute();

            return array("output" => $login_stmt, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "error" => "Netork issue. Please try again.", "outputStatus" => 1200);
        }
    }


    function generateUserCode()
    {
        $this->user_code = substr(md5(time()), 0, 18) . substr(md5(time()), 0, 18);

        return;
    }

    function setTimeNow()
    {
        $this->updated_at = date("Y:m:d H:i:sa");
        return;
    }

    function regenerateUserCode()
    {
        // Generate new User Code
        $this->generateUserCode();

        // Capture current time
        $this->setTimeNow();

        // update query
        $query = "UPDATE " . $this->table_name . " SET
              user_code = :user_code,
              updated_at = :updated_at
          WHERE
              staff_no = :staff_no";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        // bind new values
        $update_stmt->bindParam(':staff_no', $this->staff_no);
        $update_stmt->bindParam(':user_code', $this->user_code);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        try {

            $result = $update_stmt->execute();

            return array("output" => $result, "outputStatus" => 1000);
        } catch (Exception $e) {
            return array("output" => $e->getMessage(), "error" => "Netork issue. Please try again.", "outputStatus" => 1200);
        }
    }



    // read a single user
    function setLastStaffNo($lastId)
    {
        $offsetId = $lastId + 13;
        // update query
        $query = "UPDATE " . $this->table_name . " SET
        staff_no = :staff_no WHERE staff_id = :staff_id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);

        $staff_no = "";

        if ($offsetId < 10) {
            $staff_no = "MIS/TS/" . date("Y") . "/000" . $offsetId;
        } elseif ($offsetId >= 10 && $offsetId < 100) {
            $staff_no = "MIS/TS/" . date("Y") . "/00" . $offsetId;
        } elseif ($offsetId >= 100) {
            $staff_no = "MIS/TS/" . date("Y") . "/0" . $offsetId;
        } else {
            $staff_no = "MIS/TS/" . date("Y") . "/" . $offsetId;
        }

        // bind new values
        $update_stmt->bindParam(':staff_id', $lastId);
        $update_stmt->bindParam(':staff_no', $staff_no);


        try {

            if ($update_stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


    // Verify password
    function verifyPass($user_pass, $hash_pass)
    {

        if (password_verify($user_pass, $hash_pass)){
            return true;
        } 

        return false;
    }


    // Auto generate new user password
    function genPass($pass)
    {
        $symbolsArray = ["!", "@", "#", "%", "&", "*"];
        return $pass . $symbolsArray[rand(0, 5)] . rand(1234, 9876);
    }
}
