<?php

function cleanData($data){
    return htmlspecialchars(strip_tags(trim($data)));
}


function errorDiag($err){
    if (stripos($err, 'duplicate')) {
        // set response code - 200 ok
        http_response_code(400);

        // tell the subject
        echo json_encode(array("message" => "FAILED: Entity already exists.", "status" => 6));
        return;
    }

    if (stripos($err, 'invalid parameter')) {
        // set response code - 200 ok
        http_response_code(400);

        // tell the subject
        echo json_encode(array("message" => "Internal query parameter error.", "status" => 7));
        return;
    }

    if (stripos($err, 'column') || stripos($err, 'unknown')) {
        // set response code - 200 ok
        http_response_code(400);

        // tell the subject
        echo json_encode(array("message" => "Internal or external: A column name is wrong.", "status" => 8));
        return;
    }

    if (stripos($err, 'SQL syntax')) {
        // set response code - 200 ok
        http_response_code(400);

        // tell the subject
        echo json_encode(array("message" => "Internal : Issue with SQL query syntax.", "status" => 9));
        return;
    }

    if (stripos($err, 'base table')) {
        // set response code - 200 ok
        http_response_code(400);

        // tell the subject
        echo json_encode(array("message" => "Internal : Table name does not exist.", "status" => 10));
        return;
    }

    // set response code - 200 ok
    http_response_code(400);

    // tell the subject
    echo json_encode(array("message" =>"Error", "error"=>$err, "status" => 11));
    return;

}