<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $DEL_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// prepare user object
$term = new Term();

// get term id
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

// set term id to be deleted
$term_id = cleanData($term_id);

// Check for role
if (empty($data->role)) {
    // set response code - 404 Not found
    http_response_code(403);

    // tell the term no products found
    echo json_encode(
        array("message" => "You dont have access right to delete a term.", "status" => 4)
    );

    return;
}

// Restrict delete access for admin only
if (!isAdmin($data->role)) {
    // set response code - 404 Not found
    http_response_code(403);

    // tell the term no products found
    echo json_encode(
        array("message" => "You dont have access right to delete a term.", "status" => 3)
    );

    return;
}

// Check if term_id provided is valid
if ($term_id == null || !is_numeric($term_id) || $term_id == "" || $term_id == " ") {
    // No valid term id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the term no products found
    echo json_encode(
        array("message" => "Plaese provide a valid term ID", "status" => 2)
    );

    return;
}

$term->term_id = $term_id;
// Check if term exists
$term_stmt = $term->getterm();

if ($term_stmt['outputStatus'] == 1000) {

    $term_exists = $term_stmt['output']->fetch(PDO::FETCH_ASSOC);

    if (!$term_exists) {
        // No valid term id provided

        // set response code - 404 Not found
        http_response_code(404);

        // tell the term no products found
        echo json_encode(
            array("message" => "No term found", "status" => 0)
        );

        return;
    }

    // delete the term
    $term_deleted = $term->deleteterm();

    if ($term_deleted['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the term
        echo json_encode(array("message" => "term was deleted successfully.", "status" => 1));
    } elseif ($term_deleted['outputStatus'] == 1200) {

        errorDiag($term_deleted['output']);
        
    } else {
        // if unable to delete the term

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the term
        echo json_encode(array("message" => "Unable to delete term. Please try again", "status" => 2));
    }
} elseif ($term_stmt['outputStatus'] == 1200) {
    errorDiag($term_stmt['output']);
} else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the term
    echo json_encode(array("message" => "Unable to delete term. Please try again", "status" => 5));
}
