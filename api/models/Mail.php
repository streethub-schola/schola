<?php

class Mail{

    private $header = "From:test@fuelalert.myf2.net \r\n MIME-Version: 1.0\r\n Content-type: text/html\r\n";

    public $sender_name = "";
    public $to = "oiunachukwu@gmail.com";
    public $subject = "WELCOME TO FUELALERT";
    public $message = "";
    private $sendStatus = false;

    // public function __constructor(){

    // }

    public function sendMail(){
        
        $this->sendStatus = mail ($this->to,$this->subject,$this->message,$this->header);

        $this->mailStatus();
    }

    private function mailStatus(){
        if( $this->sendStatus == true ) {
            echo "Message sent successfully...";
        }else {
                echo "Message could not be sent...";
        }
    }

}

?>