<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $DEL_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// prepare user object
$class = new Classes();

// get class id
// read class id will be here
$class_id = null;

if (!empty($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
} else {


    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->class_id)) {
        $class_id = $data->class_id;
    }
}

// set class id to be deleted
$class_id = cleanData($class_id);

// Check for role
if (empty($data->role)) {
    // set response code - 404 Not found
    http_response_code(403);

    // tell the class no products found
    echo json_encode(
        array("message" => "You dont have access right to delete a class.", "status" => 4)
    );

    return;
}

// Restrict delete access for admin only
if (!isAdmin($data->role)) {
    // set response code - 404 Not found
    http_response_code(403);

    // tell the class no products found
    echo json_encode(
        array("message" => "You dont have access right to delete a class.", "status" => 3)
    );

    return;
}

// Check if class_id provided is valid
if ($class_id == null || !is_numeric($class_id) || $class_id == "" || $class_id == " ") {
    // No valid class id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the class no products found
    echo json_encode(
        array("message" => "Plaese provide a valid class ID", "status" => 2)
    );

    return;
}

$class->class_id = $class_id;
// Check if class exists
$class_stmt = $class->getClass();

if ($class_stmt['outputStatus'] == 1000) {

    $class_exists = $class_stmt['output']->fetch(PDO::FETCH_ASSOC);

    if (!$class_exists) {
        // No valid class id provided

        // set response code - 404 Not found
        http_response_code(404);

        // tell the class no products found
        echo json_encode(
            array("message" => "No class found", "status" => 0)
        );

        return;
    }

    // delete the class
    $class_deleted = $class->deleteClass();

    if ($class_deleted['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the class
        echo json_encode(array("message" => "class was deleted successfully.", "status" => 1));
    } elseif ($class_deleted['outputStatus'] == 1200) {

        errorDiag($class_deleted['output']);
        return;
        
    } else {
        // if unable to delete the class

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the class
        echo json_encode(array("message" => "Unable to delete class. Please try again", "status" => 2));
    }
} elseif ($class_stmt['outputStatus'] == 1200) {
    errorDiag($class_stmt['output']);
    return;
} else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the class
    echo json_encode(array("message" => "Unable to delete class. Please try again", "status" => 5));
}
