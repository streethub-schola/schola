<?php

    class Database{
    
        // specify your own database credentials
        private $host = "";
        private $db_name = "";
        private $username = "";
        private $password = "";
        public $conn;
    
        // get the database connection
        // public function getConnection(){
        public function __construct()
        {


            include('dotenv.php');
            $this->host = $HOST; //replace with your own host
            $this->db_name = $DB_NAME; //replace with your own db name
            $this->username = $USERNAME; //replace with your own db username
            $this->password = $PASSWORD; //replace with your own password

            $this->conn = null;
    
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
                // echo "Connected ";
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
    
            // return $this->conn;
        }


        
    }


    // $bdconnect = new Database();
    // $bdconnect->getConnection();
?>