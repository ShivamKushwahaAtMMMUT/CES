<?php
require( "../include/connection.php" );
require( "../include/functions.php" );
$mail_sent = 0;
//Handle check request from ajax
if ( isset( $_GET[ 'subscription_check' ] ) ) {
   $email = trim( $_GET[ "email" ] );
   //echo "Email:  $email<br>";
   $conn = create_connection( "ces" );
   $row = check_for_user( $conn, "subscribers", $email );
   if ( $row == 0 )
      echo("ok");
   else
      echo("nope");
   $conn->close();
   die();
}
?>

<?php
if ( isset( $_GET[ 'resend_link' ] ) ) {
   $email = trim( $_GET[ 'email' ] );
   $code = trim( $_GET[ 'code' ] );
   $conn = create_connection( "ces" );
   $row = check_for_user( $conn, "subscribers", $email );
   $conn->close();
   if ( $row == 1 ) {
      echo( "verified" );
   } else {
      $conn = create_connection( "ces" );
      $query = "SELECT * FROM subscriber_varification WHERE email = '{$email}' AND conf_code LIKE '___{$code}%'";
      $result = $conn->query($query);
      $row_count = ( int )$result->num_rows;
      if ( $row_count == 1 ) {
         $row = $result->fetch_assoc();
         $message = send_activation_link( $row[ 'name' ], $row[ 'email' ], $row[ 'conf_code' ] ) ? "success" : "error";
         echo($message);
      } else {
         echo( "failed" );
      }
   }
   die();
}
?>

