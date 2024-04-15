<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $DEL_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// prepare product object
$staff = new Staff();

// get id of staff to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if (empty($data->staff_no) || $data->staff_no == null || $data->staff_no == ''  || $data->staff_no == ' ' || empty($data->password) || $data->password == null || $data->password == '' || $data->password == ' ') {
    // set response code - 503 service unavailable
    http_response_code(401);

    // tell the staff
    echo json_encode(array("message" => "Please provide both valid staff No and/or password", "status" => 33));

    return;
}

// Sanitize and set staff property values
$staff->staff_no = cleanData($data->staff_no);
$staff->password = cleanData($data->password);

// Check if staff with this login details exists
$login_stmt = $staff->staffLogin();


// Check if staff exists
if ($login_stmt['outputStatus'] == 1000) {

    $loggedInstaff = $login_stmt['output']->fetch(PDO::FETCH_ASSOC);

    if (!$loggedInstaff) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the staff
        echo json_encode(array("message" => "No Stff found.", "status" => 0));

        return;
    }


    // if staff does exist
    $passCheck = $staff->verifyPass($staff->password, $loggedInstaff['password']);

    if ($passCheck) {
        $loggedInstaff['password'] = "xxxxxxxxxxxxxxxxxx";

        $newSessionSet = $staff->regenerateUserCode();

        // var_dump($newSessionSet['output']);
        // return;

        if ($newSessionSet['outputStatus'] == 1000 && $newSessionSet['output'] == true) {

            $loggedInstaff['user_code'] = $staff->user_code;

            // set response code - 200 ok
            http_response_code(200);

            // tell the staff
            echo json_encode(array("message" => "staff Login successful.", "staff" => $loggedInstaff, "status" => 1));

            return;
        } elseif ($newSessionSet['outputStatus'] == 1000) {
            errorDiag($newSessionSet['output']);
        } else {

            // set response code - 200 ok
            http_response_code(200);

            // tell the staff
            echo json_encode(array("message" => "Login failed due to network session failure. Try again", "status" => 11));

            return;
        }
    } else {

        // set response code - 503 service unavailable
        http_response_code(403);

        // tell the staff
        echo json_encode(array("message" => "Wrong login details. Please try again or register", "status" => 4));

        return;
    }
} elseif ($login_stmt['outputStatus'] == 1200) {

    errorDiag($login_stmt['output']);
    return;
} else {

    // if staff does not exist

    // set response code - 503 service unavailable
    http_response_code(404);

    // tell the staff
    echo json_encode(array("message" => "Something went wrong with network. Please try again or register", "status" => 55));
}
