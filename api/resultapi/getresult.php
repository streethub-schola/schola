<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$result = new Result();

// var_dump($result);
// return;

// read result id will be here
$result_id = null;

if (!empty($_GET['result_id'])) {
    $result_id = $_GET['result_id'];
} else {


    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->result_id)) {
        $result_id = $data->result_id;
    }
}


if ((empty($result_id) || $result_id == null || !is_numeric($result_id) || $result_id == '' || $result_id == ' ')) {
    // No valid result id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the result no products found
    echo json_encode(
        array("message" => "Plaese provide a valid result ID")
    );

    return;
}

// query results
$result->result_id = $result_id;

$stmt = $result->getresult();
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