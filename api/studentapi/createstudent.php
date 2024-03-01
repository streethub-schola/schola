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
    !empty($data->class) &&
    !empty($data->guardian_name) &&
    !empty($data->guardian_phone) &&
    !empty($data->guardian_address) &&
    !empty($data->guardian_rel)
) {

    // Generate new student default password
    $data->password = $student->genPass($data->firstname);

    // Sanitize & set student property values
    $student->firstname = cleanData($data->firstname);
    $student->lastname = cleanData($data->lastname);
    $student->dob = cleanData($data->dob);
    $student->image = cleanData($data->image);

    $student->class = cleanData($data->class);

    $student->guardian_name = cleanData($data->guardian_name);
    $student->guardian_phone = cleanData($data->guardian_phone);

    $guardian_email = empty($data->guardian_email) ? null : $data->guardian_email;

    $student->guardian_email = cleanData($guardian_email);

    $student->guardian_address = cleanData($data->guardian_address);
    $student->guardian_rel = cleanData($data->guardian_rel);
    $student->password = password_hash(cleanData($data->password), PASSWORD_DEFAULT);
    $student->generateCode();


    // create the student
    $newStudent = $student->admitStudent();
    // var_dump($newStudent);
    // return;

    if ($newStudent['outputStatus'] == 1000) {

        $newStudentDetails = $newStudent['output']->fetch(PDO::FETCH_ASSOC);

        // Send welcome message and email verification code
        // $mail = new Mail();
        $mailSent = false;

        if ($guardian_email != null) {

            $studentAdminNo = $newStudentDetails['admin_no'];

            // $mail->to = "oiunachukwu@gmail.com";  // $student->guardian_email;  //"oiunachukwu@gmail.com"; //This will be $student->email
            // $mail->message = "<h3>Dear $student->firstname,</h3><p>We are so happy to annouce to you that you have passed all statutory requirement with flying colours and You have been offered admission into our noble school.</p><br>
            //                 <p>Kindly visit our online website at https://schola-2.myf2.net/public.</p><br> 
            //                 <p>Your login details arr below:</p><br>
            //                 <p>Admission Number : $studentAdminNo</p><br>
            //                 <p>Password : $data->password</p><br>
            //                     <p>Warm Regards</p>
            //                     <p>Schola Team</p>";

            // $mail->sendMail();


            // using mailto inbuilt function
            $to = "oiunachukwu@gmail.com";  // $student->guardian_email;
            $subject = "WELCOME TO SCHOLA";

            $message = "<h3>Dear $student->firstname,</h3>";
            $message .= "<h3>Dear $student->firstname,</h3>";
            $message .= "<p>We are so happy to annouce to you that you have passed all statutory requirement with flying colours and You have been offered admission into our noble school.</p><br>";
            $message .=  "<p>Kindly visit our online website at https://schola-2.myf2.net/public.</p><br> ";
            $message .= "<p>Your login details arr below:</p><br>";
            $message .= "<p>Admission Number : $studentAdminNo</p><br>";
            $message .= "<p>Password : $data->password</p><br>";
            $message .=  ` <p>Warm Regards</p>
                                <p>Schola Team</p>`;

            $header = "From:test@fuelalert.myf2.net \r\n";
            $header .= "Cc:iounachukwu@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $mailSent = mail($to, $subject, $message, $header);

            /*
        if( $mailSent == true ) {
                echo "Message sent successfully...";
        }else {
                echo "Message could not be sent...";
        }
        */
        }
        // set response code - 201 created
        http_response_code(201);

        // tell the student
        // echo json_encode(array("message" => "student was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array(
            "message" => "New student was created successfully",
            "newstudent" => $newStudentDetails,
            "newpassword" => $data->password,
            "mailSent" => $mailSent,
            "status" => 1
        ));
        return;
    } 
    elseif ($newStudent['outputStatus'] == 1200) {
        errorDiag($newStudent['output']);
    }
    else {

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
    echo json_encode(array("message" => "Unable to create student. Fill all fields.", "status" => 4));
    return;
}
