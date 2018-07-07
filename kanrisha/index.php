<?php
session_start();
$warning = "";
require( "./include/connection.php" );
require( "./include/functions.php" );
if ( isset( $_GET[ 'error' ] ) ) {
   $warning = urldecode($_GET['error']);
}
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Signin as Admin</title>

   <!-- Bootstrap core CSS -->
   <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="../css/bootstrap/signin.css" rel="stylesheet">
</head>

<body>
<!-- Header
</body> -->
   <div class="container">

      <form class="form-signin" action="./home.php" method="post">
         <h2 class="form-signin-heading">Please sign in</h2>
         <div class="text-danger">
            <?php if($warning !== "") echo($warning); ?>
         </div>
         <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus/>
         <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
         <input type="submit" class="btn btn-lg btn-primary btn-block" name="signin" value="Submit">
         <center><p class="lead form-control-plaintext">Back to <a href="../">Home</a></p></center>
      </form>

   </div>
   <!-- /container -->
</body>

</html>