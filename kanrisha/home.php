<?php 
session_start();
require("./include/connection.php");
require("./include/functions.php");

//Handle login request
if(isset($_POST['signin'])){
   $email = trim(htmlspecialchars($_POST['email']));
   $password = $_POST['password'];
   $conn = create_connection("ces");
   $query = "SELECT * FROM admin WHERE email = ? and password = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param('ss', $email, $password);
   $stmt->execute();
   $result = $stmt->get_result();
   $rows = (int) $result->num_rows;
   
   if($rows === 1){
      $_SESSION['admin'] = "active";
      $_SESSION['temp_notice_id'] = 0;
   }else {
      redirect("./index.php?error=".urlencode("Email or Password is wrong"));
   }
   $result->free();
   $conn->close();
}

if(!isset($_SESSION['admin'])){
   redirect("./index.php");
}
if(isset($_GET['logout'])){
   session_destroy();
   redirect("./index.php");
}

//Count The percentage of subscribers
$finalYear = $firstYear = $secondYear = $thirdYear = 50;
$conn = create_connection("ces");
$query = "SELECT COUNT(email) AS email_count, designation FROM subscribers GROUP BY designation ORDER BY designation";
$result = $conn->query($query);
if($result->num_rows == 4){
    $row = $result->fetch_assoc();
    $finalYear = (int)$row['email_count'];
    $row = $result->fetch_assoc();
    $firstYear = (int)$row['email_count'];
    $row = $result->fetch_assoc();
    $secondYear = (int)$row['email_count'];
    $row = $result->fetch_assoc();
    $thirdYear = (int)$row['email_count'];
}
$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Admin Home</title>

   <!-- Bootstrap core CSS -->
   <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="../css/bootstrap/dashboard.css" rel="stylesheet">
   
   <!-- Progress Bar Css -->
   <link href="../css/progress_bar.css" rel="stylesheet"></link>
   
   <!--- footer css -->
   <link href="../css/bootstrap/footer_css.css" rel="stylesheet">
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
               <li class="nav-item active">
                  <a class="nav-link" href="#">Home</a>
               </li>

               <li class="nav-item">
                  <a class="nav-link" href="./notice/">Notice</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="./members/">Members</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="./mail/">Mail</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="./event/">Event</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="#">Gallery</a>
                     <a class="dropdown-item" href="./home.php?logout=true">Logout</a>
                  </div>
               </li>
            </ul>
         </div>
      </nav>
   </header>
<br/>
   <div class="container-fluid">

      <main role="main">
      
         <h1>Subscriptions</h1>
         <!-- Progress Bar -->
         
         <div class="set-size charts-container">
  <div class="pie-wrapper style-2">
    <span class="label"><?php echo((int)($firstYear*100/120)); ?><span class="smaller">%</span></span>
    <span class="label" style="transform: translate(0, 30%);"><span class="smaller">First Year</span></span>
    <div class="pie">
      <div class="left-side half-circle" data-rotate="<?php echo((int)($firstYear*100/120)); ?>"></div>
      <div class="right-side half-circle" data-rotate="<?php echo((int)($firstYear*100/120)); ?>"></div>
    </div>
    <div class="shadow"></div>
  </div>

  <div class="pie-wrapper style-2">
    <span class="label"><?php echo((int)($secondYear*100/120)); ?><span class="smaller">%</span></span>
    <span class="label" style="transform: translate(0, 30%);"><span class="smaller">Second Year</span></span>
    <div class="pie">
      <div class="left-side half-circle" data-rotate="<?php echo((int)($secondYear*100/120)); ?>"></div>
      <div class="right-side half-circle" data-rotate="<?php echo((int)($secondYear*100/120)); ?>"></div>
    </div>
    <div class="shadow"></div>
  </div>
  
  <div class="pie-wrapper style-2">
    <span class="label"><?php echo((int)($thirdYear*100/120)); ?><span class="smaller">%</span></span>
    <span class="label" style="transform: translate(0, 30%);"><span class="smaller">Third Year</span></span>
    <div class="pie">
      <div class="left-side half-circle" data-rotate="<?php echo((int)($thirdYear*100/120)); ?>"></div>
      <div class="right-side half-circle" data-rotate="<?php echo((int)($thirdYear*100/120)); ?>"></div>
    </div>
    <div class="shadow"></div>
  </div>
  
  <div class="pie-wrapper style-2">
    <span class="label"><?php echo((int)($finalYear*100/120)); ?><span class="smaller">%</span></span>
    <span class="label" style="transform: translate(0, 30%);"><span class="smaller">Final Year</span></span>
    <div class="pie">
      <div class="left-side half-circle" data-rotate="<?php echo((int)($finalYear*100/120)); ?>"></div>
      <div class="right-side half-circle" data-rotate="<?php echo((int)($finalYear*100/120)); ?>"></div>
    </div>
    <div class="shadow"></div>
  </div>
</div>
<!-- /Progress Bar -->
         <?php 
         $conn = create_connection("ces");
         $query = "SELECT * FROM activity_log";
         $result = $conn->query($query);
         $count = 1;
         ?>
         <h2>Activity Log</h2>
         <div class="table-responsive">
            <table class="table table-striped" style="height: 200px;">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Category</th>
                     <th>Title</th>
                     <th>Date</th>
                  </tr>
               </thead>
               <tbody>
               <?php while($row = $result->fetch_assoc()){?>
                  <tr>
                     <td><?php echo($count); ?></td>
                     <td><?php echo($row['identity']); ?></td>
                     <td><a class="text-info" href="<?php if($row['identity'] == 'mail'){echo('./mail/mail_preview.php?mail_id='.$row['id'].'&mail_preview=true');}else{echo('./notice/preview.php?notice_id='.$row['id'].'&preview=true');} ?>" target="_blank"><?php echo(substr($row['title'], 0, 100)."..."); ?></a></td>
                     <td><?php echo(date('Y, m d', strtotime($row['activity_date']))); ?></td>
                  </tr>
                  <?php $count += 1; } $conn->close(); ?>
               </tbody>
            </table>
         </div>
      </main>
   </div>
   
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
   <script>
    var left = document.getElementsByClassName("left-side");
    for(var i = 0; i < left.length; i++ ){
        value = left[i].dataset.rotate;
        if( value <= 50 ){
            left[i].parentNode.parentNode.classList.add("lesser");
            
        }else{
            left[i].parentNode.parentNode.classList.add("greater");
        }
        left[i].style.transform="rotate(" + parseInt(value * 360/100) + "deg)";
    }
    var right = document.getElementsByClassName("right-side");
    for(var i = 0; i < right.length; i++ ){
        value = right[i].dataset.rotate;
        if( value > 50 )
            right[i].style.transform="rotate(180deg)";
    }
</script>
</body>

</html>