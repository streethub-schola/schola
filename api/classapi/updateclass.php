<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// Student
$class = new Classes();

// get class_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valclass_id class_id
if (empty($data->class_id) || $data->class_id == null || $data->class_id == '' || !is_numeric($data->class_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid class_id", "status" => 2));

    return;
}

// Check for valid class_name to update
if (empty($data->class_name) || $data->class_name == null || $data->class_name == ' ') {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid class name", "status" => 2));

    return;
}

// set class_id property of class to be edited
$class->class_id = cleanData($data->class_id);
$class->class_name = cleanData($data->class_name);



// Get the class whose details are to be updated 
$class_stmt = $class->getClass();

if ($class_stmt['outputStatus'] == 1000) {

    $class_to_update = $class_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // If class does not exist
    if (!$class_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the class
        echo json_encode(array("message" => "No class found with this ID.", "status" => 0));

        return;
    }

   

    // update the class
    $updateStatus = $class->updateClass();

    if ($updateStatus['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the class
        echo json_encode(array("message" => "class was updated successfully.", "status" => 1));
        return;
    } 
    elseif ($updateStatus['outputStatus'] = 1200) {
        errorDiag($updateStatus['output']);
    }
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the class
        echo json_encode(array("message" => "Unable to update class. Please try again.", "status" => 2));
        return;
    }
} elseif ($class_stmt['outputStatus'] = 1200) {
    errorDiag($class_stmt['output']);
}
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the class
    echo json_encode(array("message" => "Unable to update class. Please try again.", "status" => 2));
    return;
}
