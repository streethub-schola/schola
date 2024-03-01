<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$session = new Session();

// var_dump($session);
// return;

// read session id will be here
$session_id = null;

if (!empty($_GET['session_id'])) {
    $session_id = $_GET['session_id'];
} else {


    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->session_id)) {
        $session_id = $data->session_id;
    }
}


if ((empty($session_id) || $session_id == null || !is_numeric($session_id) || $session_id == '' || $session_id == ' ') && (empty($session_admin_no) || $session_admin_no == null || $session_admin_no == '' || $session_admin_no == ' ')) {
    // No valid session id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the session no products found
    echo json_encode(
        array("message" => "Plaese provide a valid session ID")
    );

    return;
}

// query sessions
$session->session_id = $session_id;

$stmt = $session->getSession();
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
} elseif ($stmt['outputStatus'] == 1100) {
    // no subjects found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the subject no products found
    echo json_encode(
        array("message" => "Something went wrong. Not able to fetch subject.")
    );
}
elseif ($stmt['outputStatus'] == 1200) {
    // no subjects found will be here
    errorDiag($stmt['output']);
}