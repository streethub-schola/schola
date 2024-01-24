<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PATCH_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// Student
$class = new Classes();
  
// get class_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valclass_id class_id
if($data->class_id == null || $data->class_id == '' || !is_numeric($data->class_id)){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the user
      echo json_encode(array("message" => "Please provide a valid class_id", "status"=>2));

      return;
}
  
// set class_id property of class to be edited
$class->class_id = cleanData($data->class_id);

// var_dump($data);
// return;

// Get the class whose details are to be updated 
$class_stmt = $class->getClass();

    
$class_to_update = $class_stmt->fetch(PDO::FETCH_ASSOC);

// If class does not exist
if(!$class_to_update){
     // set response code - 200 ok
     http_response_code(404);
  
     // tell the class
     echo json_encode(array("message" => "No class found with this ID.", "status"=>0));

     return;
}

// If class with id exists
// set class property values
$class->class_name = (empty($data->class_name)  || $data->class_name == NULL || $data->class_name == "") ? $class_to_update['class_name'] : cleanData($data->class_name);
$class->class_level = (empty($data->class_level) || $data->class_level == NULL || $data->class_level == "") ? $class_to_update['class_level'] : cleanData($data->class_level);
$class->class_extension = (empty($data->class_extension) || $data->class_extension == NULL || $data->class_extension == "") ? $class_to_update['class_extension'] : cleanData($data->class_extension);

// var_dump($class);
// return;

// update the class
$updateStatus = $class->updateClass();




if($updateStatus){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the class
    echo json_encode(array("message" => "class was updated successfully.", "status"=>1));
    return;
}else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the class
    echo json_encode(array("message" => "Unable to update class. Please try again.", "status"=>2));
    return;
}

if(is_string($updateStatus)){
  
    // set response code - 200 ok
    http_response_code(400);
  
    // tell the class
    echo json_encode(array("message" =>$updateStatus, "status"=>3));
    return;
}


?>