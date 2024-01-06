<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$DEL_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare user object
$student = new Student();
  
// get student id
$data = json_decode(file_get_contents("php://input"));
  
// set student id to be deleted
$student_id = cleanData($data->student_id);


// Restrict delete access for admin only
if(!isAdmin($data->role)){
      // set response code - 404 Not found
      http_response_code(403);
  
      // tell the student no products found
      echo json_encode(
          array("message" => "You dont have accessright to delete a student.")
      );
  
      return;

}

// Check if student_id provided is valid
if($student_id == null || !is_numeric($student_id) || $student_id == "" || $student_id == " " ){
    // No valid student id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the student no products found
    echo json_encode(
        array("message" => "Plaese provide a valid student ID")
    );

    return;
}

$student->student_id = $student_id;
// Check if student exists
$student_stmt = $student->getStudent();

$studentToDelete = $student_stmt->fetch(PDO::FETCH_ASSOC);

if(!$studentToDelete){
    // No valid student id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the student no products found
    echo json_encode(
        array("message" => "student with ID:$student_id does not exist")
    );

    return;
}
  
// delete the student
if($student->deleteStudent()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the student
    echo json_encode(array("message" => "student was deleted successfully."));
}
  
// if unable to delete the student
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the student
    echo json_encode(array("message" => "Unable to delete student."));
}
?>