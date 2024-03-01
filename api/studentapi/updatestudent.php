<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// Student
$student = new Student();

// get student_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valstudent_id student_id
if (empty($data->student_id) && empty($data->admin_no)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid student_id or Admission Number", "status" => 2));

    return;
}

// Check for valstudent_id student_id
if ($data->student_id == null || $data->student_id == '' || !is_numeric($data->student_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid student_id", "status" => 2));

    return;
}

// set student_id property of student to be edited
$student->student_id = cleanData($data->student_id);

// Get the student whose details are to be updated 
$student_stmt = $student->getStudent();

if ($student_stmt['outputStatus'] == 1000) {


    $student_to_update = $student_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // If student does not exist
    if (!$student_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the student
        echo json_encode(array("message" => "No student found with this ID.", "status" => 0));

        return;
    }

    // If student with id exists
    // set student property values
    $student->admin_no = (empty($data->admin_no)  || $data->admin_no == NULL || $data->admin_no == " ") ? $student_to_update['admin_no'] : cleanData($data->admin_no);
    $student->firstname = (empty($data->firstname) || $data->firstname == NULL || $data->firstname == " ") ? $student_to_update['firstname'] : cleanData($data->firstname);
    $student->lastname = (empty($data->lastname) || $data->lastname == NULL || $data->lastname == " ") ? $student_to_update['lastname'] : cleanData($data->lastname);
    $student->dob = (empty($data->dob) || $data->dob == NULL || $data->dob == " ") ? $student_to_update['dob'] : cleanData($data->dob);
    $student->image = (empty($data->image) || $data->image == NULL || $data->image == " ") ? $student_to_update['image'] : cleanData($data->image);
    $student->guardian_name = (empty($data->guardian_name) || $data->guardian_name == NULL || $data->guardian_name == " ") ? $student_to_update['guardian_name'] : cleanData($data->guardian_name);
    $student->guardian_phone = (empty($data->guardian_phone) || $data->guardian_phone == NULL || $data->guardian_phone == " ") ? $student_to_update['guardian_phone'] : cleanData($data->guardian_phone);
    $student->guardian_email = (empty($data->guardian_email) || $data->guardian_email == NULL || $data->guardian_email == " ") ? $student_to_update['guardian_email'] : cleanData($data->guardian_email);
    $student->guardian_address = (empty($data->guardian_address) || $data->guardian_address == NULL || $data->guardian_address == " ") ? $student_to_update['guardian_address'] : cleanData($data->guardian_address);
    $student->guardian_rel = (empty($data->guardian_rel) || $data->guardian_rel == NULL || $data->guardian_rel == " ") ? $student_to_update['guardian_rel'] : cleanData($data->guardian_rel);
    $student->setTimeNow();


    // update the student
    $updateStatus = $student->updateStudent();


    if ($updateStatus['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the subject
        echo json_encode(array("message" => "Updated successfully.", "status" => 1));
        return;
    } elseif($updateStatus['outputStatus'] == 1200) {

        errorDiag($updateStatus['output']);
    }
    else {
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the student
        echo json_encode(array("message" => "Something ent wrong. Please try again.", "status" => 2));
    }
    
} elseif ($student_stmt['outputStatus'] == 1200) {
    errorDiag($student_stmt['output']);
} else {
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the student
    echo json_encode(array("message" => "Something ent wrong. Please try again.", "status" => 2));
}



