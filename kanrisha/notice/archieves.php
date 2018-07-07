<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );
if ( !isset( $_SESSION[ 'admin' ] ) ) {
   redirect( "../index.php" );
}
if ( isset( $_GET[ 'logout' ] ) ) {
    session_destroy();
   redirect( "../index.php" );
}
?>
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Archieved Notices</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="../../css/bootstrap/notice_admin.css" rel="stylesheet">

   <!--- footer css -->
   <link href="../../css/bootstrap/footer_css.css" rel="stylesheet">

</head>

<body>
<!-- Header
</body> -->
   <div class="container">

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

                  <li class="nav-item active">
                     <a class="nav-link" href="#">Notice</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../members/">Members</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../mail/">Mail</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="../event/">Event</a>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</a>
                     <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">Gallery</a>
                        <a class="dropdown-item" href="./archieves.php?logout=true">Logout</a>
                     </div>
                  </li>
               </ul>
            </div>
         </nav>
      </header>

      <main role="main">

         <br/> <br/> <br/>
         <h2 class="text-info">Archieved notices  &raquo;<hr/></h2>
         <div class="row">
            <?php 
           $conn = create_connection("ces");
           $query = "SELECT * FROM notice WHERE TIMESTAMPDIFF(DAY, CURRENT_TIMESTAMP, validity) < 0 ORDER BY issue_date DESC";
           $result = $conn->query($query);
           while($row = $result->fetch_assoc()){
         ?>
            <div class="col-lg-4" style="background-color:#F1F1F1; border:solid 4px #fff; border-style: dashed; margin-bottom: 0; height: 400px;">
               <div style=" height: 335px; overflow: auto;">
                  <h4>
                     <?php echo($row['title']); ?>
                  </h4>
                  <p style="white-space: pre-line">
                     <?php echo(substr($row['content'], 0, 200)); 
                  if(strlen($row['content']) > 200){
                     echo("......");
                  }
                  ?>

                  </p>
                  <div class="text-primary">Issue date:
                     <?php echo(date('M d, Y', strtotime($row['issue_date']))); ?>
                  </div>
                  <div class="text-primary">Valid till:
                     <?php echo(date('M d, Y', strtotime($row['validity']))); ?>
                  </div>
               </div>
               <div style="height: 50px; position: absolute; bottom: 0px; padding-top: 5px;">
                  <a class="btn btn-primary" href="./preview.php?notice_id=<?php echo($row['notice_id']); ?>&preview=true" role="button" target="_blank">Preview &raquo;</a>
                  <a class="btn btn-danger" href="./notice_handler.php?notice_id=<?php echo($row['notice_id']); ?>&delete_archieve=true" role="button">Delete &raquo;</a>
               </div>
            </div>
            <?php } ?>
         </div>

         <div class="jumbotron">
            <hr/>
            <p class="lead">Notices inside the validity are active notices</p>
            <a class="btn btn-lg btn-dark" href="./index.php" role="button">Active Notices</a>
         </div>

         <div class="jumbotron">
            <hr/>
            <p class="text-warning">After preview, if notice is not submitted and process is aborted, then those notices remain in unfinished state</p>
            <a class="btn btn-warning" href="./unfinished.php" role="button">Unfinished Notices</a>
         </div>

      </main>

   </div>
   <!-- /container -->

   <!-- Site footer -->
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