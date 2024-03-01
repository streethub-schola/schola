<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// Student
$subject = new Subject();
  
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

$searchitem = cleanData($data->searchstring);
$searchcol = cleanData($data->searchcolumn);

// Get the student whose details are to be updated 
$search_stmt = $subject->searchSubject($searchitem, $searchcol);

// var_dump($search_stmt);
// return;

// Catch db error
if($search_stmt['outputStatus'] == 1200){
    // set response code - 200 ok
    http_response_code(403);
 
    // tell the student
    echo json_encode(array("message" =>"Query Error","result"=>$search_stmt['output'], "status"=>22));

    return;
}
elseif($search_stmt['outputStatus'] == 1000){

    $search_result = $search_stmt['output']->fetchAll(PDO::FETCH_ASSOC);


    // set response code - 200 ok
    http_response_code(200);
  
    // tell the student
    echo json_encode(array("message"=>"Fetched succesful","result"=> $search_result, "status"=>1));

}else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the student
    echo json_encode(array("message" => "No Subject found for this search item", "status"=>2));
}


?>