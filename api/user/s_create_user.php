<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);

$user = new User($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->firstname) &&
    !empty($data->lastname) &&
    !empty($data->email) &&
    !empty($data->password)
){
  
    // Sanitize & set user property values
    $user->firstname = htmlspecialchars(strip_tags($data->firstname));
    $user->lastname = htmlspecialchars(strip_tags($data->lastname));
    $user->email = htmlspecialchars(strip_tags($data->email));
    $user->password = password_hash(htmlspecialchars(strip_tags($data->password)), PASSWORD_DEFAULT);
    // $user->user_code = substr(md5(time()), 0, 18);
    // $user->verified = 0;
    // $user->created_at = date("d-m-Y H:s:ia");
    // $user->updated_at = date("d-m-Y H:s:ia");

    // print_r($user->created_at);
    // return;
  
    // create the user
    if($user->createUser()){
  
        // Send welcome message and email verification code
        // $mail = new Mail();
        
        // $mail->to = $user->email;  //"oiunachukwu@gmail.com"; //This will be $user->email
        // $mail->message = "<h3>Dear $user->firstname,</h3><p>We welcome you warmly to our platform that 
        //                     help you save money by helping you to know the best filling stations to buy fuel cheaper in your area.</p><br>
        //                     <p>Kindly click on the email verification link below to complete your registration and start enjoying our services
        //                      for FREE.</p><br> <p>https://fuelalert/api/emailverification.php?evc=$user->user_code</p><br>
        //                         <p>Warm Regards</p><p>FuelAlert Team</p>";
        
        // $mail->sendMail();

        $to = $user->email;
        $subject = "WELCOME TO FUELALERT";

        $message = "<h3>Dear $user->firstname,</h3>";
        $message .= "<p>We welcome you warmly to our platform that 
                            help you save money by helping you to know the best filling stations to buy fuel cheaper in your area.</p><br>
                            <p>Kindly click on the email verification link below to complete your registration and start enjoying our services
                             for FREE.</p><br> <p>https://fuelalert.myf2.net/api/user/email_verification.php?evc=$user->user_code</p><br>
                                <p>Warm Regards</p><p>FuelAlert Team</p>";

        $header = "From:test@fuelalert.myf2.net \r\n";
     //   $header .= "Cc:iounachukwu@gmail.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

        $mailSent = mail ($to,$subject,$message,$header);

        /*
        if( $mailSent == true ) {
                echo "Message sent successfully...";
        }else {
                echo "Message could not be sent...";
        }
        */

        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "user was created. Please check your email for your verification link","mailSent"=>$mailSent));

    }
    else{

        // if unable to create the user, tell the user
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create user."));

    }

}
else{

    // tell the user data is incomplete
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));

}

