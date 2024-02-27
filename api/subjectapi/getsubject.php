<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$subject = new Subject();

// var_dump($subject);
// return;

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


// Check for subject ID
if ((empty($subject_id) || $subject_id == null || !is_numeric($subject_id) || $subject_id == '' || $subject_id == ' ') && (empty($subject_admin_no) || $subject_admin_no == null || $subject_admin_no == '' || $subject_admin_no == ' ')) {
    // No valid subject id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the subject no products found
    echo json_encode(
        array("message" => "Plaese provide a valid subject ID")
    );

    return;
}

// query subjects
$subject->subject_id = $subject_id;



$stmt = $subject->getSubject();


// check if more than 0 record found
if ($stmt['outputStatus'] == 1000) {

    $result = $stmt['output']->fetch(PDO::FETCH_ASSOC);
    //  print_r(count($subjects_arr['records']));
    //   return;
    if (!$result) {
        // set response code - 200 OK
        http_response_code(404);

        // show subjects data in json format
        echo json_encode(array("message" => "No subject found with this ID."));

        return;
    }

    // set response code - 200 OK
    http_response_code(200);

    // show subjects data in json format
    echo json_encode($result);
    return;
}
else{
    // no subjects found will be here
    errorDiag($stmt['output']);
}
