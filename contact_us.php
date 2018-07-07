<?php
include("./include/connection.php");
include("./include/functions.php");

if(isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['query'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $query = trim($_POST['query']);
    $message = str_replace("\n.", "\n..", wordwrap($query."\n Name: ".$name, 70, "\r\n"));
    $to = "cesatmmmut@gmail.com";
    $subject = "Question/Suggession from " . $name;
    
    $headers ="From:<$email>\n";
    $headers.="MIME-Version: 1.0\n";
    $headers.="Content-type: text/html; charset=iso 8859-1";
    
    mail($to,$subject,$message,$headers);
    redirect("./");
}else{
    redirect("./");
}
?>