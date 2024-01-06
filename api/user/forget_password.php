<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);

$uemail = $_GET['uemail'] ?? null;

if($uemail == null){

    // set response code - 201 created
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Email verification failed. Verification link not valid"));
}

$uemail = htmlspecialchars(strip_tags($uemail));

$user = new User($db);

$user->email = $uemail;

$ev_result = $user->forgetPassword();

var_dump($ev_result);
return;

if($ev_result){
     // set response code - 201 created
     http_response_code(200);
  
     // tell the user
     echo json_encode(array("message" => "Email verification successful. Please login"));

}
else{
     // set response code - 201 created
     http_response_code(400);
  
     // tell the user
     echo json_encode(array("message" => "Email verification failed. Verification link not valid"));
}



