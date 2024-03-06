<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $POST_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// Initiatialise 
$role = new Role();


// get posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);
// return;

// make sure data is not empty
if (
    !empty($data->role_name) && $data->role_name != " " && !empty($data->role_no) && $data->role_no != " " && is_numeric($data->role_no)
) {

    // Sanitize & set role property values
    $role->role_name = cleanData($data->role_name);
    $role->role_no = cleanData($data->role_no);


    // create the role
    $newrole = $role->createRole();

    // var_dump($newrole);
    // return;

    if ($newrole['outputStatus'] == 1000) {

        // set response code - 201 created
        http_response_code(201);

        // tell the role
        // echo json_encode(array("message" => "role was created. Please check your email for your verification link","mailSent"=>$mailSent));
        echo json_encode(array("message" => "role was created successfully", "status" => 1));
        return;
    }
    elseif ($newrole['outputStatus'] == 1200) {

        errorDiag($newrole['output']);
        return;
    }
    else {
        // set response code - 200 ok
        http_response_code(400);

        // tell the role
        echo json_encode(array("message" => $newrole['output'], "status" => 0));
        return;
    }
    
} else {

    // tell the role data is incomplete

    // set response code - 400 bad request
    http_response_code(400);

    // tell the role
    echo json_encode(array("message" => "Unable to create role. Fill all fields.", "status" => 2));
    return;
}
