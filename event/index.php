<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );
?>

<!DOCTYPE html>
<html>
<head>
<title>CES events</title>

<!--    Still to give it second thought-->
<link rel="shortcut icon" href="../images/ces_logo.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anton">
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="../css/event.css">
</head>

<body>

<!--  HEADER CONTENT -->

	
	<style>
	header {
	position: absolute;
	width:100vw;
	z-index: 3;
	display: flex;
	justify-content: space-between;
/*	background: transparent;*/
	flex-wrap: wrap;
	padding: 8px 20px;
	box-sizing: border-box;
}

.menu_items a {
	font-family: Open Sans;
	text-decoration: none;
	color: azure;
	display: inline-block;
	padding: 5px;
	background: rgba(250, 250, 250, 0.1);
	letter-spacing: 2px;
	border: solid 1px transparent;
}
		.menu_items a:hover {
			border-color:white;
		}
.ces_logo img {
	height: 50px;
	
}

.menu {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	min-width: 331px;
}

.menu_items {
	padding: 5px 20px;
	margin: auto;
}

.ces_logo span {
	font-size: 150%;
	display: block;
	font-family: Pacifico;
	color: #fff;
}
.ces_logo span::first-letter {
	font-size: 200%;
}
	</style>
	<header>
	
		<div class="ces_logo"><span>CES</span></div>
		<div class="menu">
		<div class="menu_items"><a href="../">HOME</a></div>
		<div class="menu_items"><a href="#">EVENTS</a></div>
		<div class="menu_items"><a href="../notice/">NOTICE</a></div>
		<div class="menu_items"><a href="../gallery/">GALLERY</a></div>
		<div class="menu_items"><a href="../members/">MEMBERS</a></div>
		<div class="menu_items"><a href="../subscribe/">SUBSCRIBE</a></div>
		</div>
	<div class="burger_menu"
      onclick="document.querySelector('.side_menu').style.width='60%'; document.querySelector('.side_menu').style.padding='100px 5px'; ">
      <div class="burger">
        <div class="b-1 b"></div>
        <div class="b-2 b"></div>
        <div class="b-3 b"></div>
      </div>
    </div>
  </header>

  <div class="side_menu">
    <div class="cross"
      onclick="this.parentNode.style.padding='100px 0px';this.parentNode.style.width='0%' ;">
      <div class="c-1"></div>
      <div class="c-2"></div>
    </div>
    <ul>
      <li><a href="../">HOME</a></li>
            <li><a href="./">EVENTS</a></li>
            <li><a href="../notice/">NOTICE</a></li>
            <li><a href="../gallery/">GALLERY</a></li>
            <li><a href="../members/">MEMBERS</a></li>
            <li><a href="../subscribe/">SUBSCRIBE</a></li>
    </ul>
  </div>

<!--  HEADER CONTENT -->

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
      <div id="ennexes-events-tab" class="event-header-element" <?php echo( "onclick=\"myScrollTo('" . $row[ 'group_name'] . "-events');\")"); ?>> <span style="display: inline-block; text-transform: capitalize;"><?php echo($row['group_name']); ?></span>
        <div class="liner"></div>
      </div>
      <?php }$conn->close(); ?>
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
        <div class="event-div-poster" style=" background: url('./image_thumbs/<?php echo($upcoming_row['event_poster']); ?>') no-repeat; background-size: cover;"></div>
        <div class="event-div-title"> <span><?php echo($upcoming_row['event_category']); ?></span> <span> <?php echo($upcoming_row['event_title']); ?> </span></div>
        <a href="./event_desc.php?event_id=<?php echo($upcoming_row['event_id']); ?>&event_desc=true"><div class="know-more-button"><span>Know more</span></div></a>
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
      <div style="width: 96%; position: relative; right: 0px; height: 4px; background: #dbdb; top: 13px;"></div>
      <span class="event-type-heading"> <?php echo($group_row['group_name']); ?> Events:&nbsp;&nbsp;&nbsp;</span> </div>
    <div class="event-box-container">
    <?php 
            $query = "SELECT * FROM event WHERE event_group = '{$group_row['group_name']}' AND display_flag = 1 ORDER BY event_title ASC";
            $event_result = $conn->query($query);
            while($event_row = $event_result->fetch_assoc()){
            ?>
      <div class="event-div" onmouseover="this.parentNode.style.zIndex= '3';" onmouseleave="this.parentNode.style.zIndex= '0';">
        <div class="event-div-poster" style=" background: url('./image_thumbs/<?php echo($event_row['event_poster']); ?>') no-repeat; background-size: cover;"></div>
        <div class="event-div-title"><span><?php echo($event_row['event_category']); ?></span><span> <?php echo($event_row['event_title']); ?> </span></div>
        <a href="./event_desc.php?event_id=<?php echo($event_row['event_id']); ?>&event_desc=true"><div class="know-more-button"><span>Know more</span></div></a>
      </div>
      <?php } ?>
    </div>
  </div>
   <?php 
      }
      $conn->close();
      ?>
