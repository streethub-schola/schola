<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);

$evc = $_GET['evc'] ?? null;

if($evc == null){

    // set response code - 201 created
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Email verification failed. Verification link not valid"));
}

$evc = htmlspecialchars(strip_tags($evc));

$user = new User($db);

$ev_result = $user->emailVerify($evc);

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



