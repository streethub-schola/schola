<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// Student
$assignment = new Assignment();

// get assignment_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valassignment_id assignment_id
if (empty($data->assignment_id) || $data->assignment_id == null || $data->assignment_id == ' ' || !is_numeric($data->assignment_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid assignment id", "status" => 2));

    return;
}

// set assignment_id property of assignment to be edited
$assignment->assignment_id = cleanData($data->assignment_id);

// Get the assignment whose details are to be updated 
$assignment_stmt = $assignment->getAssignment();

if ($assignment_stmt['outputStatus'] == 1000) {

    $assignment_to_update = $assignment_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // var_dump($assignment_to_update);
    // return;

    // If assignment does not exist
    if (!$assignment_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the assignment
        echo json_encode(array("message" => "No assignment found with this ID.", "status" => 0));

        return;
    }

    $assignment->class_id = empty($data->class_id) ? $assignment_to_update['class_id'] : cleanData($data->class_id);
    $assignment->subject_id = empty($data->subject_id) ? $assignment_to_update['subject_id'] :  cleanData($data->subject_id);
    $assignment->term_id = empty($data->term_id) ? $assignment_to_update['term_id'] :  cleanData($data->term_id);
    $assignment->session_id = empty($data->session_id) ? $assignment_to_update['session_id'] :  cleanData($data->session_id);
    $assignment->staff_id = empty($data->staff_id) ? $assignment_to_update['staff_id'] :  cleanData($data->staff_id);

    $assignment->assignment = empty($data->assignment) ? $assignment_to_update['assignment'] :  cleanData($data->assignment);

    // update the assignment
    $updateStatus = $assignment->updateAssignment();

    if ($updateStatus['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the assignment
        echo json_encode(array("message" => "assignment was updated successfully.", "status" => 1));
        return;
    } 
    elseif ($updateStatus['outputStatus'] = 1200) {
        errorDiag($updateStatus['output']);
        return;
    }
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the assignment
        echo json_encode(array("message" => "Unable to update assignment. Please try again.", "status" => 2));
        return;
    }
} elseif ($assignment_stmt['outputStatus'] = 1200) {
    errorDiag($assignment_stmt['output']);
    return;
}
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the assignment
    echo json_encode(array("message" => "Unable to update assignment. Please try again.", "status" => 2));
    return;
}
