<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );

if ( !isset( $_SESSION[ 'admin' ] ) ) {
   redirect( "../index.php" );
}

if ( isset( $_GET[ 'mail_preview' ] ) && isset( $_GET[ 'mail_id' ] ) && $_GET[ 'mail_preview' ] == "true" ) {
   $mail_id = (int)$_GET['mail_id'];
   $conn = create_connection( "ces" );
   $query = "SELECT * FROM mail_history WHERE mail_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param('i', $mail_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $num_rows = $result->num_rows;
   if($num_rows != 1){
       //echo("Hi, I am in 1");
       redirect("./");
   }
   $row = $result->fetch_assoc();
?>

<!doctype html>
<html>
   
   <head>
      <title>Mail Preview</title>
   </head>
   <body>
   <!-- Header
</body> -->
      <?php 
      $content = $row['body'];
      //$content = str_replace("<!doctype html> <html> <head> <title> CES MMMUT </title> </head> <body>", " ", $content);
      //$content = strreplace("</body> </html>", " ", $content);
      echo($content);
      ?>
      <?php if($row['document'] != ""){ ?>
      <p><a href="./documents/<?php echo($row['document']); ?>" target="_blank">Document File</a></p>
      <?php } ?>
   </body>

</html>
<?php }else{/*echo("Hi I am in 2");*/ redirect("./");} ?>