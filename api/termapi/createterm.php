<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$term = new Term();


// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// make sure data is not empty
if (
    !empty($data->term_name)
) {

    // Sanitize & set term property values
    $term->term_name = cleanData($data->term_name);

    // create the term
    $newterm = $term->createTerm();

    // var_dump($newterm);
    // return;

    if ($newterm['outputStatus'] == 1000) {

        // set response code - 201 created
        http_response_code(201);

        // tell the term
        // echo json_encode(array("message" => "term was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "term was created successfully", "status" => 1));
        return;
    }
    elseif ($newterm['outputStatus'] == 1200) {

        errorDiag($newterm['output']);
    }
    else {
        // set response code - 200 ok
        http_response_code(400);

        // tell the term
        echo json_encode(array("message" => $newterm['output'], "status" => 0));
        return;
    }
    
} else {

    // tell the term data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the term
    echo json_encode(array("message" => "Unable to create term. Fill all fields.", "status" => 2));
    return;
}
