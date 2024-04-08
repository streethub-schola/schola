<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$DEL_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare user object
$user = new User($db);
  
// get user id
$data = json_decode(file_get_contents("php://input"));
  
// set user id to be deleted
$user_id = htmlspecialchars(strip_tags($data->id));

// Check if user_id provided is valid
if($user_id == null || !is_numeric($user_id)){
    // No valid user id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Plaese provide a valid User ID")
    );

    return;
}

// Check if user exists
$userCheck = $user->readUser($user_id);

if($userCheck->rowCount() == 0){
    // No valid user id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "User with ID:$user_id does not exist")
    );

    return;
}
  
// delete the user
if($user->deleteUser()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "User was deleted successfully."));
}
  
// if unable to delete the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete user."));
}
?>