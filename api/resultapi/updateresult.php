<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// Student
$result = new Result();

// get result_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valresult_id result_id
if (empty($data->result_id) || $data->result_id == null || $data->result_id == ' ' || !is_numeric($data->result_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid result_id", "status" => 2));

    return;
}

// set result_id property of result to be edited
$result->result_id = cleanData($data->result_id);
$result->class_id = cleanData($data->class_id);
$result->subject_id = cleanData($data->subject_id);
$result->term_id = cleanData($data->term_id);
$result->session_id = cleanData($data->session_id);
$result->staff_id = cleanData($data->staff_id);

$result->result = cleanData($data->result);

// Get the result whose details are to be updated 
$result_stmt = $result->getresult();

if ($result_stmt['outputStatus'] == 1000) {

    $result_to_update = $result_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // var_dump($result_stmt);
    // return;

    // If result does not exist
    if (!$result_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the result
        echo json_encode(array("message" => "No result found with this ID.", "status" => 0));

        return;
    }

    // update the result
    $updateStatus = $result->updateresult();

    if ($updateStatus['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the result
        echo json_encode(array("message" => "result was updated successfully.", "status" => 1));
        return;
    } 
    elseif ($updateStatus['outputStatus'] = 1200) {
        errorDiag($updateStatus['output']);
        return;
    }
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the result
        echo json_encode(array("message" => "Unable to update result. Please try again.", "status" => 2));
        return;
    }
} elseif ($result_stmt['outputStatus'] = 1200) {
    errorDiag($result_stmt['output']);
    return;
}
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the result
    echo json_encode(array("message" => "Unable to update result. Please try again.", "status" => 2));
    return;
}
