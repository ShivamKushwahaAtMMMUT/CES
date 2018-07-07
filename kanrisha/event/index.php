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

<!DOCTYPE html>
<html>

<head>
   <title>Event</title>

   <!--    Still to give it second thought-->
   <meta name="theme-color" content="#999999"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anton">
   <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
   <link rel="stylesheet" href="../../css/event_admin.css">
   <!-- Bootstrap core CSS -->
   <link href="../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

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
               <li class="nav-item">
                  <a class="nav-link" href="../members/">Members</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="../mail/">Mail</a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="#">Events</a>
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
   <br/> <br/>
   <div class="main"> </div>
   <div id="event-main-div">
      <div id="event-header">
         <div class="event-tab-container">
            <div id="upcoming-event-tab" class="event-header-element" onclick="myScrollTo('upcoming-events');"> <span style="display: inline-block;">Upcoming</span>
               <div class="liner"></div>
            </div>
            <?php
            $conn = create_connection( "ces" );
            $query = "SELECT * FROM event_group ORDER BY weight DESC, group_name ASC";
            $result = $conn->query( $query );
            while ( $row = $result->fetch_assoc() ) {
               ?>
            <div id="ennexes-events-tab" class="event-header-element" <?php echo( "onclick=\"myScrollTo('" . $row[ 'group_name'] . "-events');\")"); ?> >
               <span style="display: inline-block; text-transform: capitalize;">
                  <?php echo($row['group_name']); ?>
               </span>
               <div class="liner"></div>
            </div>
            <?php }$conn->close(); ?>
            <div class="event-header-element" onClick="document.getElementById('new-group-form').style.display='block'; console.log(window.pageYOffset);"><span style="display: inline-block;">+</span>
               <div class="liner"></div>
            </div>
         </div>
      </div>
      <div id="upcoming-events" class="event-display">
         <div class="event-display-heading">
            <div style="width: 96%; position: relative; right: 0px; height: 4px; background: #dbdbdb; top: 13px;"></div>
            <span class="event-type-heading"> Upcoming Events:&nbsp;&nbsp;&nbsp;</span> </div>
         <div class="event-box-container">
            <?php 
            $conn = create_connection("ces");
            $query = "SELECT * FROM event WHERE TIMESTAMPDIFF(DAY, CURRENT_TIMESTAMP, event_date) >= 0 AND display_flag = 1";
            $result = $conn->query($query);
            while($upcoming_row = $result->fetch_assoc()){
            ?>
            <div class="event-div" onmouseover="this.parentNode.style.zIndex= '3';" onmouseleave="this.parentNode.style.zIndex= '0';">
               <div class="glass"></div>
               <div class="event-div-poster" data-background="../../event/image_thumbs/<?php echo($upcoming_row['event_poster']); ?>"></div>
               <div class="event-div-title"> <span><?php echo($upcoming_row['event_category']); ?></span> <span> <?php echo($upcoming_row['event_title']); ?> </span>
               </div>
               <a href="./event_desc.php?event_id=<?php echo($upcoming_row['event_id']); ?>&event_desc=true"><div class="know-more-button">Know more</div></a>
            </div>
            <?php } ?>
         </div>
      </div>
      <?php
      $conn = create_connection( "ces" );
      $query = "SELECT * FROM event_group ORDER BY weight DESC, group_name ASC";
      $group_result = $conn->query( $query );
      while ( $group_row = $group_result->fetch_assoc() ) {
         ?>
      <div <?php echo( "id='" . $group_row[ 'group_name'] . "-events'"); ?> class="event-display">
         <div class="event-display-heading">
            <div style="width: 96%;; position: relative; right: 0px; height: 4px; background: #dbdbdb; top: 13px;"></div>
            <span class="event-type-heading">
               <?php echo($group_row['group_name']); ?> Events:&nbsp;&nbsp;&nbsp;</span>
         </div>
         <div class="event-box-container">
            <?php 
            $query = "SELECT * FROM event WHERE event_group = '{$group_row['group_name']}' AND display_flag = 1 ORDER BY event_title ASC";
            $event_result = $conn->query($query);
            while($event_row = $event_result->fetch_assoc()){
            ?>
            <div class="event-div" onmouseover="this.parentNode.style.zIndex= '3';" onmouseleave="this.parentNode.style.zIndex= '0';">
               <div class="glass"></div>
               <div class="event-div-poster" data-background="../../event/image_thumbs/<?php echo($event_row['event_poster']); ?>"></div>
               <div class="event-div-title"><span><?php echo($event_row['event_category']); ?></span><span><?php echo($event_row['event_title']); ?></span>
               </div>
               <a href="./event_desc.php?event_id=<?php echo($event_row['event_id']); ?>&event_desc=true"><div class="know-more-button">Know more</div></a>
               <br/>
               <div style="text-align: center;">
                  ||<a href="./create_event.php?event_id=<?php echo($event_row['event_id']); ?>& event_group=<?php echo($group_row['group_name']); ?>&edit_event=true">Edit</a>||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;||<a href="./event_handler.php?event_id=<?php echo($event_row['event_id']); ?>&delete_event=true" class="text-danger" >Remove</a>||
               </div>
            </div>
            <?php } ?>
            <a href="create_event.php?event_group=<?php echo($group_row['group_name']); ?>&create_event=true">
               <div class="event-div" onmouseover="this.parentNode.style.zIndex= '3';" onmouseleave="this.parentNode.style.zIndex= '0';" style="background: #E0E0E0; display: flex;">
                  <img src="./icons/plus.png" alt="Add new" style="margin: auto;">
               </div>
            </a>
         </div>
      </div>
      <?php 
      }
      $conn->close();
      ?>
   </div>
   <div id="new-group-form">
      <form class="form-inline" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" action="event_handler.php" method="post">
         <input type="text" class="form-control" placeholder="Group Name" name="group_name"><br>
         <input type="submit" class="btn btn-primary" name="create_event_group" value="Create Group">
      </form>
      <div id="new-group-form-closing" onClick="document.getElementById('new-group-form').style.display='none'">
         <div class="myburger" style="transform: rotateZ(50deg);"></div>
         <div class="myburger" style="transform: rotateZ(-50deg);"></div>
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
<script>
   var event_poster = document.getElementsByClassName( "event-div-poster" );
   for ( var i = 0; i < event_poster.length; i++ ) {
      event_poster[ i ].style.backgroundImage = "url(" + event_poster[ i ].dataset.background + ")";
   }

   var scrollY = 0;
   var speed = 2;

   function myScrollTo( element ) {
      //console.log(element);
      var t = document.getElementById( element ).getBoundingClientRect().top;
      var currentScroll = window.pageYOffset;
      var finalScroll = currentScroll + t - 165;
      if ( currentScroll <= t ) {
         myScroll( finalScroll, ( t - 100 ) / 150, 0 );
      } else {
         myScrollUp( finalScroll, ( t - 100 ) / 150, 0 );
      }
   }

   function myScroll( finalScroll, distance, count ) {
      count += 1
      var currentY = window.pageYOffset;
      var targetY = finalScroll;
      var bodyHeight = document.body.offsetHeight;
      var yPos = currentY + window.innerHeight;
      var animator = setTimeout( 'myScroll(' + finalScroll + ',' + distance + ',' + count + ')', speed );
      if ( currentY >= targetY || count > 350 ) {
         clearTimeout( animator );
         console.log( "Clear time 1" );
      } else {
         if ( currentY < targetY - distance ) {
            scrollY = currentY + distance;
            window.scrollTo( 0, scrollY );
         } else {
            clearTimeout( animator );
            console.log( "C= " + currentY + " t= " + targetY + " d= " + distance );
            console.log( "Clear timeout 2" );
         }
      }
   }

   function myScrollUp( finalScroll, distance, count ) {
      count += 1
      var currentY = window.pageYOffset;
      var targetY = finalScroll;
      var bodyHeight = document.body.offsetHeight;
      var yPos = currentY + window.innerHeight;
      var animator = setTimeout( 'myScrollUp(' + finalScroll + ',' + distance + ',' + count + ')', speed );
      //console.log(targetY + " " + currentY);
      if ( currentY <= targetY || count > 350 ) {
         clearTimeout( animator );
         console.log( "Clear time 1" );
      } else {
         if ( currentY > targetY - distance ) {
            scrollY = currentY + distance;
            window.scrollTo( 0, scrollY );
         } else {
            clearTimeout( animator );
            console.log( "C= " + currentY + " t= " + targetY + " d= " + distance );
            console.log( "Clear timeout 2" );
         }
      }
   }
</script>

</html>