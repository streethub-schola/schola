<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$session = new session();


// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// make sure data is not empty
if (
    !empty($data->session_name) &&
    !empty($data->start_date) &&
    !empty($data->end_date)
) {

    // Sanitize & set session property values
    $session->session_name = cleanData($data->session_name);
    $session->start_date = cleanData($data->start_date);
    $session->end_date = cleanData($data->end_date);


    // create the session
    $newsession = $session->createSession();

    // var_dump($newsession);
    // return;

    if ($newsession['outputStatus'] == 1000) {

        // set response code - 201 created
        http_response_code(201);

        // tell the session
        // echo json_encode(array("message" => "session was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "session was created successfully", "status" => 1));
        return;
    }
    elseif ($newsession['outputStatus'] == 1200) {

        errorDiag($newsession['output']);
    }
    else {
        // set response code - 200 ok
        http_response_code(400);

        // tell the session
        echo json_encode(array("message" => $newsession['output'], "status" => 0));
        return;
    }
    
} else {

    // tell the session data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the session
    echo json_encode(array("message" => "Unable to create session. Fill all fields.", "status" => 2));
    return;
}
