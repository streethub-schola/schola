<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// assignment
$assignment = new Assignment();

// get admin_no of user to be edited
$data = json_decode(file_get_contents("php://input"));

// http_response_code(200);
// echo json_encode(array("message" => $data, "status"=>2));
// return;

// Check for valid admin_no
if (empty($data->searchstring) || $data->searchstring == null || $data->searchstring == ' ') {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide what you are searching for", "status" => 2));

    return;
}

// Check for valid new password
if (empty($data->searchcolumn) || $data->searchcolumn == null || $data->searchcolumn == ' ') {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid table column name to search in", "status" => 3));

    return;
}

$searchString = cleanData($data->searchstring);
$searchColumn = cleanData($data->searchcolumn);

// Get the assignment whose details are to be updated 
$search_stmt = $assignment->searchAssignment($searchString, $searchColumn);

// var_dump($search_stmt);
// return;

if ($search_stmt['outputStatus'] == 1000) {

    $search_result = $search_stmt['output']->fetchAll(PDO::FETCH_ASSOC);

    if (count($search_result) == 0) {
        // set response code -
        http_response_code(404);

        // tell the assignment
        echo json_encode(array("message" => "No assignment found for this search word : $searchString", "status" => 0));
        return;
    }

    // set response code - 200 ok
    http_response_code(400);

    // tell the assignment
    echo json_encode(array("message" => "Success","result"=>$search_result, "status" => 1));
    return;
} elseif ($search_stmt['outputStatus'] == 1200) {
    errorDiag($search_stmt['output']);
    return;
    
} else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the assignment
    echo json_encode(array("message" => "No assignment found for this search item", "status" => 200));
}
