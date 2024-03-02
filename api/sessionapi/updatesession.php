<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// session
$session = new Session();

// get session_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valsession_id session_id
if (empty($data->session_id) || $data->session_id == null || $data->session_id == '' || !is_numeric($data->session_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid session_id", "status" => 2));

    return;
}

// Check for valid session_name to update
if (empty(cleanData($data->session_name)) && empty(cleanData($data->strat_date)) && empty(cleanData($data->end_date))) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid session name", "status" => 2));

    return;
}


// set session_id property of session to be edited
$session->session_id = cleanData($data->session_id);
$session->session_name = cleanData($data->session_name);
$session->start_date = cleanData($data->start_date);
$session->end_date = cleanData($data->end_date);


// Get the session whose details are to be updated 
$session_stmt = $session->getSession();

if ($session_stmt['outputStatus'] == 1000) {

    $session_to_update = $session_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // If session does not exist
    if (!$session_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the session
        echo json_encode(array("message" => "No session found with this ID.", "status" => 0));

        return;
    }

    // Check if new update is the same as current tern name
    // just send ok response : no need to waste broadband
    if ($session_to_update['session_name'] == $session->session_name) {
        // set response code - 200 ok
        http_response_code(202);

        // tell the session
        echo json_encode(array("message" => "session was updated successfully.", "status" => 111));

        return;
    }
   

    // update the session
    $updateStatus = $session->updateSession();

    if ($updateStatus['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the session
        echo json_encode(array("message" => "session was updated successfully.", "status" => 1));
        return;
    } 
    elseif ($updateStatus['outputStatus'] = 1200) {
        errorDiag($updateStatus['output']);
        return;
    }
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the session
        echo json_encode(array("message" => "Unable to update session. Please try again.", "status" => 2));
        return;
    }
} elseif ($session_stmt['outputStatus'] = 1200) {
    errorDiag($session_stmt['output']);
    return;
}
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the session
    echo json_encode(array("message" => "Unable to update session. Please try again.", "status" => 2));
    return;
}
