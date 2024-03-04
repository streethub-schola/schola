<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$role = new Role();

$stmt = $role->getAllRoles();
// $num = $stmt->rowCount();

// check if more than 0 record found
if($stmt['outputStatus'] == 1000) {

    $result_role = $stmt['output']->fetchAll(PDO::FETCH_ASSOC);
   
    if (count($result_role) == 0) {
        // set response code - 200 OK
        http_response_code(404);

        // show roles data in json format
        echo json_encode(array("message" => "No role found.", "status"=>1));

        return;
    }

    // set response code - 200 OK
    http_response_code(200);

    // show roles data in json format
    echo json_encode(array("result"=>$result_role, "status"=>1));
    return;
} 
elseif ($stmt['outputStatus'] == 1200) {
    // no subjects found will be here
    errorDiag($stmt['output']);
    return;
}
else {
    // no subjects found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the subject no products found
    echo json_encode(
        array("message" => "Something went wrong. Not able to fetch subjectes.")
    );
}
