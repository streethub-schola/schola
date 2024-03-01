<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$DEL_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare user object
$staff = new Staff();
  
// get staff id
$data = json_decode(file_get_contents("php://input"));
  
// set staff id to be deleted
$staff_id = cleanData($data->staff_id);


// Restrict delete access for admin only
if(!isAdmin($data->role)){
      // set response code - 404 Not found
      http_response_code(403);
  
      // tell the staff no products found
      echo json_encode(
          array("message" => "You dont have accessright to delete a staff.")
      );
  
      return;

}

// Check if staff_id provided is valid
if($staff_id == null || !is_numeric($staff_id) || $staff_id == "" || $staff_id == " " ){
    // No valid staff id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the staff no products found
    echo json_encode(
        array("message" => "Plaese provide a valid staff ID")
    );

    return;
}

$staff->staff_id = $staff_id;
// Check if staff exists
$staff_stmt = $staff->getstaff();

$staffToDelete = $staff_stmt->fetch(PDO::FETCH_ASSOC);

if(!$staffToDelete){
    // No valid staff id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the staff no products found
    echo json_encode(
        array("message" => "staff with ID:$staff_id does not exist")
    );

    return;
}
  
// delete the staff
if($staff->deletestaff()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the staff
    echo json_encode(array("message" => "staff was deleted successfully."));
}
  
// if unable to delete the staff
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the staff
    echo json_encode(array("message" => "Unable to delete staff."));
}
?>