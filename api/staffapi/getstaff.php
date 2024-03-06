<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$staff = new Staff();

// var_dump($staff);
// return;

// read student id will be here
$staff_id = $_GET['staff_id'] ?? null;
$staff_no = $_GET['staff_no'] ?? null;

if ((empty($staff_id) || $staff_id == null || !is_numeric($staff_id) || $staff_id == '' || $staff_id == ' ') && (empty($staff_no) || $staff_no == null || $staff_no == '' || $staff_no == ' ')) {
    // No valid staff id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the staff no products found
    echo json_encode(
        array("message" => "Plaese provide a valid staff ID or staff number", "status" => 55)
    );

    return;
}

// query staffs
$staff->staff_id = $staff_id;
$staff->staff_no = $staff_no;

// var_dump($staff_id);
// var_dump($staff_staff_no);
// return;

$stmt = $staff->getStaff();
// var_dump($stmt);
// return;

// check if more than 0 record found
if ($stmt['outputStatus'] == 1000) {

    $fetched_staff = $stmt['output']->fetch(PDO::FETCH_ASSOC);

    if (!$fetched_staff) {

        // set response code - 200 OK
        http_response_code(404);

        if ($staff_id != null) {
            // show staffs data in json format
            echo json_encode(array("message" => "No staff found with this Staff ID.", "status" => 0));
        } elseif ($staff_no != null) {
            // show staffs data in json format
            echo json_encode(array("message" => "No staff found with this Staff Number.", "status" => 0));
        }

        return;
    }

   $fetched_staff['password'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
    // If successful 
    // set response code - 200 OK
    http_response_code(200);

    // show staffs data in json format
    echo json_encode(array("message" => $fetched_staff, "status" => 1));
    return;
} elseif ($stmt['outputStatus'] == 1200) {
    errorDiag($stmt['output']);
    return;
} else {
    // no staffs found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the staff no products found
    echo json_encode(array("message" => "Something went wrong. Not able to fetch staff.", "status" => 22));
}
