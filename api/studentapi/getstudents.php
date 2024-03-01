<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
  
// initialize object
$student = new Student();


// read students will be here
// query students
$stmt = $student->getStudents();

if($stmt['outputStatus'] == 1000){

  
    // students array
    $students_arr=array();
    $students_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt['output']->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $student_item=array(
            "admin_no" => $admin_no,
            "student_id" => $student_id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "dob" => $dob,
            "image" => $image,
            "class" => $class,
            "guardian_name" => $guardian_name,
            "guardian_phone" => $guardian_phone,
            "guardian_email" => $guardian_email,
            "guardian_address" => $guardian_address,
            "guardian_rel" => $guardian_rel,
            "active" => $active,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
        );
  
        array_push($students_arr["records"], $student_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show students data in json format
    echo json_encode($students_arr);
}
elseif($stmt['outputStatus'] == 1200){
    errorDiag($stmt['output']);
}
else{
    // no students found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the student no products found
    echo json_encode(
        array("message" => "No students found.", "status"=>0)
    );
}
  