</div>

<!-- FOOTER -->

<footer>
  <div class="footer_mmmut">
    <div class="footer_mmmut_img"></div>
    <div class="contacts">
      <div class="footer_name">MADAN MOHAN MALAVIYA UNIVERSITY OF TECHNOLOGY<br>
        GORAKHPUR</div>
      <div class="footer_email">patovc@mmmut.ac.in</div>
      <div class="footer_phone">+91-551-2273958, +91-8765783730</div>
    </div>
  </div>
  <div class="footer_mmmut">
    <div class="footer_ces_img"></div>
    <div class="contacts">
      <div class="footer_name">COMPUTER ENGINEERING SOCIETY </div>
      <div class="footer_email">cesmmmut@gmail.com</div>
      <div class="footer_phone">+917393905674</div>
    </div>
  </div>
  <div class="socials">
   <div class="social_icons">
		<div class="fb" style="cursor: pointer;" onClick="window.open('https://www.facebook.com/ces.mmmut/', '_blank')"></div>
      <div class="in" style="cursor: pointer;" onClick="window.open('https://www.linkedin.com/school/15142666/', '_blank')"></div>
      <div class="twitter" style="cursor: pointer;" onClick="window.open('#', '_blank')"></div>
    </div>
  </div>
	<div class="developers" style="font-family: Open Sans; font-size: 13px;">Designed by <a href="http://www.facebook.com/ProminentDevelopers/" style="color: aquamarine;" target="_blank">Prominent Developers</a></div>
</footer>

<!-- FOOTER -->

</body>
<script>
   var scrollY = 0;
    var speed = 2;
    var animator = 0;
    function myScrollTo(element) {
        var t = document.getElementById(element).getBoundingClientRect().top;
        var currentScroll = window.pageYOffset;
        var finalScroll = currentScroll + t - 80;
        if (t > 80 ) {
            //console.log("t > 80 " +t+" > 80");
            myScroll(finalScroll, (t - 80) / 150, 0);
        } else {
            //console.log("u t > 80 " +t+" > 80");
            myScrollUp(finalScroll, (t - 80) / 150, 0);
        }
    }

    function myScroll(finalScroll, distance, count) {
        count += 1
        var currentY = window.pageYOffset;
        var targetY = finalScroll;
        var bodyHeight = document.body.offsetHeight;
        var yPos = currentY + window.innerHeight;
        animator = setTimeout('myScroll(' + finalScroll + ',' + distance + ',' + count + ')', speed);
        if (currentY >= targetY || count > 750) {
            clearTimeout(animator);
            animator = 0;
        } else {
            if (currentY < targetY - distance) {
                scrollY = currentY + distance;
                window.scrollTo(0, scrollY);
            } else {
                clearTimeout(animator);
                animator = 0;
            }
        }
    }

    function myScrollUp(finalScroll, distance, count) {
        count += 1;
        var currentY = window.pageYOffset;
        var targetY = finalScroll;
        var bodyHeight = document.body.offsetHeight;
        var yPos = currentY + window.innerHeight;
        var animator = setTimeout('myScrollUp(' + finalScroll + ',' + distance + ',' + count + ')', speed);
        if (currentY <= targetY || count > 750) {
            clearTimeout(animator);
            animator = 0;
        } else {
            if (currentY > targetY - distance) {
                scrollY = currentY + distance;
                window.scrollTo(0, scrollY);
            } else {
                clearTimeout(animator);
                animator = 0;
            }
        }
    }
    
</script>

</html>
