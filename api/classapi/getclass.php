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

// var_dump($class);
// return;

// read class id will be here
$class_id = $_GET['class_id'] ?? null;


if ((empty($class_id) || $class_id == null || !is_numeric($class_id) || $class_id=='' || $class_id==' ') && (empty($class_admin_no) || $class_admin_no == null || $class_admin_no=='' || $class_admin_no==' ')) {
    // No valid class id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the class no products found
    echo json_encode(
        array("message" => "Plaese provide a valid class ID")
    );

    return;
}

// query classs
$class->class_id = $class_id;

// var_dump($class_id);
// var_dump($class_admin_no);
// return;

$stmt = $class->getclass();
// $num = $stmt->rowCount();

// check if more than 0 record found
if($stmt) {

    $result_class = $stmt->fetch(PDO::FETCH_ASSOC);
    //  print_r(count($classs_arr['records']));
    //   return;
    if (count($result_class) == 0) {
        // set response code - 200 OK
        http_response_code(404);

        // show classs data in json format
        echo json_encode(array("message" => "No class found with this ID."));

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
        array("message" => "Something went wrong. Not able to fetch class.")
    );
}
