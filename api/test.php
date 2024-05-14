<?php

include('./config/functions.php');
// // required headers
// header("Access-Control-Allow-Origin:" . $ORIGIN);
// header("Content-Type:" . $CONTENT_TYPE);
// header("Access-Control-Allow-Methods:" . $POST_METHOD);
// header("Access-Control-Max-Age:" . $MAX_AGE);
// header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);


// $updated_at = date("Y:m:d H:i:sa");

// $query = "UPDATE cur_session SET
//  session_id = :session_id,
//  updated_at = :updated_at
// WHERE
//  id = :id";

// // prepare query statement
// $update_stmt = $conn->prepare($query);

// // bind new values
// $update_stmt->bindParam(':admin_no', $this->admin_no);
// $update_stmt->bindParam(':user_code', $this->user_code);
// $update_stmt->bindParam(':updated_at', $this->updated_at);

// try {

//     if ($update_stmt->execute()) return true;
// } catch (Exception $e) {

//     return $e->getMessage();
// }


$test_data = "test&1234";

$test2 = cleanData($test_data);
echo $test2;