<?php
session_start();
require ("../include/connection.php");
require ("../include/functions.php");

if (isset($_GET['event_desc']) && $_GET['event_desc'] == "true") {
    $event_id = (int) $_GET['event_id'];
    $conn = create_connection("ces");
    $query = "SELECT * FROM event WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="../images/ces_logo.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Anton">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Pacifico">
<link rel="stylesheet" href="../css/event_desc.css">
<meta charset="UTF-8">
<title><?php echo($row['event_title']); ?></title>
</head>

<body>

	<!--      HEadEr ContEnt      -->

	<style>
header {
	position: absolute;
	width: 100vw;
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
	border-color: white;
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

		<div class="ces_logo">
			<span>CES</span>
		</div>
		<div class="menu">
			<div class="menu_items"><a href="../">HOME</a></div>
		<div class="menu_items"><a href="./">EVENTS</a></div>
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

	<!-- HEAder COntent -->

	<div class="container">
		<div class="front">
			<div class="main_img" style="background-image: url(./images/<?php echo($row['event_poster']); ?>);"></div>
			<div class="welcome">
				<span
					style="font-size: 35px; display: inline-block; margin-top: 5px; letter-spacing: 5px;"><?php echo($row['event_title']); ?></span>
				<br> <span
					style="display: inline-block; color: #262F39; font-size: 18px; font-weight: 600;"><?php echo($row['event_category']); ?></span>
			</div>
		</div>

		<span
			style="display: inline-block; height: 30px; width: 100%; text-align: center; font-size: 27px; padding-bottom: 24px; color: #2D575F;">Event
			Description</span>
		<div class="event_desc">
			<div class="desc" id="desc" style="white-space: pre-line;">
				<p><?php echo($row['event_desc']); ?></p>
			</div>
		</div>
		<div class="rules">
			<h1>Rules to follow  &raquo;</h1>
			<?php echo($row['event_rules']); ?>
		</div>
		<div class="associates ">
			<p
				style="font-size: 110%; font-family: 'Open Sans'; font-weight: bold; text-decoration: underline magenta;">&nbsp;Associates&nbsp;
			</p>
			<div class="bande">
				<div class="bande_info " style="white-space: pre-line;">
					<span><?php echo($row['event_coordinators']); ?></span>
				</div>
			</div>
		</div>
	</div>

	<footer>
  <div class="footer_mmmut">
    <div class="footer_mmmut_img"></div>
    <div class="footer_contacts">
      <div class="footer_name">MADAN MOHAN MALAVIYA UNIVERSITY OF TECHNOLOGY<br>
        GORAKHPUR</div>
      <div class="footer_email">patovc@mmmut.ac.in</div>
      <div class="footer_phone">+91-551-2273958, +91-8765783730</div>
    </div>
  </div>
  <div class="footer_mmmut">
    <div class="footer_ces_img"></div>
    <div class="footer_contacts">
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

</body>

</html>
<?php }else{redirect("./");} ?>
