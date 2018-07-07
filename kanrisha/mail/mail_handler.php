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

   <title>Admin Home</title>

   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.css" rel="stylesheet">
   <!--- footer css -->
   <link href="../../css/bootstrap/footer_css.css" rel="stylesheet">
   <!-- Custom styles for this template -->
   <link href="../../css/bootstrap/dashboard.css" rel="stylesheet">
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
               <li class="nav-item active">
                  <a class="nav-link" href="./index.php">Mail</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="../event/">Event</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="#">Gallery</a>
                     <a class="dropdown-item" href="./mail_handler.php?logout=true">Logout</a>
                  </div>
               </li>
            </ul>
         </div>
      </nav>
   </header>
   <br/><br/>
   <div class="container-fluid">
      <main role="main">
         <h2 class="text-info">Mail Receivers   &raquo;<hr/></h2>
         <div class="table-responsive">
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Designation</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  
                  <?php
                  if ( isset( $_POST[ 'mail' ] ) ) {
                     $subject = trim( $_POST[ 'subject' ] );
                     $content = $_POST[ 'content' ];
                     $message = "";
                     $uid = md5( uniqid( time() ) );
                     $from_name = "CES MMMUT";
                     $from_mail = "cesatmmmut@gmail.com";
                     $reply_to = "cesatmmmut@gmail.com";
                     $recievers = "";
                     $document = "";
                     //Generate Header data
                     $header = "From: " . $from_name . "<" . $from_mail . ">\r\n";
                     $header .= "Reply-To: " . $reply_to . "\r\n";
                     $header .= "MIME-Version: 1.0\r\n";
                     $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
                     //Handle document if present
                     if ( isset( $_FILES[ 'document' ][ 'name' ] ) ) {
                        if ( is_uploaded_file( $_FILES[ 'document' ][ 'tmp_name' ] ) ) {
                           $target_dir = "./documents/";
                           $temp = explode( ".", $_FILES[ 'document' ][ 'name' ] );
                           $temp_name = implode( "", array_slice( $temp, 0, -1 ) );
                           $document = "CES" . round( microtime( true ) ) . $temp_name . "." . end( $temp );
                           $target_file = $target_dir . $document;
                           move_uploaded_file( $_FILES[ 'document' ][ 'tmp_name' ], $target_file );
                           $document_content = file_get_contents( $target_file );
                           $document_content = chunk_split( base64_encode( $document_content ) );
                           //Generate message and attachment
                           $message = "--" . $uid . "\r\n";
                           $message .= "Content-type:text/html; charset=iso-8859-1\r\n";
                           $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                           $message .= $content . "\r\n\r\n";
                           $message .= "--" . $uid . "\r\n";
                           $message .= "Content-Type: application/octet-stream; name=\"" . $document . "\"\r\n";
                           $message .= "Content-Transfer-Encoding: base64\r\n";
                           $message .= "Content-Disposition: attachment; filename=\"" . $document . "\"\r\n\r\n";
                           $message .= $document_content . "\r\n\r\n";
                           $message .= "--" . $uid . "--";
                        }
                     } else {
                        $message = "--" . $uid . "\r\n";
                        $message .= "Content-type:text/html; charset=iso-8859-1\r\n";
                        $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                        $message .= $content . "\r\n\r\n";
                        $message .= "--" . $uid . "\r\n";
                     }
                     
                     //Dispatch mail for individuals
                     if ( $_POST[ 'mailTo' ] == "individual" ) {
                        echo("<tr>");
                        $mailTo = trim( $_POST[ 'individualMail' ] );
                        $recievers = $recievers . $mailTo;
                        if ( mail( $mailTo, $subject, $message, $header ) ) {
                           echo("<td> 1 </td>");
                           echo("<td> Unknown</td>");
                           echo("<td> {$mailTo}</td>");
                           echo("<td> Unknown</td>");
                           echo("<td class='text-success'> Successful</td>");
                        } else {
                           echo("<td> 1 </td>");
                           echo("<td> Unknown</td>");
                           echo("<td> {$mailTo}</td>");
                           echo("<td> Unknown</td>");
                           echo("<td class='text-danger'> Failed</td>");
                        }
                        echo("</tr>");
                     }
                     
                     //Dispatch mail for group
                     if ( $_POST[ 'mailTo' ] == "group" ) {
                        if ( isset( $_POST[ 'cesMembers' ] ) ) {
                            $recievers = $recievers . "; CES Memebers";
                           $counter = 1;
                           $conn = create_connection( "ces" );
                           $query = "SELECT * FROM members WHERE year IN(2, 3, 4) AND email != ''";
                           $result = $conn->query( $query );
                           while ( $row = $result->fetch_assoc() ) {
                              echo("<tr>");
                              $mailTo = $row[ 'email' ];
                              if ( mail( $mailTo, $subject, $message, $header ) ) {
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Executive Member </td>" );
                                 echo( "<td class='text-success'> Successful </td>" );
                              }else{
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Executive Member </td>" );
                                 echo( "<td class='text-danger'> Failed </td>" );
                              }
                              $counter += 1;
                           }
                           $conn->close();
                        }
                        
                        if ( isset( $_POST[ 'firstYear' ] ) ) {
                            $recievers  = $recievers . "; First Year";
                           $counter = 1;
                           $conn = create_connection( "ces" );
                           $query = "SELECT * FROM subscribers WHERE designation = 'firstYear'";
                           $result = $conn->query( $query );
                           while ( $row = $result->fetch_assoc() ) {
                              echo("<tr>");
                              $mailTo = $row[ 'email' ];
                              if ( mail( $mailTo, $subject, $message, $header ) ) {
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> First Year </td>" );
                                 echo( "<td class='text-success'> Successful </td>" );
                              }else{
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> First Year </td>" );
                                 echo( "<td class='text-danger'> Failed </td>" );
                              }
                              $counter += 1;
                           }
                           $conn->close();
                        }
                        
                        if ( isset( $_POST[ 'secondYear' ] ) ) {
                            $recievers  = $recievers . "; Second Year";
                           $counter = 1;
                           $conn = create_connection( "ces" );
                           $query = "SELECT * FROM subscribers WHERE designation = 'secondYear'";
                           $result = $conn->query( $query );
                           while ( $row = $result->fetch_assoc() ) {
                              echo("<tr>");
                              $mailTo = $row[ 'email' ];
                              if ( mail( $mailTo, $subject, $message, $header ) ) {
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Second Year </td>" );
                                 echo( "<td class='text-success'> Successful </td>" );
                              }else{
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Second Year </td>" );
                                 echo( "<td class='text-danger'> Failed </td>" );
                              }
                              $counter += 1;
                           }
                           $conn->close();
                        }
                        
                        if ( isset( $_POST[ 'thirdYear' ] ) ) {
                            $recievers  = $recievers . "; Third Year";
                           $counter = 1;
                           $conn = create_connection( "ces" );
                           $query = "SELECT * FROM subscribers WHERE designation = 'thirdYear'";
                           $result = $conn->query( $query );
                           while ( $row = $result->fetch_assoc() ) {
                              echo("<tr>");
                              $mailTo = $row[ 'email' ];
                              if ( mail( $mailTo, $subject, $message, $header ) ) {
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Third Year </td>" );
                                 echo( "<td class='text-success'> Successful </td>" );
                              }else{
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Third Year </td>" );
                                 echo( "<td class='text-danger'> Failed </td>" );
                              }
                              $counter += 1;
                           }
                           $conn->close();
                        }
                        
                        if ( isset( $_POST[ 'finalYear' ] ) ) {
                            $recievers  = $recievers . "; Final Year";
                           $counter = 1;
                           $conn = create_connection( "ces" );
                           $query = "SELECT * FROM subscribers WHERE designation = 'finalYear'";
                           $result = $conn->query( $query );
                           while ( $row = $result->fetch_assoc() ) {
                              echo("<tr>");
                              $mailTo = $row[ 'email' ];
                              if ( mail( $mailTo, $subject, $message, $header ) ) {
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Final Year </td>" );
                                 echo( "<td class='text-success'> Successful </td>" );
                              }else{
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> {$row['name']} </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Final Year </td>" );
                                 echo( "<td class='text-danger'> Failed </td>" );
                              }
                              $counter += 1;
                           }
                           $conn->close();
                        }
                        
                        if ( isset( $_POST[ 'manual' ] ) ) {
                           $counter = 0;
                           $emailList = explode(";", trim($_POST['manualMails']));
                           $arr_length = sizeof($emailList);
                           while ( $counter < $arr_length ) {
                              $mailTo = $emailList[$counter];
                              $recievers  = $recievers . "; " . $mailTo;
                              echo("<tr>");
                              if ( mail( $mailTo, $subject, $message, $header ) ) {
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> Unknown </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Unknown </td>" );
                                 echo( "<td class='text-success'> Successful </td>" );
                              }else{
                                 echo( "<td> {$counter} </td>" );
                                 echo( "<td> Unknown </td>" );
                                 echo( "<td> {$mailTo} </td>" );
                                 echo( "<td> Unknown </td>" );
                                 echo( "<td class='text-danger'> Failed </td>" );
                              }
                              $counter += 1;
                           }
                        }
                     }
                     $conn = create_connection("ces");
                     $query = "INSERT INTO mail_history (subject, body, document, receivers) VALUES (?, ?, ?, ?)";
                     $stmt = $conn->prepare($query);
                     $stmt->bind_param('ssss', $subject, $content, $document, $recievers);
                     $stmt->execute();
                     $conn->close();
                  }
                  ?>
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
      } <
      /body> <
      /html>