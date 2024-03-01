<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$assignment = new Assignment();

// var_dump($assignment);
// return;

// read assignment id will be here
$assignment_id = null;

if (!empty($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];
} else {


    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->assignment_id)) {
        $assignment_id = $data->assignment_id;
    }
}


if ((empty($assignment_id) || $assignment_id == null || !is_numeric($assignment_id) || $assignment_id == '' || $assignment_id == ' ')) {
    // No valid assignment id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the assignment no products found
    echo json_encode(
        array("message" => "Plaese provide a valid assignment ID")
    );

    return;
}

// query assignments
$assignment->assignment_id = $assignment_id;

$stmt = $assignment->getassignment();
// var_dump($stmt);
// return;

// check if more than 0 record found
if ($stmt['outputStatus'] == 1000) {
     
    $result = $stmt['output']->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        // set response code - 200 OK
        http_response_code(404);

        // show subjects data in json format
        echo json_encode(array("message" => "No subject found with this ID.", "status"=>0));

        return;
    }

  
    // set response code - 200 OK
    http_response_code(200);

    // show subjects data in json format
    echo json_encode(array("result"=>$result, "status"=>1));
    return;
} 
elseif ($stmt['outputStatus'] == 1200) {
    // no subjects found will be here
    errorDiag($stmt['output']);
}
else{
    // no subjects found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the subject no products found
    echo json_encode(
        array("message" => "Something went wrong. Not able to fetch subject.")
    );
}