<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );

if ( !isset( $_SESSION[ 'admin' ] ) ) {
   redirect( "../index.php" );
}
if(isset($_GET['create_event']) && isset($_GET['event_group']) && $_GET['create_event'] == "true"){
?>
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Create Event</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!--- footer css -->
   <link href="../../css/bootstrap/footer_css.css" rel="stylesheet">
   <link href="../../css/bootstrap/signin.css" rel="stylesheet">

   <!-- Mail css -->
   <link href="../../css/mail.css" rel="stylesheet">
   <link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css'>
   <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Dosis|Candal'>
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
   <br/><br/>
   <form id="event_form" class="form-check" action="event_handler.php" method="post" enctype="multipart/form-data">
      <h2 class="text-info">Create Event  &raquo;<hr/></h2>
      <input type="hidden" name="event_group" value="<?php echo($_GET['event_group']); ?>">
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Title" name="event_title" required/>
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Category (e.g., Coding, Gaming)" name="event_category" required/>
      
      <!-- Text Formatter -->
      <div class="toolbar">
         <a href="#" data-command='undo'><i class='fa fa-undo'></i></a>
         <a href="#" data-command='redo'><i class='fa fa-repeat'></i></a>
         <div class="fore-wrapper"><i class='fa fa-font' style='color:#C96;'></i>
            <div class="fore-palette">
            </div>
         </div>
         <div class="back-wrapper"><i class='fa fa-font' style='background:#C96;'></i>
            <div class="back-palette">
            </div>
         </div>
         <a href="#" data-command='bold'><i class='fa fa-bold'></i></a>
         <a href="#" data-command='italic'><i class='fa fa-italic'></i></a>
         <a href="#" data-command='underline'><i class='fa fa-underline'></i></a>
         <a href="#" data-command='strikeThrough'><i class='fa fa-strikethrough'></i></a>
         <a href="#" data-command='justifyLeft'><i class='fa fa-align-left'></i></a>
         <a href="#" data-command='justifyCenter'><i class='fa fa-align-center'></i></a>
         <a href="#" data-command='justifyRight'><i class='fa fa-align-right'></i></a>
         <a href="#" data-command='justifyFull'><i class='fa fa-align-justify'></i></a>
         <a href="#" data-command='indent'><i class='fa fa-indent'></i></a>
         <a href="#" data-command='outdent'><i class='fa fa-outdent'></i></a>
         <a href="#" data-command='insertUnorderedList'><i class='fa fa-list-ul'></i></a>
         <a href="#" data-command='insertOrderedList'><i class='fa fa-list-ol'></i></a>
         <a href="#" data-command='h1'>H1</a>
         <a href="#" data-command='h2'>H2</a>
         <a href="#" data-command='createlink'><i class='fa fa-link'></i></a>
         <a href="#" data-command='unlink'><i class='fa fa-unlink'></i></a>
         <a href="#" data-command='insertimage'><i class='fa fa-image'></i></a>
         <a href="#" data-command='p'>P</a>
         <a href="#" data-command='subscript'><i class='fa fa-subscript'></i></a>
         <a href="#" data-command='superscript'><i class='fa fa-superscript'></i></a>
      </div>
      <div id='editor' contenteditable>
         <h2>Insert and Style event <font color="#0000cc">Rules</font></h2>
      </div>
      <!-- Text Formatter -->
      <br/>
      <input type="hidden" id="event_rules" name="event_rules" value=""/>
      
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" accept="image/gif, image/x-png, image/jpeg" placeholder="Event Poster" onFocus="(this.type='file')" name="event_poster" />
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Event Date(Can be edited later)(Optional)" onFocus="(this.type='date')" name="event_date"/>
      <div style="max-width: 600px; margin: auto;">
            <textarea class="form-control" placeholder="Event Description" form="event_form" rows="8" name="event_desc" required></textarea>
      </div>
      <div style="max-width: 600px; margin: auto;">
            <textarea class="form-control" placeholder="Coordinators" form="event_form" rows="4" name="event_coord"></textarea>
      </div>
      <input type="submit" class="btn btn-lg btn-primary btn-block" style="max-width: 300px; margin: auto;" name="create_event" value="Create Event" onClick="submitForm();">
   </form>
   <br/>
   <footer class="blog-footer">
      <p>Designed by Prominent Developers</p>
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

   <!-- Mail Js -->
   <script src="../../js/mail.js"></script>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
   <script>
   function submitForm(){
         var content = document.getElementById("editor").innerHTML;
         document.getElementById('event_rules').value = content;
      }
   </script>
</body>
</html>

<!-- Handle event edit request -->
<?php }elseif(isset($_GET['edit_event']) && isset($_GET['event_id']) && isset($_GET['event_group']) && $_GET['edit_event'] == "true"){ 
   $event_id = (int)$_GET['event_id'];
   $event_group = trim($_GET['event_group']);
   $conn = create_connection("ces");
   $query = "SELECT * FROM event WHERE event_id = ? AND event_group = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param('is', $event_id, $event_group);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Edit Event</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <!--- footer css -->
   <link href="../../css/bootstrap/footer_css.css" rel="stylesheet">
   <link href="../../css/bootstrap/signin.css" rel="stylesheet">

   <!-- Mail css -->
   <link href="../../css/mail.css" rel="stylesheet">
   <link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css'>
   <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Dosis|Candal'>
</head>

<body>
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
   <br/><br/>
   <form id="event_form" class="form-check" action="event_handler.php" method="post" enctype="multipart/form-data">
      <h2 class="text-info">Edit Event  &raquo;<hr/></h2>
      <input type="hidden" name="event_group" value="<?php echo($row['event_group']); ?>">
      <input type="hidden" name="event_id" value="<?php echo($row['event_id']); ?>" />
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Title" name="event_title" value="<?php echo($row['event_title']); ?>" required/>
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Category (e.g., Coding, Gaming)" name="event_category" value="<?php echo($row['event_category']); ?>" required/>
      
      <!-- Text Formatter -->
      <div class="toolbar">
         <a href="#" data-command='undo'><i class='fa fa-undo'></i></a>
         <a href="#" data-command='redo'><i class='fa fa-repeat'></i></a>
         <div class="fore-wrapper"><i class='fa fa-font' style='color:#C96;'></i>
            <div class="fore-palette">
            </div>
         </div>
         <div class="back-wrapper"><i class='fa fa-font' style='background:#C96;'></i>
            <div class="back-palette">
            </div>
         </div>
         <a href="#" data-command='bold'><i class='fa fa-bold'></i></a>
         <a href="#" data-command='italic'><i class='fa fa-italic'></i></a>
         <a href="#" data-command='underline'><i class='fa fa-underline'></i></a>
         <a href="#" data-command='strikeThrough'><i class='fa fa-strikethrough'></i></a>
         <a href="#" data-command='justifyLeft'><i class='fa fa-align-left'></i></a>
         <a href="#" data-command='justifyCenter'><i class='fa fa-align-center'></i></a>
         <a href="#" data-command='justifyRight'><i class='fa fa-align-right'></i></a>
         <a href="#" data-command='justifyFull'><i class='fa fa-align-justify'></i></a>
         <a href="#" data-command='indent'><i class='fa fa-indent'></i></a>
         <a href="#" data-command='outdent'><i class='fa fa-outdent'></i></a>
         <a href="#" data-command='insertUnorderedList'><i class='fa fa-list-ul'></i></a>
         <a href="#" data-command='insertOrderedList'><i class='fa fa-list-ol'></i></a>
         <a href="#" data-command='h1'>H1</a>
         <a href="#" data-command='h2'>H2</a>
         <a href="#" data-command='createlink'><i class='fa fa-link'></i></a>
         <a href="#" data-command='unlink'><i class='fa fa-unlink'></i></a>
         <a href="#" data-command='insertimage'><i class='fa fa-image'></i></a>
         <a href="#" data-command='p'>P</a>
         <a href="#" data-command='subscript'><i class='fa fa-subscript'></i></a>
         <a href="#" data-command='superscript'><i class='fa fa-superscript'></i></a>
      </div>
      <div id='editor' contenteditable>
         <?php echo($row['event_rules']); ?>
      </div>
      <!-- Text Formatter -->
      <br/>
      <input type="hidden" id="event_rules" name="event_rules" value=""/>
      
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" accept="image/gif, image/x-png, image/jpeg" placeholder="Event Poster" onFocus="(this.type='file')" name="event_poster" value="<?php echo($row['event_poster']); ?>"/>
      <input type="date" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Event Date(Can be edited later)(Optional)" name="event_date" value="<?php echo(date('Y-m-d', strtotime($row['event_date']))); ?>"/>
      <div style="max-width: 600px; margin: auto;">
            <textarea class="form-control" placeholder="Event Description" form="event_form" rows="8" name="event_desc" required><?php echo($row['event_desc']); ?></textarea>
      </div>
      <div style="max-width: 600px; margin: auto;">
            <textarea class="form-control" placeholder="Coordinators" form="event_form" rows="4" name="event_coord"><?php echo($row['event_coordinators']); ?></textarea>
      </div>
      <input type="submit" class="btn btn-lg btn-primary btn-block" style="max-width: 300px; margin: auto;" name="update_event" value="Update" onClick="submitForm();">
   </form>
   <br/>
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

   <!-- Mail Js -->
   <script src="../../js/mail.js"></script>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
   <script>
   function submitForm(){
         var content = document.getElementById("editor").innerHTML;
         document.getElementById('event_rules').value = content;
      }
   </script>
</body>
</html>
<?php }else{redirect("./");} ?>