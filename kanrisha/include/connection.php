<?php

function create_connection( string $database ) {
   $conn = new MySQLi( "localhost", "shivam", "hesoyam26", $database, 3306 );
   if($conn->connect_errno)
   {
      echo "Failed to create connection";
      return;
   }
   return($conn);
}
?>