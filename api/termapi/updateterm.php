<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// Term
$term = new Term();

// get term_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valterm_id term_id
if (empty($data->term_id) || $data->term_id == null || $data->term_id == '' || !is_numeric($data->term_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid term_id", "status" => 2));

    return;
}

// Check for valid term_name to update
if (empty($data->term_name) || $data->term_name == null || $data->term_name == ' ') {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid term name", "status" => 2));

    return;
}

// set term_id property of term to be edited
$term->term_id = cleanData($data->term_id);
$term->term_name = cleanData($data->term_name);



// Get the term whose details are to be updated 
$term_stmt = $term->getterm();

if ($term_stmt['outputStatus'] == 1000) {

    $term_to_update = $term_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // If term does not exist
    if (!$term_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the term
        echo json_encode(array("message" => "No term found with this ID.", "status" => 0));

        return;
    }

    // Check if new update is the same as current tern name
    // just send ok response : no need to waste broadband
    if ($term_to_update['term_name'] == $term->term_name) {
        // set response code - 200 ok
        http_response_code(202);

        // tell the term
        echo json_encode(array("message" => "Term was updated successfully.", "status" => 111));

        return;
    }
   

    // update the term
    $updateStatus = $term->updateterm();

    if ($updateStatus['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the term
        echo json_encode(array("message" => "Term was updated successfully.", "status" => 1));
        return;
    } 
    elseif ($updateStatus['outputStatus'] = 1200) {
        errorDiag($updateStatus['output']);
    }
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the term
        echo json_encode(array("message" => "Unable to update term. Please try again.", "status" => 2));
        return;
    }
} elseif ($term_stmt['outputStatus'] = 1200) {
    errorDiag($term_stmt['output']);
}
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the term
    echo json_encode(array("message" => "Unable to update term. Please try again.", "status" => 2));
    return;
}
