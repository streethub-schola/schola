<?php
class User
{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $firstname;
    public $lastname;
    public $password;
    public $user_code;
    public $active;
    public $created_at;
    public $updated_at;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // read a single user
    function readUser()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE id=" . $this->id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read users
    function readUsers()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // create user
    function createUser()
    {

        $this->user_code = substr(md5(time()), 0, 18);
        $this->verified = 0;
        $this->created_at = date("d-m-Y H:s:ia");
        $this->updated_at = date("d-m-Y H:s:ia");

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (firstname, lastname, email, user_code, verified, password, 
                    created_at, updated_at) VALUES (:firstname, :lastname, :email, :user_code, :verified, :password, 
                    :created_at, :updated_at) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":user_code", $this->user_code);
        $stmt->bindParam(":verified", $this->verified);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);



        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // update the product
    function updateUser()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    verified = :verified,
                    password = :password,
                    updated_at = :updated_at
                WHERE
                    id = :id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);


        // Set and sanitize
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->verified = htmlspecialchars(strip_tags($this->verified));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->updated_at = date('d-m-Y H:s:ia');

        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $update_stmt->bindParam(':firstname', $this->firstname);
        $update_stmt->bindParam(':lastname', $this->lastname);
        $update_stmt->bindParam(':email', $this->email);
        $update_stmt->bindParam(':verified', $this->verified);
        $update_stmt->bindParam(':password', $this->password);
        $update_stmt->bindParam(':updated_at', $this->updated_at);
        $update_stmt->bindParam(':id', $this->id);

        // execute the query
        if ($update_stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete a user
    function deleteUser()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Email verification handler
    public function emailVerify($evcode)
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    verified = 1
                WHERE
                    user_code = :user_code";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);


        // Set and sanitize
        $this->user_code = htmlspecialchars(strip_tags($this->user_code));

        // bind new values
        $update_stmt->bindParam(':user_code', $evcode);

        // execute the query
        if ($update_stmt->execute()) {
            return true;
        }

        return false;
    }

    // Login a user
    public function userLogin()
    {

        $sql = "SELECT * FROM $this->table_name WHERE email=:email";

        // prepare query statement
        $login_stmt = $this->conn->prepare($sql);

        // bind new values
        $login_stmt->bindParam(':email', $this->email);

        // execute the query
        if ($login_stmt->execute()) {

            $loggedInUser = $login_stmt->fetch(PDO::FETCH_ASSOC);

            if ($loggedInUser && password_verify($this->password, $loggedInUser['password'])) {
                $loggedInUser['password'] = "xxxxxxxxxxxxxxxxxx";
                $loggedInUser['user_code'] = password_hash($loggedInUser['user_code'], PASSWORD_DEFAULT);

                return $loggedInUser;
            }

            return [];
        } else {

            return false;
        }
    }

    // Reset user password
    public function forgetPassword()
    {
        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE email=:email";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);

        // execute query
        if ($stmt->execute()) {

            $resetUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resetUser) {

                $this->firstname = $resetUser['firstname'];

                // Update & refresh the User-code
                $this->user_code = substr(md5(time()), 0, 18);

                $upd_query = "UPDATE " . $this->table_name . " SET user_code=:user_code WHERE email=:email";

                // prepare query statement
                $update_stmt = $this->conn->prepare($upd_query);

                $update_stmt->bindParam(':email', $this->email);
                $update_stmt->bindParam(':user_code', $this->user_code);

                if ($update_stmt->execute()) {

                    return "user_code changed succesfully";

                    // Send new password link
                    $to = $this->email;

                    $subject = "FUELALERT: PASSWORD RESET CODE";

                    $message = "<h3>Dear $this->firstname,</h3>";
                    $message .= "<p>We welcome you warmly to our platform that 
                    help you save money by helping you to know the best filling stations to buy fuel cheaper in your area.</p><br>
                    <p>Below is your Password reset code: </p><br>
                    <h5>$this->user_code</h5><br>

                    <p>Warm Regards</p><p>FuelAlert Team</p>";

                    $header = "From:test@fuelalert.myf2.net \r\n";
                    //   $header .= "cc:iounachukwu@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                    $mailSent = mail($to, $subject, $message, $header);

                    // return $mailSent;
                    if ($mailSent) {
                        return "Your password reset code has been sent to your mail.";
                    } else {
                        return "Failed to reset password due to issues with your mail server. Please check your mail server and try again";
                    }
                } else {
                    return "User code updated failed. Try again";
                }
            } else {

                return "This user email is invalid";
            }
        } else {

            return "This Email is invalid";
        }
    }

    // Reset user password
    public function userPasswordReset()
    {
        return;
    }
}
