<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$result = new Result();

// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// make sure data is not empty
if (
    !empty($data->class_id) || !empty($data->subject_id) || !empty($data->term_id) || !empty($data->session_id) || !empty($data->staff_id)
) {

    // Sanitize & set result property values
    $result->class_id = cleanData($data->class_id);
    $result->subject_id = cleanData($data->subject_id);
    $result->term_id = cleanData($data->term_id);
    $result->session_id = cleanData($data->session_id);
    $result->staff_id = cleanData($data->staff_id);
    $result->result = cleanData($data->result);

    // create the result
    $newresult = $result->createresult();

    // var_dump($newresult);
    // return;

    if ($newresult['outputStatus'] == 1000) {

        // set response code - 201 created
        http_response_code(201);

        // tell the result
        // echo json_encode(array("message" => "result was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "result was created successfully", "status" => 1));
        return;
    }
    elseif ($newresult['outputStatus'] == 1200) {

        errorDiag($newresult['output']);
    }
    else {
        // set response code - 200 ok
        http_response_code(400);

        // tell the result
        echo json_encode(array("message" => $newresult['output'], "status" => 0));
        return;
    }
    
} else {

    // tell the result data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the result
    echo json_encode(array("message" => "Unable to create result. Fill all fields.", "status" => 2));
    return;
}
