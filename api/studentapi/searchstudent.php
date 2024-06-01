<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// Student
$student = new Student();
  
// get admin_no of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valid admin_no
if(empty($data->searchstring) || $data->searchstring == null || $data->searchstring == '' || $data->searchstring == ' '){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the user
      echo json_encode(array("message" => "Please provide what you are searching for", "status"=>2));

      return;
}

// Check for valid new password
if(empty($data->searchcolumn) || $data->searchcolumn == null || $data->searchcolumn == '' || $data->searchcolumn == ' '){
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid table column name to search in", "status"=>4));

    return;
}
  
// set properies of student to be edited
// $student->admin_no = cleanData($data->admin_no);
// $student->active = cleanData($data->active);
// $student->updated_at = date("d-m-Y H:s:ia");


$searchString = cleanData($data->searchstring);
$searchColumn = cleanData($data->searchcolumn);
// $searchDesc = "Admission Number";

// Get the student whose details are to be updated 
$search_stmt = $student->searchStudent($searchString, $searchColumn);

$search_result = $search_stmt->fetchAll(PDO::FETCH_ASSOC);

if($search_result == "No student found for this search item"){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the student
    echo json_encode(array("message" => "No student found for this search item", "status"=>1));

    return;

}elseif($search_result){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the student
    echo json_encode(array("message" => $search_result, "status"=>1));

    return;

}else{
    errorDiag($search_result);
    return;
}


