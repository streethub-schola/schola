<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// Student
$subject = new Subject();

// get subject_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valsubject_id subject_id
if (empty($data->subject_id) || $data->subject_id == null || $data->subject_id == '' || !is_numeric($data->subject_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid subject_id", "status" => 2));

    return;
}

// Check for valsubject_id subject name or scode
if (empty($data->subject_name) && empty($data->subject_code)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid subject name or subject code", "status" => 2));

    return;
}

// set subject_id property of subject to be edited
$subject->subject_id = cleanData($data->subject_id);

// Get the subject whose details are to be updated 
$subject_stmt = $subject->getSubject();

if ($subject_stmt['outputStatus'] == 1000) {

    $subject_to_update = $subject_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // If subject does not exist
    if (!$subject_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the subject
        echo json_encode(array("message" => "No subject found with this ID.", "status" => 0));

        return;
    } elseif ($subject_to_update) {

        // If subject with id exists
        // set subject property values
        $subject->subject_name = (empty($data->subject_name)  || $data->subject_name == NULL || $data->subject_name == "") ? $subject_to_update['subject_name'] : cleanData($data->subject_name);
        $subject->subject_code = (empty($data->subject_code) || $data->subject_code == NULL || $data->subject_code == "") ? $subject_to_update['subject_code'] : cleanData($data->subject_code);

        // var_dump($subject);
        // return;

        // update the subject
        $updateStatus = $subject->updateSubject();
        // var_dump($updateStatus);
        // return;

        if ($updateStatus['outputStatus'] == 1000) {

            // set response code - 200 ok
            http_response_code(200);

            // tell the subject
            echo json_encode(array("message" => "subject was updated successfully.", "status" => 1));
            return;
        } elseif ($updateStatus['outputStatus'] == 1200) {

            errorDiag($updateStatus['output']);
        } else {

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the subject
            echo json_encode(array("message" => "Unable to update subject. Please try again.", "status" => 2));
            return;
        }
    } else {
        errorDiag($subject_stmt);
    }
} elseif ($subject_stmt['outputStatus'] == 1200) {
    errorDiag($subject_stmt['output']);
}
