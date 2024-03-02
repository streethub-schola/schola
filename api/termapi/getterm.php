<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$term = new Term();

// var_dump($term);
// return;

// read term id will be here
$term_id = null;

if (!empty($_GET['term_id'])) {
    $term_id = $_GET['term_id'];
} else {


    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->term_id)) {
        $term_id = $data->term_id;
    }
}


if ((empty($term_id) || $term_id == null || !is_numeric($term_id) || $term_id == '' || $term_id == ' ') && (empty($term_admin_no) || $term_admin_no == null || $term_admin_no == '' || $term_admin_no == ' ')) {
    // No valid term id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the term no products found
    echo json_encode(
        array("message" => "Plaese provide a valid term ID")
    );

    return;
}

// query terms
$term->term_id = $term_id;

$stmt = $term->getTerm();
// var_dump($stmt);
// return;

// check if more than 0 record found
if ($stmt['outputStatus'] == 1000) {
     
    $result = $stmt['output']->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        // set response code - 200 OK
        http_response_code(404);

        // show subjects data in json format
        echo json_encode(array("message" => "Nothing found with this ID.", "status"=>0));

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
    return;
}
else {
    // no subjects found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the subject no products found
    echo json_encode(
        array("message" => "Something went wrong. Not able to fetch subject.")
    );
}