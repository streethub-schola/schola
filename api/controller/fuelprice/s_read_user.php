<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// initialize object
$user = new User($db);
  
// read user id will be here
$user_id = $_GET['user_id'] ?? null;

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

// query users
$user->id = $user_id;
$stmt = $user->readUser();
// $num = $stmt->rowCount();
  
// check if more than 0 record found
if($stmt){
  
    // users array
    $users_arr=array();
    $users_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $user_item=array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "user_code" => $user_code,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
        );
  
        array_push($users_arr["records"], $user_item);
    }
//  print_r(count($users_arr['records']));
//   return;
    if(count($users_arr['records']) == 0){
        // set response code - 200 OK
        http_response_code(200);
    
        // show users data in json format
        echo json_encode(array("message" => "No user found with this ID."));

        return;
    }

    // set response code - 200 OK
    http_response_code(200);
  
    // show users data in json format
    echo json_encode($users_arr);
}
else{
    // no users found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Something went wrong. Not able to fetch user.")
    );
}
  
