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

// Check for valid session_id
if (empty($data->session_id) || $data->session_id == null || $data->session_id == ' ' || !is_numeric($data->session_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid session_id", "status" => 2));

    return;
}

// Check for valid term_id session_id
if (empty($data->term_id) || $data->term_id == null || $data->term_id == ' ' || !is_numeric($data->term_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid term_id", "status" => 2));

    return;
}

// set session_id property of session to be edited
$session->session_id = cleanData($data->session_id);
$session->term_id = cleanData($data->term_id);


// Get the session whose details are to be updated 
$session_stmt = $session->getCurrentSession();

if ($session_stmt['outputStatus'] == 1000) {

    $session_to_update = $session_stmt['output']->fetchAll(PDO::FETCH_ASSOC);


    // If session does not exist
    if (count($session_to_update) == 0) {

        // var_dump("inside zero");
        // var_dump($session_to_update);
        // return;

        // Insert into the tabel as table is empty
        $insert_stmt = $session->insertCurrentSession();

        if ($insert_stmt['outputStatus'] == 1000) {

            // set response code - 200 ok
            http_response_code(200);

            // tell the session
            echo json_encode(array("message" => "session was set successfully.", "status" => 1));
            return;
        } elseif ($insert_stmt['outputStatus'] = 1200) {
            errorDiag($insert_stmt['output']);
        } else {

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the session
            echo json_encode(array("message" => "Unable to update session. Please try again.", "status" => 2));
            return;
        }
    }



    // update the session
    $update_stmt = $session->updateCurrentSession();

    if ($update_stmt['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the session
        echo json_encode(array("message" => "session was updated successfully.", "status" => 1));
        return;
    } elseif ($update_stmt['outputStatus'] = 1200) {
        errorDiag($update_stmt['output']);
    } else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the session
        echo json_encode(array("message" => "Unable to update session. Please try again.", "status" => 2));
        return;
    }
} elseif ($session_stmt['outputStatus'] = 1200) {
    errorDiag($session_stmt['output']);
} else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the session
    echo json_encode(array("message" => "Unable to update session. Please try again.", "status" => 2));
    return;
}
