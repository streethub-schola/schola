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
    !empty($data->address)&& 
   	!empty($data->rank) && 
    !empty($data->role) 
      

   
) {
        
   

    // Generated and conserve new staff password
    $data->password = $staff->genPass($data->firstname);
    $staff->password = $data->password;


    // Sanitize & set staff property values
    $staff->firstname = cleanData($data->firstname);
    $staff->lastname = cleanData($data->lastname);
    $staff->dob = cleanData($data->dob);
    $staff->image = cleanData($data->image);
    $staff->phone = cleanData($data->phone);
    $staff->email = cleanData($data->email);
    $staff->address = cleanData($data->address);

    $staff->class_id = !empty($data->class_id) ? cleanData($data->class_id) : null;

    $staff->nok_name = !empty($data->nok_name) ? cleanData($data->nok_name) : null;
    $staff->nok_phone = !empty($data->nok_phone) ? cleanData($data->nok_phone) : null;
    $staff->nok_email = !empty($nok_email) ? cleanData($nok_email) : null;
    $staff->nok_address = !empty($nok_address) ? cleanData($nok_address) : null;
    $staff->nok_rel = !empty($data->nok_rel) ? cleanData($data->nok_rel) : null;

    $staff->guarantor_name = !empty($data->guarantor_name) ? cleanData($data->guarantor_name) : null;
    $staff->guarantor_phone = !empty($data->guarantor_phone) ? cleanData($data->guarantor_phone) : null;
    $staff->guarantor_email = !empty($data->guarantor_email) ? cleanData($data->guarantor_email) : null;
    $staff->guarantor_address = !empty($data->guarantor_address) ? cleanData($data->guarantor_address) : null;
    $staff->guarantor_rel = !empty($data->guarantor_rel) ? cleanData($data->guarantor_rel) : null;

    $staff->rank = !empty($data->rank) ? cleanData($data->rank) : null;
    $staff->role = !empty($data->role) ? cleanData($data->role) : null;

 //var_dump($staff);
 //return;

    // create the staff
    $newstaff_created = $staff->createStaff();
        
         //http_response_code(200);
		 //echo json_encode(array("message" => $newstaff_created, "status" => 0));
         //return;

     //var_dump($newstaff_created);
     //return;

   if ($newstaff_created) {

    $newStaff_stmt = $staff->getStaff();

    // var_dump($newStaff_stmt);
    // return;

    $newStaff = $newStaff_stmt['output']->fetch(PDO::FETCH_ASSOC);

    if(!$newStaff){
                // set response code - 201 created
                http_response_code(404);

                // tell the staff
                // echo json_encode(array("message" => "staff was created. Please check your email for your verification link","mailSent"=>$mailSent));
                echo json_encode(array("message" => "No staff was created. Please try again", "status" => 0));
                return;
        
    }

    $new_created_staff = ["staff_number"=>$newStaff['staff_no'],"staff_password"=>$data->password];
    // $newStaff['password'] = $data->password;


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
        echo json_encode(array("new_staff"=>$new_created_staff, "message" => "staff was created successfully", "status" => 1));
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
