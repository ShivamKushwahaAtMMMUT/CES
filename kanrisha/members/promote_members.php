<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );
if(!isset($_SESSION['admin'])){
   redirect("../index.php");
}

if ( isset( $_POST[ 'promote' ] ) ) {
   $email = trim( htmlspecialchars( $_POST[ 'email' ] ) );
   $password = $_POST[ 'password' ];
   $is_valid_admin = false;

   $db_email = null;
   $db_password = null;
   $conn = create_connection( "ces" );
   $query = "SELECT * FROM admin WHERE email=?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 's', $email );
   $stmt->execute();
   $stmt->bind_result( $db_email, $db_password );
   $stmt->fetch();
   $conn->close();
   //$conn->close();
   if ( $email === $db_email && $password === $db_password ) {
      $conn = create_connection("ces");
      $promote_query = "UPDATE members SET year = year+1 WHERE year IN(2, 3, 4)";
      $result = $conn->query($promote_query);
      $result->free();
      $conn->close();
   }
   redirect( "./members_admin.php" );
}
redirect("./index.php");
?>