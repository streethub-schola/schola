<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PATCH_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare product object
$user = new User($db);
  
// get id of user to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if($data->id == null || $data->id == '' || !is_numeric($data->id)){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the user
      echo json_encode(array("message" => "Please provide a valid User ID"));

      return;
}
  
// set ID property of user to be edited
$user->id = $data->id;

// Get the user whose details are to be updated 
$user_stmt = $user->readUser();
    
$user_to_update = $user_stmt->fetch(PDO::FETCH_ASSOC);

// print_r($data->lastname);
// print_r($user_to_update['firstname']);
// return;
  
// set user property values
$user->firstname = ($data->firstname == null || $data->firstname == "") ? $user_to_update['firstname'] : $data->firstname;
$user->lastname = ($data->lastname == null || $data->lastname == "") ? $user_to_update['lastname'] : $data->lastname;
$user->email = ($data->email == null || $data->email == "") ? $user_to_update['email'] : $data->email;
$user->password = ($data->password == null || $data->password == "") ? $user_to_update['password'] : password_hash($data->password, PASSWORD_DEFAULT);

// echo "id : " . $user->id . "\n";
// echo "firstname : " . $user->firstname . "\n";
// echo "lastname : " . $user->lastname . "\n";
// echo "email : " . $user->email . "\n";
// echo "password : " . $user->password . "\n";
// return;

  
// update the user
if($user->updateUser()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "User was updated successfully."));
}
  
// if unable to update the user, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update user. Please try again."));
}

?>