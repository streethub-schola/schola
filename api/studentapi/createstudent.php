<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$student = new Student();


// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// make sure data is not empty
if (
    !empty($data->firstname) &&
    !empty($data->lastname) &&
    !empty($data->dob) &&
    !empty($data->image) &&
    !empty($data->guardian_name) &&
    !empty($data->guardian_phone) &&
    !empty($data->guardian_address) &&
    !empty($data->guardian_rel) &&
    !empty($data->password)
) {

    // Sanitize & set student property values
    $student->firstname = cleanData($data->firstname);
    $student->lastname = cleanData($data->lastname);
    $student->dob = cleanData($data->dob);
    $student->image = cleanData($data->image);
    $student->guardian_name = cleanData($data->guardian_name);
    $student->guardian_phone = cleanData($data->guardian_phone);
    $guardian_email = $data->guardian_email ?? null;
    $student->guardian_email = cleanData($guardian_email);

    $student->guardian_address = cleanData($data->guardian_address);
    $student->guardian_rel = cleanData($data->guardian_rel);
    $student->password = password_hash(cleanData($data->password), PASSWORD_DEFAULT);
    $student->generateCode();
    // $student->created_at = date("d-m-Y H:s:ia");
    // $student->updated_at = date("d-m-Y H:s:ia");

    // print_r($student);
    // return;

    // create the student
    $newStudent = $student->admitStudent();

    // var_dump($newStudent);
    // return;

    if (is_string($newStudent)) {
        // set response code - 200 ok
        http_response_code(400);

        // tell the student
        echo json_encode(array("message" => $newStudent, "status" => 3));
        return;
    }
    elseif ($newStudent) {

        // Send welcome message and email verification code
        // $mail = new Mail();

        // $mail->to = $student->email;  //"oiunachukwu@gmail.com"; //This will be $student->email
        // $mail->message = "<h3>Dear $student->firstname,</h3><p>We welcome you warmly to our platform that 
        //                     help you save money by helping you to know the best filling stations to buy fuel cheaper in your area.</p><br>
        //                     <p>Kindly click on the email verification link below to complete your registration and start enjoying our services
        //                      for FREE.</p><br> <p>https://fuelalert/api/emailverification.php?evc=$student->student_code</p><br>
        //                         <p>Warm Regards</p><p>FuelAlert Team</p>";

        // $mail->sendMail();


        // using mailto inbuilt function
        //     $to = $student->email;
        //     $subject = "WELCOME TO FUELALERT";

        //     $message = "<h3>Dear $student->firstname,</h3>";
        //     $message .= "<p>We welcome you warmly to our platform that 
        //                         help you save money by helping you to know the best filling stations to buy fuel cheaper in your area.</p><br>
        //                         <p>Kindly click on the email verification link below to complete your registration and start enjoying our services
        //                          for FREE.</p><br> <p>https://fuelalert.myf2.net/api/student/email_verification.php?evc=$student->student_code</p><br>
        //                             <p>Warm Regards</p><p>FuelAlert Team</p>";

        //     $header = "From:test@fuelalert.myf2.net \r\n";
        //  //   $header .= "Cc:iounachukwu@gmail.com \r\n";
        //     $header .= "MIME-Version: 1.0\r\n";
        //     $header .= "Content-type: text/html\r\n";

        //     $mailSent = mail ($to,$subject,$message,$header);

        /*
        if( $mailSent == true ) {
                echo "Message sent successfully...";
        }else {
                echo "Message could not be sent...";
        }
        */

        // set response code - 201 created
        http_response_code(201);

        // tell the student
        // echo json_encode(array("message" => "student was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "student was created successfully", "status" => 1));
        return;
    } else {

        // if unable to create the student, tell the student

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the student
        echo json_encode(array("message" => "Unable to create student. Try again.", "status" => 2));
        return;
    }
} else {

    // tell the student data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the student
    echo json_encode(array("message" => "Unable to create student. Fill all fields.", "status" => 3));
}
