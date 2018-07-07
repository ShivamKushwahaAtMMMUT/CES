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
if ( isset( $_GET[ 'preview' ] ) && isset($_GET['notice_id']) ) {
   $notice_id = $_GET[ 'notice_id' ];
   //echo("<h1>Inside Preview <br/> Notice id = $notice_id <br/> </h1>");
   $query = "SELECT * FROM notice WHERE notice_id = ?";
} elseif ( isset( $_GET[ 'preview_unfinished' ] ) ) {
   $notice_id = $_GET[ 'notice_id' ];
   //echo("<h1>Inside Preview Unfinished <br/> Notice id = $notice_id <br/> </h1>");
   $query = "SELECT * FROM notice_temp WHERE notice_id = ?";
} else {
   $notice_id = $_SESSION[ 'temp_notice_id' ];
   //echo("<h1>Inside Sessions <br/> Notice id = $notice_id <br/> </h1>");
   $query = "SELECT * FROM notice_temp WHERE notice_id = ?";
}

$conn = create_connection( "ces" );
$stmt = $conn->prepare( $query );
$stmt->bind_param( 'i', $notice_id );
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
   <link rel="stylesheet" href="../../css/preview.css">

   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">

   <title>
      Notice Preview
   </title>
</head>

<body>
<!-- Header
</body> -->
   <div class="content">
      <div class="left_list">
         <div class="notice_list visible_notice">

            <div class="notice_head" onclick="open_notice(this);">
               <span>
                  <?php echo($row['title']); ?>
               </span>
               <div class="issued">
                  <span>
                     <?php echo(date('Y-M-D', strtotime($row['issue_date']))); ?>
                  </span>
               </div>
               <div class="liner"></div>
            </div>
            <hr>
         </div>

         <?php if(isset($_GET['preview']) || isset($_GET['preview_unfinished'])){ ?>
         <div style="left: 50%;bottom: 10px; width:250px; height: 60px; position: absolute; transform: translate(-50%, 0);">
            <a href="javascript:window.open('','_self').close();">
               <div class="archive_btn" style="width: 100%; height: 30px;">
                  Finish Preview
               </div>
            </a>
         </div>
         <?php }else { ?>
         <div style="left: 50%;bottom: 10px; width:250px; height: 60px; position: absolute; transform: translate(-50%, 0);">
            <a href="generate_notice.php">
               <div class="archive_btn" style="left:0px;">
                  Edit
               </div>
            </a>
            <a href="./notice_handler.php?submit_notice=conf">
               <div class="archive_btn" style="right: 0px;">
                  Submit
               </div>
            </a>
         </div>
         <?php } ?>
      </div>



      <div class="board">
         <div class="notice_content">

            <div class="noti">
            
               <div class="notice_heading">
               <p style="font-weight: 800;">NOTICE-</p>
                  <?php echo($row['title']); ?>
               </div>
               <br>
               <div class="notice_desc" style="white-space: pre-line">
                  <?php echo($row['content']); ?>
               </div>

               <?php 
                  if($row['image'] !== "" && isset($_GET['preview']))
                  {
                     echo("<div class='notice_img'>
                  <center><img src='../../notice/images/{$row['image']}' alt='Notice Image'>
                  </center>
               </div>");
                  }elseif($row['image'] !== ""){
                     echo("<div class='notice_img'>
                  <center><img src='./temp_images/{$row['image']}' alt='Notice Image'>
                  </center>
               </div>");
                  }
               ?>
               <?php if($row['video'] !== ""){ ?>
               <div style="position: relative; margin: 15px 5px;">
                  <center>
                     <iframe width="560" height="315" src="<?php echo($row['video']); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                  </center>
               </div>
               <?php } ?>
               <?php if($row['document'] !== "" || $row['link'] !== ""){ ?>
               <div class="external_content">
                  <p style="font-family: 'Open Sans'; font-weight: bold; text-decoration: underline magenta;">Resources
                  </p>
                  <?php 
                  if($row['document'] !== "" && isset($_GET['preview'])){ ?>
                  <a href="../../notice/documents/<?php echo($row['document']); ?>" target="_blank">
                     <div class="docs btn">
                        Document File
                     </div>
                  </a>
                  <?php  }elseif($row['document'] !== ""){ ?>
                  <a href="./temp_documents/<?php echo($row['document']); ?>" target="_blank">
                     <div class="docs btn">
                        Document File
                     </div>
                  </a>
                  <?php } ?>
                  <?php
                  if ( $row[ 'link' ] !== "" ) {
                     $parsed_link = parse_url( $row[ 'link' ] );
                     $domain = $parsed_link[ 'host' ];
                     ?>
                  <a href="<?php echo($row['link']); ?>" target="_blank">
                     <div class="docs btn" style="text-transform: capitalize;">
                        <?php echo($domain); ?>
                     </div>
                  </a>
                  <?php } ?>
               </div>
               <?php } ?>
               <?php if($row['associates'] !== ""){ ?>
               <div class="associates">
                  <p style="font-size: 110%; font-family: 'Open Sans'; font-weight: bold; text-decoration: underline magenta;">&nbsp;Associates&nbsp;
                  </p>
                  <div class="bande">
                     <div class="bande_info" style="text-align: left; white-space: pre-line">
                        <?php echo($row['associates']); ?>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>

            <div class="close btn" onclick="open_notice_list();">
               Close
            </div>

         </div>

      </div>

   </div>

</body>

<script>
   var list = document.querySelector( ".left_list" );

   function open_notice_list( a ) {
      list.style.width = "100%";
      remove_bars();

   }

   function remove_bars() {

      var l_liner = document.querySelector( '.right_liner' );


      if ( l_liner != null ) {
         l_liner.parentElement.style.background = "rgba(255, 255, 255, 0.0)";
         l_liner.parentNode.removeChild( l_liner );
         var r_liner = document.querySelector( '.left_liner' );
         r_liner.parentNode.removeChild( r_liner );
      }
   }

   function open_notice( a ) {
      list.style.width = "26%";

      remove_bars();

      var left_liner = document.createElement( 'div' );
      var right_liner = document.createElement( 'div' );

      left_liner.classList.add( 'left_liner' );
      right_liner.classList.add( 'right_liner' );

      a.appendChild( left_liner );
      a.appendChild( right_liner );
      a.style.background = "rgba(100, 100, 100, 0.5)";
   }

   function swap_notices( a ) {
      if ( a.innerHTML.trim() == 'Archives' ) {
         a.innerHTML = "Current";
      } else {
         a.innerHTML = "Archives";
      }

      var notice_lists = document.getElementsByClassName( 'notice_list' );

      if ( notice_lists[ 0 ].classList.contains( 'visible_notice' ) ) {
         notice_lists[ 0 ].classList.remove( 'visible_notice' );
         notice_lists[ 1 ].classList.add( 'visible_notice' );
      } else {
         notice_lists[ 0 ].classList.add( 'visible_notice' );
         notice_lists[ 1 ].classList.remove( 'visible_notice' );
      }
   }
</script>

</html>