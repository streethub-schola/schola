<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$staff = new Staff();


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
    !empty($data->phone) &&
    !empty($data->email) &&
    !empty($data->address) && 
    !empty($data->password)
   
) {

    // Sanitize & set staff property values
    $staff->firstname = cleanData($data->firstname);
    $staff->lastname = cleanData($data->lastname);
    $staff->dob = cleanData($data->dob);
    $staff->image = cleanData($data->image);
    $staff->phone = cleanData($data->phone);
    $staff->email = cleanData($data->email);
    $staff->address = cleanData($data->address);

    $staff->nok_name = !empty($data->nok_name) ?? cleanData($data->nok_name) ?? null;
    $staff->nok_phone = !empty($data->nok_phone) ?? cleanData($data->nok_phone) ?? null;
    $staff->nok_email = !empty($nok_email) ?? cleanData($nok_email) ?? null;
    $staff->nok_address = !empty($nok_address) ?? cleanData($nok_address) ?? null;
    $staff->nok_rel = !empty($data->nok_rel) ?? cleanData($data->nok_rel) ?? null;

    $staff->guarantor_name = !empty($data->guarantor_name) ?? cleanData($data->guarantor_name) ?? null;
    $staff->guarantor_phone = !empty($data->guarantor_phone) ?? cleanData($data->guarantor_phone) ?? null;
    $staff->guarantor_email = !empty($data->guarantor_email) ?? cleanData($data->guarantor_email) ?? null;
    $staff->guarantor_address = !empty($data->guarantor_address) ?? cleanData($data->guarantor_address) ?? null;
    $staff->guarantor_rel = !empty($data->guarantor_re) ?? cleanData($data->guarantor_re) ?? null;

    $staff->password = cleanData($data->password);

    // print_r($staff);
    // return;

    // create the staff
    $newstaff = $staff->createStaff();

    var_dump($newstaff);
    return;

    if (is_string($newstaff)) {
        // set response code - 200 ok
        http_response_code(400);

        // tell the staff
        echo json_encode(array("message" => $newstaff, "status" => 3));
        return;
    }
    elseif ($newstaff) {

        // Send welcome message and email verification code
        // $mail = new Mail();

        // $mail->to = $staff->email;  //"oiunachukwu@gmail.com"; //This will be $staff->email
        // $mail->message = "<h3>Dear $staff->firstname,</h3><p>We welcome you warmly to our platform that 
        //                     help you save money by helping you to know the best filling stations to buy fuel cheaper in your area.</p><br>
        //                     <p>Kindly click on the email verification link below to complete your registration and start enjoying our services
        //                      for FREE.</p><br> <p>https://fuelalert/api/emailverification.php?evc=$staff->staff_code</p><br>
        //                         <p>Warm Regards</p><p>FuelAlert Team</p>";

        // $mail->sendMail();


        // using mailto inbuilt function
        //     $to = $staff->email;
        //     $subject = "WELCOME TO FUELALERT";

        //     $message = "<h3>Dear $staff->firstname,</h3>";
        //     $message .= "<p>We welcome you warmly to our platform that 
        //                         help you save money by helping you to know the best filling stations to buy fuel cheaper in your area.</p><br>
        //                         <p>Kindly click on the email verification link below to complete your registration and start enjoying our services
        //                          for FREE.</p><br> <p>https://fuelalert.myf2.net/api/staff/email_verification.php?evc=$staff->staff_code</p><br>
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

        // tell the staff
        // echo json_encode(array("message" => "staff was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "staff was created successfully", "status" => 1));
        return;
        
    } else {

        // if unable to create the staff, tell the staff

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the staff
        echo json_encode(array("message" => "Unable to create staff. Try again.", "status" => 2));
        return;

    }

} else {

    // tell the staff data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the staff
    echo json_encode(array("message" => "Unable to create staff. Fill all fields.", "status" => 3));

}
