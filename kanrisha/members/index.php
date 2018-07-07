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

   <title>Members Admin</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="../../css/bootstrap/members_admin.css" rel="stylesheet">

   <!--- Custrom style for form -->
   <link href="../../css/bootstrap/signin.css" rel="stylesheet">

   <!--- footer css -->
   <link href="../../css/bootstrap/footer_css.css" rel="stylesheet">

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
               <li class="nav-item active">
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
                     <a class="dropdown-item" href="./index.php?logout=true">Logout</a>
                  </div>
               </li>
            </ul>
         </div>
      </nav>
   </header>

   <main role="main">

      <section class="jumbotron text-center">
         <div class="container">
            <h1 class="jumbotron-heading">Promote all members to next year</h1>
            <p class="lead text-muted">Promoting members to next year will promote 2nd year members to 3rd year and 3rd year to Final year. It will clean up current 2nd year and final year. So you will add 2nd year manually.</p>
               <form class="form-inline" action="./promote_members.php" method="post">
                  <input type="email" class="form-control" placeholder="Email Address" name="email" required/>
                  <input type="password" class="form-control" placeholder="Password" name="password" required/>
                  <input type="submit" class="btn btn-primary" name="promote" value="Promote"/>
               </form>
         </div>
      </section>

      <div class="container">
         <form class="form-signin" action="add_member.php" method="post" enctype="multipart/form-data">
            <h2 class="form-signin-heading">Add new member</h2>
            <input type="text" accept="image/gif, image/x-png, image/jpeg" class="form-control" placeholder="Member Portrait" onFocus="(this.type='file')" name="image" required/>
            <input type="text" class="form-control" placeholder="Name" name="member_name" value="" required/>
            <input type="text" class="form-control" placeholder="Designation" name="designation" required />
            <select class="form-control" name="year" required>
               <option value="2" selected="selected">2nd year</option>
               <option value="3">3rd year</option>
               <option value="4">final year</option>
               <option value="0">faculty</option>
            </select>
            <input type="text" class="form-control" placeholder="LinkedIn" name="linkedin" value=""/>
            <input type="text" class="form-control" placeholder="Facebook" name="facebook" value=""/>
            <input type="text" class="form-control" placeholder="Email" name="email" value=""/>
            <input type="submit" class="btn btn-lg btn-primary btn-block" name="add_member" value="Add member"/>
         </form>
      </div>

      <div class="album text-muted">
         <h2 class="text-left text-info">Current members</h2>
         <br/>
         <div class="container">

            <div class="row">
               <?php 
               $conn = create_connection("ces");
               $query = "SELECT * FROM (SELECT *, 1 AS count FROM members WHERE year = 0) AS a UNION SELECT * FROM (SELECT *, 2 AS count FROM members WHERE year != 0) AS b ORDER BY count ASC, year DESC, name ASC";
               $stmt = $conn->prepare($query);
               $stmt->execute();
               $result = $stmt->get_result();
               while($row = $result->fetch_assoc())
               {
               ?>
               <div class="card">
                  <img class="img-fluid" src="../../members/member_images/<?php echo($row['image']); ?>">
                  <p class="card-text">
                     <form class="form-singin" action="update_member.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" name="member_id" value="<?php echo($row['member_id']); ?>" required/>
                        <input type="text" accept="image/gif, image/x-png, image/jpeg" class="form-control" placeholder="Member Portrait" onFocus="(this.type='file')" name="image"/>
                        <input type="text" class="form-control" placeholder="Name" name="member_name" value="<?php echo($row['name']); ?>" required/>
                        <input type="text" class="form-control" placeholder="Designation" name="designation" value="<?php echo($row['designation']); ?>" required />
                        <select class="form-control" name="year" required>
                           <?php 
                           if($row['year'] == 0)
                           {
                              echo '<option value="2">2nd year</option>
                           <option value="3">3rd year</option>
                           <option value="4">final year</option>
                           <option value="0" selected="selected" >faculty</option>';
                           }elseif($row['year'] == 2){
                              echo '<option value="2" selected="selected" >2nd year</option>
                           <option value="3">3rd year</option>
                           <option value="4">final year</option>
                           <option value="0">faculty</option>';
                           }elseif($row['year'] == 3){
                              echo '<option value="2">2nd year</option>
                           <option value="3" selected="selected" >3rd year</option>
                           <option value="4">final year</option>
                           <option value="0">faculty</option>';
                           }elseif($row['year'] == 4){
                              echo '<option value="2">2nd year</option>
                           <option value="3">3rd year</option>
                           <option value="4" selected="selected" >final year</option>
                           <option value="0">faculty</option>';
                           }
                           ?>
                        </select>
                        <input type="text" class="form-control" placeholder="LinkedIn" name="linkedin" value="<?php echo($row['linkedin']); ?>"/>
                        <input type="text" class="form-control" placeholder="Facebook" name="facebook" value="<?php echo($row['facebook']); ?>"/>
                        <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo($row['email']); ?>"/>
                        <input type="submit" class="btn btn-lg btn-primary btn-block" name="update_member" value="Update member"/>
                     </form>
                     <br/>
                     <p class="text-warning">Not an executive member, <a href="./remove_member.php?member_id=<?php echo($row['member_id']); ?>&conf=1">Remove</a>
                     </p>
                  </p>
               </div>
               <?php 
               }
               $result->free();
               $conn->close();
               ?>
            </div>

         </div>
      </div>

   </main>

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