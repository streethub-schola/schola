<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$class = new Classes();

$stmt = $class->getAllclasses();
// $num = $stmt->rowCount();

// check if more than 0 record found
if($stmt) {

    $result_class = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    if (count($result_class) == 0) {
        // set response code - 200 OK
        http_response_code(404);

        // show classs data in json format
        echo json_encode(array("message" => "No class found."));

        return;
    }

    // set response code - 200 OK
    http_response_code(200);

    // show classs data in json format
    echo json_encode($result_class);
    return;
} else {
    // no classs found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the class no products found
    echo json_encode(
        array("message" => "Something went wrong. Not able to fetch classes.")
    );
}
