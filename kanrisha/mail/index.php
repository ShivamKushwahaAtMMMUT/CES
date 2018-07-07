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

   <title>Mail</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.css" rel="stylesheet">

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
               <li class="nav-item active">
                  <a class="nav-link" href="#">Mail</a>
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
   <br/><br/>
   <form id="mail-form" class="form-check" action="mail_handler.php" method="post" enctype="multipart/form-data">
      <a href="./mail_log.php"><h4 class="text-info" style="display: inline-block; border: solid 2px #6FCEF3; border-radius: 5px; padding: 5px 5px;">Mail Log</h4></a>
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Subject" name="subject" required/>
      
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
         <a href="#" data-command='p'>P</a>
         <a href="#" data-command='subscript'><i class='fa fa-subscript'></i></a>
         <a href="#" data-command='superscript'><i class='fa fa-superscript'></i></a>
      </div>
      <div id='editor' contenteditable>
         <h2>Insert and Style your content</h2>
      </div>
      <!-- Text Formatter -->
      <br/>
      <input type="text" class="form-control" style="max-width: 600px; margin: auto;" placeholder="Document(Optional)" onFocus="(this.type='file')" name="document">
      <div style="max-width: 600px; margin: auto;">
         <div class="form-check form-check-inline">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" onclick="handleClick('individual','group');" name="mailTo" value="individual" checked/>Indivudual 
            </label>
         
         </div>
         <div class="form-check form-check-inline">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" onclick="handleClick('group','individual');" name="mailTo" value="group"  />Group 
            </label>
         </div>

         <input id="individual" type="email" class="form-control" style="max-width: 600px; margin: auto; display: block" placeholder="Receiver's email" name="individualMail" required />

         <div id="group" style="display: none;">
            <div class="form-check form-check-inline">
               <label class="form-check-label">
            <input type="checkbox" name="cesMembers" value="cesMembers"/>CES Members <br/>
              </label>
            
            </div>
            <div class="form-check form-check-inline">
               <label class="form-check-label">
            <input type="checkbox" name="firstYear" value="firstYear"/>First Year<br/>
               </label>
            
            </div>
            <div class="form-check form-check-inline">
               <label class="form-check-label">
            <input type="checkbox" name="secondYear" value="secondYear"/>Second Year<br/>
               </label>
            
            </div>
            <div class="form-check form-check-inline">
               <label class="form-check-label">
            <input type="checkbox" name="thirdYear" value="thirdYear"/>Third Year<br/>
               </label>
            
            </div>
            <div class="form-check form-check-inline">
               <label class="form-check-label">
            <input type="checkbox" name="finalYear" value="finalYear"/>Final Year<br/>
               </label>
            </div>
            
            <div id="manualCheckBox" class="form-check form-check-inline">
               <label class="form-check-label">
            <input type="checkbox" onclick="handleCheck(this);" name="manual" value="manual" />Add Manually <br/>
               </label>
            
            </div>
            <div id="manualTextArea" style="display: none">
               <textarea class="form-control" placeholder="Enter emails separated by semicolon(;)" form="mail-form" name="manualMails"></textarea>
            </div>
         </div>
      </div>
      <br/>
      <input type="hidden" id="content" name="content" value=""/>
      <input type="submit" class="btn btn-lg btn-primary btn-block" style="max-width: 300px; margin: auto;" name="mail" value="Dispatch Mail" onClick="submitForm();">
   </form>
   <br/>
   <footer class="blog-footer">
      <p>Designed by <a href="http://www.facebook.com/ProminentDevelopers/" target="_blank">Prominent Developers</a>a</p>
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

      function handleClick( show, hide ) {
         document.getElementById( show ).style.display = "block";
         document.getElementById( hide ).style.display = "none";
         if(hide == "individual")
            document.getElementById("individual").removeAttribute("required");
         else
            document.getElementById("individual").setAttribute("required", "required");
      }

      function handleCheck( box ) {
         if ( box.checked ) {
            document.getElementById( "manualTextArea" ).style.display = "block";
         } else {
            document.getElementById( "manualTextArea" ).style.display = "none";
         }
      }
      
      function submitForm(){
         var form = document.getElementById("mail-form");
        /* var content = "<!doctype html> <html> <head> <title> CES MMMUT </title> </head> <body> " + document.getElementById("editor").innerHTML + " </body> </html>";*/
         var content = '<!doctype html> <html> <head> <title> CES MMMUT </title> </head> <body> ' + document.getElementById("editor").innerHTML + ' </body> </html>';
         document.getElementById('content').value = content;
         //form.submit();
      }
   </script>
   <!-- Mail Js -->
   <script src="../../js/mail.js"></script>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>

</html>