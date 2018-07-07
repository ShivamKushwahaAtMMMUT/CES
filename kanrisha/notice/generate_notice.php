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

$notice_id = ( int )$_SESSION[ 'temp_notice_id' ];
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Generate Notice</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!-- Custom styles for this template -->
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

               <li class="nav-item active">
                  <a class="nav-link" href="./index.php">Notice</a>
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
                     <a class="dropdown-item" href="./generate_notice.php?logout=true">Logout</a> s </div>
               </li>
            </ul>
         </div>
      </nav>
   </header>
   <?php if($notice_id > 0){ 
   $id = 0;
   $title = $issue_date = $validity = $content = $image = $video = $document = $link = $associates = "";
   $conn = create_connection("ces");
   $query = "SELECT * FROM notice_temp WHERE notice_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param('i', $notice_id);
   $stmt->bind_result($id, $title, $issue_date, $validity, $content, $image, $video, $document, $link, $associates);
   $stmt->execute();
   $stmt->fetch();
   ?>
   <div class="container">
      <br/> <br/>
      <form class="form-group" id="notice_form" action="notice_handler.php" method="post" enctype="multipart/form-data">
         <h2 class="form-signin-heading">Edit notice</h2>
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Title" name="title" value="<?php echo($title); ?>" required/>
         </div>
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Valid till (date)" onFocus="(this.type='date')" name="validity" value="<?php echo(date('Y-m-d', strtotime($validity))); ?>" reqired/>
         </div>
         <div class="input-group mb-3">
            <textarea class="form-control" placeholder="Notice content" rows="10" form="notice_form" name="content" required>
               <?php echo($content); ?>
            </textarea>
         </div>
         <div class="input-group mb-3">
            <?php if($image !== "") { ?>
            <input id="image_hidden" type="hidden" name="image_uploaded" value="<?php echo($image); ?>"/>
            <input id="image" type="text" class="form-control" accept="image/gif, image/x-png, image/jpeg" placeholder="Notice image (optional)" name="image" value="<?php echo($image); ?>" readonly/>
            <div class='input-group-append' onClick="updateUpload(this, 'image_hidden', 'image');">
               <a class="btn btn-outline-warning">Remove image</a>
            </div>
            <?php }else { ?>
            <input type="hidden" name="image_uploaded" value=""/>
            <input type="text" class="form-control" accept="image/gif, image/x-png, image/jpeg" placeholder="Notice image (optional)" onFocus="(this.type = 'file')" name="image"/>
            <?php } ?>
         </div>
         <div class="input-group mb-3">
            <input type="url" class="form-control" placeholder="Youtube video link (optional)" name="video" value="<?php echo($video); ?>"/>
         </div>
         <div class="input-group mb-3">
            <?php if($document !== ""){ ?>
            <input id="document_hidden" type="hidden" name="document_uploaded" value="<?php echo($document); ?>"/>
            <input id="document" type="text" class="form-control" placeholder="Document file (optional)" name="document" value="<?php echo($document); ?>" readonly/>
            <div class='input-group-append' onClick="updateUpload(this, 'document_hidden', 'document');">
               <a class="btn btn-outline-warning" onClick="">Remove Document</a>
            </div>
            <?php }else { ?>
            <input type="hidden" name="document_uploaded" value=""/>
            <input type="text" class="form-control" placeholder="Document file (optional)" onFocus="(this.type = 'file')" name="document"/>
            <?php } ?>
         </div>
         <div class="input-group mb-3">
            <input type="url" class="form-control" placeholder="External Link (optional)" name="link" value="<?php echo($link); ?>"/>
         </div>
         <div class="input-group mb-3">
            <textarea class="form-control" placeholder="Associate members (optional)" rows="6" form="notice_form" name="associates"/>
            <?php echo($associates); ?>
            </textarea>
         </div>
         <div class="input-group mb-3">
            <input type="hidden" name="edit" value="true"/>
            <input type="submit" class="btn btn-lg btn-primary" name="preview" value="Preview">
         </div>
      </form>

   </div>
   <!-- /container -->
   <?php }else { ?>
   <div class="container">
      <br/><br/>
      <form class="form-group" id="notice_form" action="notice_handler.php" method="post" enctype="multipart/form-data">
         <h2 class="form-signin-heading">Generate new notice</h2>
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Title" name="title" required/>
         </div>
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Valid till (date)" onFocus="(this.type='date')" name="validity" reqired/>
         </div>
         <div class="input-group mb-3">
            <textarea class="form-control" placeholder="Notice content" rows="10" form="notice_form" name="content" required></textarea>
         </div>
         <div class="input-group mb-3">
            <input type="text" class="form-control" accept="image/gif, image/x-png, image/jpeg" placeholder="Notice image (optional)" onFocus="(this.type='file')" name="image"/>
            <div class="input-group-append">
            </div>
         </div>
         <div class="input-group mb-3">
            <input type="url" class="form-control" placeholder="Youtube video link (optional)" name="video"/>
         </div>
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Document file (optional)" onFocus="(this.type = 'file')" name="document"/>
         </div>
         <div class="input-group mb-3">
            <input type="url" class="form-control" placeholder="External Link (optional)" name="link"/>
         </div>
         <div class="input-group mb-3">
            <textarea class="form-control" placeholder="Associate members (optional)" rows="6" form="notice_form" name="associates"/></textarea>
         </div>
         <div class="input-group mb-3">
            <input type="hidden" name="edit" value="false"/>
            <input type="submit" class="btn btn-lg btn-primary" name="preview" value="Preview">
         </div>
      </form>
   </div>
   <?php } ?>
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
      function updateUpload( a, hidden, input_type ) {
         a.parentNode.removeChild( a );
         document.getElementById( hidden ).value = "";
         input_type = document.getElementById( input_type );
         input_type.readOnly = false;
         input_type.value = "";
         input_type.onfocus = function () {
            this.type = 'file';
         }
      }
   </script>
</body>

</html>