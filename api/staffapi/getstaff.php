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
        array("message" => "Plaese provide a valid staff ID or staff number", "status"=>55)
    );

    return;
}

// query staffs
$staff->staff_id = $staff_id;
$staff->staff_no = $staff_no;

// var_dump($staff_id);
// var_dump($staff_staff_no);
// return;

$stmt = $staff->getstaff();
// $num = $stmt->rowCount();

// check if more than 0 record found
if (is_string($stmt)) {
    // set response code - 200 OK
    http_response_code(400);

    // show staffs data in json format
    echo json_encode(array("message" => $stmt, "status"=>44));

    return;
} elseif ($stmt) {

    // staffs array
    $staffs_arr = array();
    $staffs_arr["records"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $staff_item = array(

            "staff_id" => $staff_id,
            "staff_no" => $staff_no,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "dob" => $dob,
            "address" => $address,
            "phone" => $phone,
            "email" => $email,
            "nok_name" => $nok_name,
            "nok_phone" => $nok_phone,
            "nok_email" => $nok_email,
            "nok_address" => $nok_address,
            "nok_rel" => $nok_rel,
            "guarantor_name" => $guarantor_name,
            "guarantor_phone" => $guarantor_phone,
            "guarantor_email" => $guarantor_email,
            "guarantor_address" => $guarantor_address,
            "guarantor_rel" => $guarantor_rel,
            "role" => $role,
            "password" => $password,
            "user_code" => $user_code,
            "active" => $active,
            "created_at" => $created_at,
            "updated_at" => $updated_at,

        );

        array_push($staffs_arr["records"], $staff_item);
    }

    if (count($staffs_arr['records']) == 0) {

        // set response code - 200 OK
        http_response_code(200);

        if ($staff_id != null) {
            // show staffs data in json format
            echo json_encode(array("message" => "No staff found with this ID.", "status"=>0));
        } elseif ($staff_admin_no != null) {
            // show staffs data in json format
            echo json_encode(array("message" => "No staff found with this Admission Number.", "status"=>0));
        }

        return;
    }

    // set response code - 200 OK
    http_response_code(200);

    // show staffs data in json format
    echo json_encode(array("message"=>$staffs_arr, "status"=>1));

} else {
    // no staffs found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the staff no products found
    echo json_encode(array("message" => "Something went wrong. Not able to fetch staff.", "status"=>22));

}
