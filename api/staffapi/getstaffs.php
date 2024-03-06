<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
  
// initialize object
$staff = new Staff();


// read staffs will be here
// query staffs
$stmt = $staff->getStaffs();

if($stmt['outputStatus'] == 1000){

  
    // staffs array
    $staffs_arr=array();
    $staffs_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt['output']->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $staff_item=array(
            "staff_id" => $staff_id,
            "staff_no" => $staff_no,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "dob" => $dob,
            "image" => $image,
            "address" => $address,
            "phone" => $phone,
            "email" => $email,
            "class_id" => $class_id,
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
            "rank" => $rank,
            "role" => $role,
            "active" => $active,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
        );
  
        array_push($staffs_arr["records"], $staff_item);
    }

    if (count($staffs_arr['records']) == 0) {
        // set response code - 200 OK
        http_response_code(404);

        // show staffs data in json format
        echo json_encode(array("message" => "No staff found.", "status"=>3));
       
        return;
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show staffs data in json format
    echo json_encode($staffs_arr);
}
elseif($stmt['outputStatus'] == 1200){
    errorDiag($stmt['output']);
    return;
}
else{
    // no staffs found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the staff no products found
    echo json_encode(
        array("message" => "No staffs found.", "status"=>0)
    );
}
  

