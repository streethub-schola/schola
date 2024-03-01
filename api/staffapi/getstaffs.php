<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
  
// initialize object
$student = new Student();

// read students will be here
// query students
$stmt = $student->getStudents();
    
if($stmt){

  
    // students array
    $students_arr=array();
    $students_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $student_item=array(
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
  
        array_push($students_arr["records"], $student_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show students data in json format
    echo json_encode(array("message"=>$students_arr, "status"=>1));
}
else{
    // no students found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the student no products found
    echo json_encode(array("message" => "No students found.", "status"=>0));
    
}
  

