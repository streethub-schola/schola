<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$assignment = new Assignment();

// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;
http_response_code(201);
echo json_encode(array("message" => $data, "status" => 1));
return;

// make sure data is not empty
if (
    !empty($data->class_id) || !empty($data->subject_id) || !empty($data->term_id) || !empty($data->session_id) || !empty($data->staff_id)
) {

    // Sanitize & set assignment property values
    $assignment->class_id = cleanData($data->class_id);
    $assignment->subject_id = cleanData($data->subject_id);
    $assignment->term_id = cleanData($data->term_id);
    $assignment->session_id = cleanData($data->session_id);
    $assignment->staff_id = cleanData($data->staff_id);
    $assignment->assignment = cleanData($data->assignment);

    // create the assignment
    $newassignment = $assignment->createAssignment();

    // var_dump($newassignment);
    // return;

    if ($newassignment['outputStatus'] == 1000) {

        // set response code - 201 created
        http_response_code(201);

        // tell the assignment
        // echo json_encode(array("message" => "assignment was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "assignment was created successfully", "status" => 1));
        return;
    }
    elseif ($newassignment['outputStatus'] == 1200) {

        errorDiag($newassignment['output']);
        return;
    }
    else {
        // set response code - 200 ok
        http_response_code(400);

        // tell the assignment
        echo json_encode(array("message" => $newassignment['output'], "status" => 0));
        return;
    }
    
} else {

    // tell the assignment data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the assignment
    echo json_encode(array("message" => "Unable to create assignment. Fill all fields.", "status" => 2));
    return;

}


