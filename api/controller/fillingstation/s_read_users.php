<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
  
// initialize object
$user = new User($db);
  
// read users will be here
// query users
$stmt = $user->readUsers();
    
if($stmt){

  
    // users array
    $users_arr=array();
    $users_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        // $user_item=array(
        //     "id" => $id,
        //     "firstname" => $firstname,
        //     "lastname" => $lastname,
        //     "email" => $email,
        //     "password" => $password,
        //     "created_at" => $created_at,
        //     "updated_at" => $updated_at,
        // );

        $user_item=array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "user_code" => $user_code,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
        );
  
        array_push($users_arr["records"], $user_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show users data in json format
    echo json_encode($users_arr);
}
else{
    // no users found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No users found.")
    );
}
  

    // try{

    //     include_once('../config/sqlitecon.php'); 
        
    //     /* Create a prepared statement */
    //     $stmt = $db->prepare("SELECT * from users");
        
    //     /* execute the query */
    //     $stmt->execute();        
        
    //     /* fetch all results */
    //     $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     foreach($res as $row){
    //         extract($row);
    //         echo $id.") ".$firstname." ".$lastname."<br>";
    //     }
                
    //     /* close connection */
    //     $db = null;

    //     // return json_encode($res);
    // }
    // catch (PDOExecption $e){
    //     echo $e->getMessage();
    // }    
    
    // echo "<br> Search particular row here: <a href='search-pdo-sqlite.php'>SEARCH</a>";
