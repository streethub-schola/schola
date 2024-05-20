<?php
include('../config/autoload.php');

// required headers
// header('Referrer-Policy: no-referrer');

header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Accept:" . $ACCEPT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);



// prepare product object
$student = new Student();

// get id of student to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if (empty($data->admin_no) || $data->admin_no == null || $data->admin_no == ''  || $data->admin_no == ' ' || empty($data->password) || $data->password == null || $data->password == '' || $data->password == ' ') {
    // set response code - 503 service unavailable
    http_response_code(401);

    // tell the student
    echo json_encode(array("message" => "Please provide both valid email and/or password"));

    return;
}

// Sanitize and set student property values
$student->admin_no = cleanData($data->admin_no);
$student->password = cleanData($data->password);

// Check if student with this login details exists
$login_stmt = $student->studentLogin();



if (is_string($login_stmt)) {

    // set response code - 200 ok
    http_response_code(400);

    // tell the student
    echo json_encode(array("message" => $login_stmt, "status" => 23));
    return;
}

// var_dump($login_stmt);
// return;

$loggedInstudent = $login_stmt->fetch(PDO::FETCH_ASSOC);

// Check if student exists
if (is_string($loggedInstudent)) {

    // set response code - 200 ok
    http_response_code(400);

    // tell the student
    echo json_encode(array("message" => $loggedInstudent, "status" => 3));
    return;
} elseif ($loggedInstudent) {

    // if student does exist
    $passCheck = $student->verifyPass($student->password, $loggedInstudent['password']);
    if ($passCheck) {
        $loggedInstudent['password'] = "xxxxxxxxxxxxxxxxxx";

        // Generate new session usercode
        $student->generateCode();

        $newSessionSet = $student->generateSessionCode();

        if ($newSessionSet) {

            $loggedInstudent['user_code'] = $student->user_code;

            // set response code - 200 ok
            http_response_code(200);

            // tell the student
            echo json_encode(array("message" => "student Login successful.", "student" => $loggedInstudent, "status" => 1));

            return;
        } else {

            // set response code - 200 ok
            http_response_code(200);

            // tell the student
            echo json_encode(array("message" => "Login failed due to network session failure. Try again", "status" => 11));

            return;
        }
    } else {

        // set response code - 503 service unavailable
        http_response_code(403);

        // tell the student
        echo json_encode(array("message" => "Wrong login details. Please try again or register", "status" => 4));
    }
} else {

    // if student does not exist

    // set response code - 503 service unavailable
    http_response_code(404);

    // tell the student
    echo json_encode(array("message" => "Wrong login details. Please try again or register"));
}
