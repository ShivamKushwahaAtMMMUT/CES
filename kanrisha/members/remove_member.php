<?php 
session_start();
require("../include/connection.php");
require("../include/functions.php");
if(!isset($_SESSION['admin'])){
   redirect("../index.php");
}

if(isset($_GET['conf'])){
   //Delete image file
   $id = (int) $_GET['member_id'];
   $image = "";
   $conn = create_connection("ces");
   $query = "SELECT image FROM members WHERE member_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param('i', $id);
   $stmt->bind_result($image);
   $stmt->execute();
   $stmt->fetch();
   unlink("../../members/member_images/".$image);
   $conn->close();
   
   //Delete records from database
   $conn = create_connection("ces");
   $query = "DELETE FROM members WHERE member_id=?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param('i', $id);
   $stmt->execute();
   $conn->close();
}
redirect("./index.php");
?>