<?php

class UserAuth {
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