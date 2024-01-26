<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$DEL_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare user object
$class = new Classes();
  
// get class id
// read class id will be here
$class_id = null;

if (!empty($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
}
else{


$data = json_decode(file_get_contents("php://input"));

if (!empty($data->class_id)) {
    $class_id = $data->class_id;
}
}
  
// set class id to be deleted
$class_id = cleanData($class_id);

if(empty($data->role)){
     // set response code - 404 Not found
     http_response_code(403);
  
     // tell the class no products found
     echo json_encode(
         array("message" => "You dont have access right to delete a class.")
     );
 
     return;
}

// Restrict delete access for admin only
if(!isAdmin($data->role)){
      // set response code - 404 Not found
      http_response_code(403);
  
      // tell the class no products found
      echo json_encode(
          array("message" => "You dont have access right to delete a class.")
      );
  
      return;

}

// Check if class_id provided is valid
if($class_id == null || !is_numeric($class_id) || $class_id == "" || $class_id == " " ){
    // No valid class id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the class no products found
    echo json_encode(
        array("message" => "Plaese provide a valid class ID")
    );

    return;
}

$class->class_id = $class_id;
// Check if class exists
$class_stmt = $class->getClass();

$classToDelete = $class_stmt->fetch(PDO::FETCH_ASSOC);

if(!$classToDelete){
    // No valid class id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the class no products found
    echo json_encode(
        array("message" => "class with ID:$class_id does not exist")
    );

    return;
}
  
// delete the class
if($class->deleteClass()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the class
    echo json_encode(array("message" => "class was deleted successfully."));
}
  
// if unable to delete the class
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the class
    echo json_encode(array("message" => "Unable to delete class. Please try again"));
}
?>