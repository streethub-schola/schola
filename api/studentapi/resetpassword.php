<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PATCH_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// Student
$student = new Student();
  
// get admin_no of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valid admin_no
if(empty($data->admin_no) || $data->admin_no == null || $data->admin_no == '' || $data->admin_no == ' '){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the user
      echo json_encode(array("message" => "Please provide a valid Student Admimission Number", "status"=>2));

      return;
}

// Check for valid new password
if(empty($data->password) || $data->password == null || $data->password == '' || $data->password == ' '){
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide the new password", "status"=>4));

    return;
}
  
// set properies of student to be edited
$student->admin_no = cleanData($data->admin_no);
$student->password = cleanData($data->password);
$student->updated_at = date("d-m-Y H:s:ia");



$searchCol = "admin_no";
$searchDesc = "Admission Number";

// Get the student whose details are to be updated 
$student_stmt = $student->searchStudent($student->admin_no, $searchCol);

// Catch db error
if(is_string($student_stmt)){
    // set response code - 200 ok
    http_response_code(403);
 
    // tell the student
    echo json_encode(array("message" => $student_stmt, "status"=>22));

    return;
}
    
$student_to_update = $student_stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($student_to_update);
// return;

if(!$student_to_update){
     // set response code - 200 ok
     http_response_code(404);
  
     // tell the student
     echo json_encode(array("message" => "No student found with this $searchDesc", "status"=>0));

     return;
}

// If student with id exists
// set student property values

// update the student
$updateStatus = $student->changePassword();

if(is_string($updateStatus)){
  
    // set response code - 200 ok
    http_response_code(400);
  
    // tell the student
    echo json_encode(array("message" =>$updateStatus, "status"=>23));
    return;
}
elseif($updateStatus){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the student
    echo json_encode(array("message" => "student password was updated successfully.", "status"=>1));
}else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the student
    echo json_encode(array("message" => "Unable to update student password. Please try again.", "status"=>2));
}


?>