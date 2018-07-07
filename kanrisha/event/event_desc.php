<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );

if ( !isset( $_SESSION[ 'admin' ] ) ) {
   redirect( "../index.php" );
}
if(isset($_GET['event_desc']) && $_GET['event_desc'] == "true"){
   $event_id = (int) $_GET['event_id'];
   $conn = create_connection("ces");
   $query = "SELECT * FROM event WHERE event_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param('i', $event_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anton">
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
   <link rel="stylesheet" href="../../css/event_desc_admin.css">
   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!--- footer css -->
   <link href="../../css/bootstrap/footer_css.css" rel="stylesheet">
   <meta charset="UTF-8">
   <title><?php echo($row['event_title']); ?></title>
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
               <li class="nav-item">
                  <a class="nav-link" href="../mail/">Mail</a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="./">Events</a>
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
   <div>
      <div class="front">
         <div class="main_img" style="background-image: url(../../event/images/<?php echo($row['event_poster']); ?>);"></div>
         <div class="welcome">
            <span style="font-size: 35px; display: inline-block; margin-top: 5px; letter-spacing: 5px;"><?php echo($row['event_title']); ?></span> <br>
            <span style="display: inline-block; color: #262F39; font-size: 18px; font-weight: 600;"><?php echo($row['event_category']); ?></span>
         </div>
      </div>

      <span style="display: inline-block; height: 30px; width: 100%; text-align: center; font-size: 27px; padding-bottom:24px; color: #2D575F; ">Event Description</span>
      <div class="event_desc">
         <div class="desc" id="desc" style="white-space: preline">
            <p><?php echo($row['event_desc']); ?></p>
         </div>
      </div>
      <div class="rules">
         <h1>Rules to follow  &raquo;</h1>
         <?php echo($row['event_rules']); ?>
      </div>
      <div class="associates ">
         <p style="font-size: 110%; font-family: 'Open Sans'; font-weight: bold; text-decoration: underline magenta; ">&nbsp;Coordinators&nbsp; </p>
         <div class="bande">
            <div class="bande_info " style="white-space: pre-line;"> <span><?php echo($row['event_coordinators']); ?></span> </div>
         </div>
      </div>
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
<?php }else{redirect("./");} ?>