<?php
if ( isset( $_POST[ 'subscribe' ] ) ) {
   $name = htmlspecialchars( trim( $_POST[ 'name' ] ) );
   $email = trim( $_POST[ 'email' ] );
   $designation = trim( $_POST[ 'designation' ] );
   //Check for existing subscriber
   $conn = create_connection( "ces" );
   $row = check_for_user( $conn, "subscribers", $email );
   $conn->close();
   if ( $row == 0 ) {
      $conf_code = generate_conf_code( $email );
      $mail_sent = send_activation_link( $name, $email, $conf_code ) ? 1 : 0;
      //Insert confirmation data into database
      $conn = create_connection( "ces" );
      $query = "INSERT IGNORE INTO subscriber_varification (name, email, designation, conf_code, status) values (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare( $query );
      $status = '0';
      $stmt->bind_param( 'sssss', $name, $email, $designation, $conf_code, $status );
      $stmt->execute();
      $conn->close();
   }
   ?>

   <!doctype html>
   <html>

   <head>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great">
      <title>CES MMMUT</title>
   </head>
   <style>
      body {
         padding: 0;
         margin: 0;
      }
      
      .header {
         width: 100%;
         height: 150px;
         background: ;
      }
      
      #background1,
      #background2,
      #background3 {
         width: 100%;
         height: 100%;
         position: fixed;
         top: 0;
         text-align: center;
      }
      
      #background1 span {
         display: inline-block;
         margin-top: 50%;
         transform: translate(0%, -100%);
         font-size: 500px;
         color: rgba(100, 100, 100, 0.2);
         font-family: Fredericka the Great;
      }
      
      #background2 {
         transform: skewX(-30deg);
      }
      
      #background2 span {
         display: inline-block;
         margin-top: 50%;
         transform: translate(10%, -40%);
         font-size: 500px;
         color: rgba(100, 100, 100, 0.08);
         font-family: Fredericka the Great, monospace;
      }
      
      #message {
         margin-left: 10px;
         position: relative;
         z-index: 3;
      }
      
      #message-header {
         font-size: 40px;
         ;
         font-family: Lobster, monospace;
         margin-bottom: 10px;
      }
      
      #message-content {
         font-family: Open Sans, sans-serif;
      }
      
      #note {
         font-family: Merriweather;
      }
      
      .clickable {
         height: 35px;
         font-family: Open Sans;
         cursor: pointer;
         background: greenyellow;
         border: none;
         border-radius: 4px;
         box-shadow: 0px 0px 0px 3px lightgreen;
      }
      
      .non_clickable {
         height: 35px;
         font-family: Open Sans;
         cursor: not-allowed;
         border: none;
         border-radius: 4px;
         box-shadow: 0px 0px 0px 3px #e0e0e0;
      }
      
      #timer {
         display: inline;
         margin-left: 30px;
         font-size: 20px;
      }
   </style>

   <body onload="timerHandler();">
      <div id="background1"><span>CES</span>
      </div>
      <div id="background2"><span>CES</span>
      </div>
      <div class="header"></div>

      <!-- --------------------First Message Block ------------------------------ -->
      <?php if($row == 1){ ?>
      <div id="message">
         <div id="message-header"> <span style="margin-bottom: 10px; display: inline-block"> Email has been already registered.</span> </div>
         <div id="message-content"> If you are not receiving the notifications then check your black list or spam folder. </div>
         <br>
         <div id="note">
            <spam><b>NOTE:</b>
            </spam>
            <span style="font-style: italic; opacity: 1; color: #999"> For any queries, contact administrator.</span> </div>
         <br>
      </div>

      <!-- ----------- Second Message Block --------------------------- -->
      <?php }elseif($mail_sent == 1){ ?>
      <div id="message">
         <div id="message-header"> <span style="margin-bottom: 10px; display: inline-block">Thank you for your interest in CES</span><br>
            <span style="font-family: Merriweather; font-size: 30px;">ONE LAST STEP !!!</span> </div>
         <div id="message-content"> An email verification page has beed sent to
            <?php echo($email); ?>. Please verfiy your email to start receiving notifications from <a href="http://localhost.000webhost.com" style="text-decoration: none; color: black"><b>CES</b></a> </div>
         <br>
         <div id="note">
            <spam><b>NOTE:</b>
            </spam>
            <span style="font-style: italic; opacity: 1; color: #999"> If you don't see any confirmation email then check your spam or junk folder.</span> </div>
         <br>
         <button id="timer_btn" type="button" class="clickable" data-email="<?php echo($email); ?>" data-code="<?php echo(substr($conf_code, 3, 5)); ?>" onclick="sendData(this);">Resend Verification</button>
         <div id="timer">5 : 00</div>
      </div>
      <script>
         function timerHandler() {
            document.getElementById( "timer_btn" ).setAttribute( "class", "non_clickable" );
            document.getElementById( "timer_btn" ).setAttribute( "disabled", "disabled" );
            var time = 300;
            var x;
            var comedown = function () {
               time--;
               var s = parseInt( time / 60 ) + " : " + ( time % 60 < 10 ? ( "0" + time % 60 ) : time % 60 );
               if ( time == 0 ) {
                  clearInterval( x );
                  document.getElementById( "timer_btn" ).removeAttribute( "disabled" );
                  document.getElementById( "timer_btn" ).setAttribute( "class", "clickable" );
                  document.getElementById( "timer" ).innerHTML = "";
                  return;
               }
               document.getElementById( "timer" ).innerHTML = s;
            }
            x = setInterval( comedown, 1000 );

         }

         function sendData( button ) {
            var email = button.dataset.email;
            var code = button.dataset.code;
            console.log(email);
            console.log(code);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
               if ( this.readyState == 4 && this.status == 200 ) {
                  text = this.responseText;
                  console.log(text);
                  if ( text.search("success") >= 0 ) {
                     timerHandler();
                  } else if( text.search("verified") >= 0 ){
                     button.parentNode.removeChild(button);
                     document.getElementById("timer").parentNode.removeChild(document.getElementById("timer"));
                  } else if( text.search("error") ){
                      document.getElementById("timer").innerHTML = "<span style='font-style: italic; opacity: 1; color: #999'> Request failed, Try again !!!</span>";
                  }
               }
            };
            xhttp.open( "GET", "./info.php?resend_link=true&email="+email+"&code="+code, true );
            xhttp.send();
         }
      </script>
      <?php } ?>
   </body>

   </html>
   <!--- Handle Confirmation request -->
   <?php
} elseif ( isset( $_GET[ 'conf_code' ] ) ) {
      $conf = 0;
      $info = "";
      $conf_code = $_GET[ 'conf_code' ];
      $conn = create_connection( "ces" );
      $query = "SELECT * FROM subscriber_varification WHERE conf_code = ?";
      $stmt = $conn->prepare( $query );
      $stmt->bind_param( 's', $conf_code );
      $stmt->execute();
      $result = $stmt->get_result();
      $rows = ( int )$result->num_rows;
      $conn->close();
      if ( $rows == 1 ) {
         $conf = 1;
         //Check for cofirmation status
         $status = "";
         $conn = create_connection( "ces" );
         $query = "SELECT status FROM subscriber_varification WHERE conf_code = ?";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 's', $conf_code );
         $stmt->bind_result( $status );
         $stmt->execute();
         $stmt->fetch();
         $conn->close();
         if ( $status == "1" ) {
            $info = "Email has been already verified. You will receive our notification and updates regularly.";
         } else {
            //Copy data to subscribers table
            $conn = create_connection( "ces" );
            $query = "INSERT INTO subscribers (name, email, designation) SELECT name, email, designation FROM subscriber_varification WHERE conf_code = ?";
            $stmt = $conn->prepare( $query );
            $stmt->bind_param( 's', $conf_code );
            $stmt->execute();
            $conn->close();
            //Change status for email
            $conn = create_connection( "ces" );
            $query = "UPDATE subscriber_varification SET status = '1' WHERE conf_code = ?";
            $stmt = $conn->prepare( $query );
            $stmt->bind_param( 's', $conf_code );
            $stmt->execute();
            $conn->close();
            $info = "Email successfully verified. You can now recieve latest notifications and updates from Computer Engineering Society, MMMUT";
         }
      }
      ?>
      <!doctype html>
      <html>

      <head>
         <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather">
         <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
         <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
         <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great">
         <title>The Last Step</title>
      </head>
      <style>
         body {
            padding: 0;
            margin: 0;
         }
         
         .header {
            width: 100%;
            height: 150px;
            background: ;
         }
         
         #background1,
         #background2,
         #background3 {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            text-align: center;
         }
         
         #background1 span {
            display: inline-block;
            margin-top: 50%;
            transform: translate(0%, -100%);
            font-size: 500px;
            color: rgba(100, 100, 100, 0.2);
            font-family: Fredericka the Great;
         }
         
         #background2 {
            transform: skewX(-30deg);
         }
         
         #background2 span {
            display: inline-block;
            margin-top: 50%;
            transform: translate(10%, -40%);
            font-size: 500px;
            color: rgba(100, 100, 100, 0.08);
            font-family: Fredericka the Great, monospace;
         }
         
         #message {
            margin-left: 10px;
            position: relative;
            z-index: 3;
         }
         
         #message-header {
            font-size: 40px;
            ;
            font-family: Lobster, monospace;
            margin-bottom: 10px;
         }
         
         #message-content {
            font-family: Open Sans, sans-serif;
         }
         
         #note {
            font-family: Merriweather;
         }
         
         .clickable {
            height: 35px;
            font-family: Open Sans;
            cursor: pointer;
            background: greenyellow;
            border: none;
            border-radius: 4px;
            box-shadow: 0px 0px 0px 3px lightgreen;
         }
         
         .non_clickable {
            height: 35px;
            font-family: Open Sans;
            cursor: not-allowed;
            border: none;
            border-radius: 4px;
            box-shadow: 0px 0px 0px 3px #e0e0e0;
         }
         
         #timer {
            display: inline;
            margin-left: 30px;
            font-size: 20px;
         }
      </style>

      <body onload="timerHandler();">
         <div id="background1"><span>CES</span>
         </div>
         <div id="background2"><span>CES</span>
         </div>
         <div class="header"></div>


         <!-- --------------------First Message Block ------------------------------ -->
         <?php if($conf == 1){ ?>
         <div id="message">
            <div id="message-header"> <span style="margin-bottom: 10px; display: inline-block"> You are our subscriber !!</span> </div>
            <div id="message-content">
               <?php echo($info); ?> </div>
            <br>
            <div id="note">
               <spam><b>NOTE:</b>
               </spam>
               <span style="font-style: italic; opacity: 1; color: #999"> For any queries, contact administrator.</span> </div>
            <br>
         </div>

         <!-- --------------------Second Message Block ------------------------------ -->
         <?php }else{ ?>
         <div id="message">
            <div id="message-header"> <span style="margin-bottom: 10px; display: inline-block">Wait Wait !!</span> </div>
            <div id="message-content"> Confirmation link is invalid. Please do not alter the url sent to your mail for confirmation. </div>
            <br>
            <div id="note">
               <spam><b>NOTE:</b>
               </spam>
               <span style="font-style: italic; opacity: 1; color: #999"> For any queries, contact administrator.</span> </div>
            <br>
         </div>
         <?php } ?>

      </body>

      </html>
      <?php }else{redirect("./");} ?>