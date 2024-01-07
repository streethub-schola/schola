<?php

function mailSender(){
$to = "oiunachukwu@gmail.com";
$subject = "This is My Test subject";

$message = "<b>This is HTML message.</b>";
$message .= "<h1>This is headline.</h1>";

$header = "From:test@fuelalert.myf2.net \r\n";
$header .= "Cc:iounachukwu@gmail.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";

$retval = mail ($to,$subject,$message,$header);

if( $retval == true ) {
        echo "Message sent successfully...";
}else {
        echo "Message could not be sent...";
}

}