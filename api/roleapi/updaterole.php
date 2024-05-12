<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $PATCH_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// Student
$role = new Role();

// get role_id of user to be edited
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// Check for valrole_id role_id
if (empty($data->role_id) || $data->role_id == null || $data->role_id == '' || !is_numeric($data->role_id)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid role_id", "status" => 2));

    return;
}

// Check for valid role_name to update
if (empty($data->role_name) || $data->role_name == null || $data->role_name == ' ') {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid role name", "status" => 2));

    return;
}

// Check for valid role_no to update
if (empty($data->role_no) || $data->role_no == null || $data->role_no == ' ' || !is_numeric($data->role_no)) {
    // set response code - 503 service unavailable
    http_response_code(403);

    // tell the user
    echo json_encode(array("message" => "Please provide a valid role no", "status" => 2));

    return;
}

// set role_id property of role to be edited
$role->role_id = cleanData($data->role_id);

// Get the role whose details are to be updated 
$role_stmt = $role->getRole();

if ($role_stmt['outputStatus'] == 1000) {

    $role_to_update = $role_stmt['output']->fetch(PDO::FETCH_ASSOC);

    // If role does not exist
    if (!$role_to_update) {
        // set response code - 200 ok
        http_response_code(404);

        // tell the role
        echo json_encode(array("message" => "No role found with this ID.", "status" => 0));

        return;
    }

    // set role_id property of role to be edited
    $role->role_name = empty($data->role_name) ? $role_to_update['role_name'] : cleanData($data->role_name);
    $role->role_no = empty($data->role_no) ? $role_to_update['role_no'] : cleanData($data->role_no);

   
    // update the role
    $updateStatus = $role->updateRole();

    if ($updateStatus['outputStatus'] == 1000) {

        // set response code - 200 ok
        http_response_code(200);

        // tell the role
        echo json_encode(array("message" => "role was updated successfully.", "status" => 1));
        return;
    } 
    elseif ($updateStatus['outputStatus'] = 1200) {
        errorDiag($updateStatus['output']);
        return;
    }
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the role
        echo json_encode(array("message" => "Unable to update role. Please try again.", "status" => 2));
        return;
    }
} elseif ($role_stmt['outputStatus'] = 1200) {
    errorDiag($role_stmt['output']);
    return;
}
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the role
    echo json_encode(array("message" => "Unable to update role. Please try again.", "status" => 2));
    return;
}
