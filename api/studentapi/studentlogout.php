<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);



// prepare product object
$student = new Student();

// get id of student to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if (empty($data->admin_no) || $data->admin_no == null || $data->admin_no == ''  || $data->admin_no == ' ') {
    // set response code - 503 service unavailable
    http_response_code(401);

    // tell the student
    echo json_encode(array("message" => "Please provide both valid student Admission Nunber", "status"=>5));

    return;
}

// Sanitize and set student property values
$student->admin_no = cleanData($data->admin_no);

// Check if student with this login details exists
$logout_stmt = $student->studentLogout();


// Handle string return
if (is_string($logout_stmt)) {

    // set response code - 200 ok
    http_response_code(400);

    // tell the student
    echo json_encode(array("message" => $logout_stmt, "status" => 4));
    return;
} elseif ($logout_stmt) {

    // set response code - 503 service unavailable
    http_response_code(200);

    echo json_encode(array("message" => "true", "status" => 1));
    return;

} else {
    // if student does not exist

    // set response code - 503 service unavailable
    http_response_code(400);

    // tell the student
    echo json_encode(array("message" => "false", "status" => 2));
    return;

}
