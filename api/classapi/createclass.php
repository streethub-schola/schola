<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$class = new Classes();


// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// make sure data is not empty
if (
    !empty($data->class_name) &&
    !empty($data->class_level)
) {

    // Sanitize & set class property values
    $class->class_name = cleanData($data->class_name);
    $class->class_level = cleanData($data->class_level);
    $class->class_extension = $data->class->class_extension ?? null;

    // create the class
    $newclass = $class->createClass();

    // var_dump($newclass);
    // return;

    if ($newclass) {


        // set response code - 201 created
        http_response_code(201);

        // tell the class
        // echo json_encode(array("message" => "class was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "class was created successfully", "status" => 1));
        return;
    } elseif(!$newclass) {

        // if unable to create the class, tell the class

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the class
        echo json_encode(array("message" => "Unable to create class. Try again.", "status" => 0));
        return;
    }
    else {
        // set response code - 200 ok
        http_response_code(400);

        // tell the class
        echo json_encode(array("message" => $newclass, "status" => 2));
        return;
    }
    
} else {

    // tell the class data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the class
    echo json_encode(array("message" => "Unable to create class. Fill all fields.", "status" => 3));
    return;
}
