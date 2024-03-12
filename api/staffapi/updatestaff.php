<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PATCH_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// staff
$staff = new Staff();
  
// get staff_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valstaff_id staff_id
if($data->staff_id == null || $data->staff_id == '' || !is_numeric($data->staff_id)){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the user
      echo json_encode(array("message" => "Please provide a valid staff_id", "status"=>2));

      return;
}
  
// set staff_id property of staff to be edited
$staff->staff_id = cleanData($data->staff_id);

// Get the staff whose details are to be updated 
$staff_stmt = $staff->getStaff();

    
$staff_to_update = $staff_stmt['output']->fetch(PDO::FETCH_ASSOC);

// If staff does not exist
if(!$staff_to_update){
     // set response code - 200 ok
     http_response_code(404);
  
     // tell the staff
     echo json_encode(array("message" => "No staff found with this ID.", "status"=>0));

     return;
}

// If staff with id exists
// set staff property values
$staff->staff_no = (empty($data->staff_no)  || $data->staff_no == NULL || $data->staff_no == " ") ? $staff_to_update['staff_no'] : cleanData($data->staff_no);
$staff->firstname = (empty($data->firstname) || $data->firstname == NULL || $data->firstname == " ") ? $staff_to_update['firstname'] : cleanData($data->firstname);
$staff->lastname = (empty($data->lastname) || $data->lastname == NULL || $data->lastname == " ") ? $staff_to_update['lastname'] : cleanData($data->lastname);
$staff->dob = (empty($data->dob) || $data->dob == NULL || $data->dob == " ") ? $staff_to_update['dob'] : cleanData($data->dob);
$staff->image = (empty($data->image) || $data->image == NULL || $data->image == " ") ? $staff_to_update['image'] : cleanData($data->image);

$staff->guarantor_name = (empty($data->guarantor_name) || $data->guarantor_name == NULL || $data->guarantor_name == " ") ? $staff_to_update['guarantor_name'] : cleanData($data->guarantor_name);
$staff->guarantor_phone = (empty($data->guarantor_phone) || $data->guarantor_phone == NULL || $data->guarantor_phone == " ") ? $staff_to_update['guarantor_phone'] : cleanData($data->guarantor_phone);
$staff->guarantor_email = (empty($data->guarantor_email) || $data->guarantor_email == NULL || $data->guarantor_email == " ") ? $staff_to_update['guarantor_email'] : cleanData($data->guarantor_email);
$staff->guarantor_address = (empty($data->guarantor_address) || $data->guarantor_address == NULL || $data->guarantor_address == " ") ? $staff_to_update['guarantor_address'] : cleanData($data->guarantor_address);
$staff->guarantor_rel = (empty($data->guarantor_rel) || $data->guarantor_rel == NULL || $data->guarantor_rel == " ") ? $staff_to_update['guarantor_rel'] : cleanData($data->guarantor_rel);

$staff->nok_name = (empty($data->nok_name) || $data->nok_name == NULL || $data->nok_name == " ") ? $staff_to_update['nok_name'] : cleanData($data->nok_name);
$staff->nok_phone = (empty($data->nok_phone) || $data->nok_phone == NULL || $data->nok_phone == " ") ? $staff_to_update['nok_phone'] : cleanData($data->nok_phone);
$staff->nok_email = (empty($data->nok_email) || $data->nok_email == NULL || $data->nok_email == " ") ? $staff_to_update['nok_email'] : cleanData($data->nok_email);
$staff->nok_address = (empty($data->nok_address) || $data->nok_address == NULL || $data->nok_address == "") ? $staff_to_update['nok_address'] : cleanData($data->nok_address);
$staff->nok_rel = (empty($data->nok_rel) || $data->nok_rel == NULL || $data->nok_rel == " ") ? $staff_to_update['nok_rel'] : cleanData($data->nok_rel);

$staff->setTimeNow();


// update the staff
$updateStatus = $staff->updatestaff();


if($updateStatus){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the staff
    echo json_encode(array("message" => "staff was updated successfully.", "status"=>1));

    return;
}else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the staff
    echo json_encode(array("message" => "Unable to update staff. Please try again.", "status"=>2));
}


?>