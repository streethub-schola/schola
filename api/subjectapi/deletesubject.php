<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $DEL_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// prepare user object
$subject = new Subject();

// get subject id
// read subject id will be here
$subject_id = null;

if (!empty($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
} else {


    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->subject_id)) {
        $subject_id = $data->subject_id;
    }
}

// set subject id to be deleted
$subject_id = cleanData($subject_id);


// Check if subject_id provided is valid
if ($subject_id == null || !is_numeric($subject_id) || $subject_id == "" || $subject_id == " ") {
    // No valid subject id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the subject no products found
    echo json_encode(
        array("message" => "Plaese provide a valid subject ID")
    );

    return;
}


if (empty($data->role) || !isAdmin($data->role)) {
    // set response code - 404 Not found
    http_response_code(403);

    // tell the subject no products found
    echo json_encode(
        array("message" => "You dont have access right to delete a subject.")
    );

    return;
}


$subject->subject_id = $subject_id;
// Check if subject exists
$subject_stmt = $subject->getSubject();

if ($subject_stmt['outputStatus'] == 1000) {

    $subjectToDelete = $subject_stmt['output']->fetch(PDO::FETCH_ASSOC);

    if (!$subjectToDelete) {
        // No valid subject id provided

        // set response code - 404 Not found
        http_response_code(404);

        // tell the subject no products found
        echo json_encode(
            array("message" => "subject with ID:$subject_id does not exist")
        );

        return;
    }

    // delete the subject
    $deleted = $subject->deleteSubject();

    if ($deleted['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the subject
        echo json_encode(array("message" => "subject was deleted successfully."));
    } elseif ($subject_stmt['outputStatus'] == 1200) {
        errorDiag($subject_stmt['output']);
        return;
    }
    // if unable to delete the subject
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the subject
        echo json_encode(array("message" => "Unable to delete subject. Please try again"));
    }
} elseif ($subject_stmt['outputStatus'] == 1200) {
    errorDiag($subject_stmt['output']);
    return;
} else {
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the subject
    echo json_encode(array("message" => "Something went wrong with your network. Please try again"));
}
