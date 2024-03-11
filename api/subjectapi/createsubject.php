<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$subject = new Subject();


// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;


// make sure data is not empty
if (
    !empty($data->subject_name) && !empty($data->subject_code)
) {

    if ($data->subject_name == " " || $data->subject_code == " ") {

        // set response code - 201 created
        http_response_code(201);

        // tell the subject
        // echo json_encode(array("message" => "subject was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "Unable to create. Please fill all fields", "status" => 33));
        return;
    }

    // Sanitize & set subject property values
    $subject->subject_name = ucfirst(cleanData($data->subject_name));
    $subject->subject_code = strtoupper(cleanData($data->subject_code));

    // create the subject
    $newsubject = $subject->createSubject();

    if ($newsubject['outputStatus'] == 1000) {

        // set response code - 201 created
        http_response_code(201);

        // tell the subject
        // echo json_encode(array("message" => "subject was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "subject was created successfully", "status" => 1));
        return;
    } elseif ($newsubject['outputStatus'] == 1200) {
        errorDiag($newsubject['output']);
        return;
    }
} else {

    // tell the subject data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the subject
    echo json_encode(array("message" => "Unable to create subject. Fill all fields.", "status" => 3));
    return;
}
