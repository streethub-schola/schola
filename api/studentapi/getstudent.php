<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:" . $ORIGIN);
header("Content-Type:" . $CONTENT_TYPE);
header("Access-Control-Allow-Methods:" . $GET_METHOD);
header("Access-Control-Max-Age:" . $MAX_AGE);
header("Access-Control-Allow-Headers:" . $ALLOWED_HEADERS);

// initialize object
$student = new Student();

// var_dump($student);
// return;

// read student id will be here
$student_id = $_GET['student_id'] ?? null;
$student_admin_no = $_GET['admin_no'] ?? null;


if ((empty($student_id) || $student_id == null || !is_numeric($student_id) || $student_id=='' || $student_id==' ') && (empty($student_admin_no) || $student_admin_no == null || $student_admin_no=='' || $student_admin_no==' ')) {
    // No valid student id provided

    // set response code - 404 Not found
    http_response_code(404);

    // tell the student no products found
    echo json_encode(
        array("message" => "Plaese provide a valid student ID or Admission number")
    );

    return;
}

// query students
$student->student_id = $student_id;
$student->admin_no = $student_admin_no;

// var_dump($student_id);
// var_dump($student_admin_no);
// return;

$stmt = $student->getStudent();
// $num = $stmt->rowCount();

// check if more than 0 record found
if (is_string($stmt)){
    // set response code - 200 OK
    http_response_code(400);

    // show students data in json format
    echo json_encode(array("message" => $stmt));

    return;

}
elseif($stmt) {

    // students array
    $students_arr = array();
    $students_arr["records"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $student_item = array(
            "admin_no" => $admin_no,
            "student_id" => $student_id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "dob" => $dob,
            "image" => $image,
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
    //  print_r(count($students_arr['records']));
    //   return;
    if (count($students_arr['records']) == 0) {
        // set response code - 200 OK
        http_response_code(200);

        if($student_id != null){
        // show students data in json format
        echo json_encode(array("message" => "No student found with this ID."));
        }
        elseif($student_admin_no != null){
        // show students data in json format
        echo json_encode(array("message" => "No student found with this Admission Number."));
        }

        return;
    }

    // set response code - 200 OK
    http_response_code(200);

    // show students data in json format
    echo json_encode($students_arr);
} else {
    // no students found will be here

    // set response code - 404 Not found
    http_response_code(404);

    // tell the student no products found
    echo json_encode(
        array("message" => "Something went wrong. Not able to fetch student.")
    );
}
