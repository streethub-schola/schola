<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$DEL_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);

// prepare product object
$user = new User($db);
  
// get id of user to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if($data->email == null || $data->email == '' || $data->password == null || $data->password == '' ){
      // set response code - 503 service unavailable
      http_response_code(401);
  
      // tell the user
      echo json_encode(array("message" => "Please provide both valid email and password"));

      return;
}
  
// Sanitize and set user property values
$user->email = htmlspecialchars(strip_tags($data->email));
$user->password = htmlspecialchars(strip_tags($data->password));

// Check if user with this login details exists
$loggedInUser = $user->userLogin();
    
// Check if user exists
if($loggedInUser){
    // if user does not exist
   
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "User Login successful.", "user"=>$loggedInUser));

}
else{
    // if user does not exist
  
    // set response code - 503 service unavailable
    http_response_code(404);
  
    // tell the user
    echo json_encode(array("message" => "Wrong login details. Please try again or register"));
}