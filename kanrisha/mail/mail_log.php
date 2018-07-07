<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );

if ( !isset( $_SESSION[ 'admin' ] ) ) {
   redirect( "../index.php" );
}
?>

<!doctype html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Mail Log</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.css" rel="stylesheet">

   <!--- footer css -->
   <link href="../../css/bootstrap/footer_css.css" rel="stylesheet">
   <link href="../../css/bootstrap/signin.css" rel="stylesheet">
</head>

<body>
<!-- Header
</body> -->
<header class="masthead">
      <nav class="navbar navbar-expand-md navbar-light bg-light rounded mb-3 fixed-top">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
         <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav text-md-center nav-justified w-100">
               <li class="nav-item">
                  <a class="nav-link" href="../home.php">Home</a>
               </li>

               <li class="nav-item">
                  <a class="nav-link" href="../notice/">Notice</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="../members/">Members</a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="./">Mail</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="../event/">Event</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="#">Gallery</a>
                     <a class="dropdown-item" href="./index.php?logout=true">Logout</a>
                  </div>
               </li>
            </ul>
         </div>
      </nav>
   </header>
   <br><br>
   <div class="container-fluid">
   
   <main role="main">
   <h2>Mail Log</h2>
   
   <div class="table-responsive">
            <table class="table table-striped" style="height: 200px;">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Date</th>
                     <th>Subject</th>
                     <th>Receivers</th>
                     <th>Content</th>
                  </tr>
               </thead>
               <tbody>
               <?php 
               $conn = create_connection("ces");
               $query = "SELECT * FROM mail_history";
               $result = $conn->query($query);
               $count = 0;
               while($row = $result->fetch_assoc()){
                   $count += 1;
               ?>
                  <tr>
                     <td><?php echo($count); ?></td>
                     <td><?php echo(date('M d, Y', strtotime($row['mail_date']))); ?></td>
                     <td><?php echo($row['subject']);?></td>
                     <td><?php echo($row['receivers']);?></td>
                     <td><a class="btn btn-primary btn-sm" href="./mail_preview.php?mail_id=<?php echo($row['mail_id']); ?>&mail_preview=true" target="_blank">Preview</a></td>
                  </tr>
               <?php } ?>
               </tbody>
            </table>
         </div>
   
   </main>
   
   </div>

<footer class="blog-footer">
      <p>Designed by <a href="http://www.facebook.com/ProminentDevelopers/" target="_blank">Prominent Developers</a></p>
      <p>
         <a href="#">Back to top</a>
      </p>
   </footer>

   <!-- Bootstrap core JavaScript
    ================================================== -->
   <!-- Placed at the end of the document so the pages load faster -->
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   <script>
      window.jQuery || document.write( '<script src="../../js/bootstrap/jquery-slim.min.js"><\/script>' )
   </script>
   <script src="../../js/bootstrap/popper.min.js"></script>
   <script src="../../js/bootstrap/bootstrap.min.js"></script>
</body>

</html>