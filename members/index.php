<?php
require ("../include/connection.php");
require ("../include/functions.php");
?>

<!DOCTYPE html>
<html>

<head>
<link rel="shortcut icon" href="../images/ces_logo.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Pacifico">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Anton">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" type="text/css" href="../css/members.css">
<title>Members</title>
</head>

<body>
	<!--     HEADER CONTENT    -->

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
			<div class="menu_items">
				<a href="../">HOME</a>
			</div>
			<div class="menu_items">
				<a href="../event/">EVENTS</a>
			</div>
			<div class="menu_items">
				<a href="../notice/">NOTICE</a>
			</div>
			<div class="menu_items">
				<a href="../gallery/">GALLERY</a>
			</div>
			<div class="menu_items">
				<a href="#">MEMBERS</a>
			</div>
			<div class="menu_items">
				<a href="../subscribe/">SUBSCRIBE</a>
			</div>
		</div>
		<div class="burger_menu"
			onclick="document.querySelector('.side_menu').style.width='60%'; document.querySelector('.side_menu').style.padding='100px 5px';">
			<div class="burger">
				<div class="b-1 b"></div>
				<div class="b-2 b"></div>
				<div class="b-3 b"></div>
			</div>
		</div>
	</header>
	<div class="side_menu">
		<div class="cross"
			onclick="this.parentNode.style.padding='100px 0px'; this.parentNode.style.width='0%';">
			<div class="c-1"></div>
			<div class="c-2"></div>
		</div>
		<ul>
			<li><a href="../">HOME</a></li>
			<li><a href="../event/">EVENTS</a></li>
			<li><a href="../notice/">NOTICE</a></li>
			<li><a href="../gallery/">GALLERY</a></li>
			<li><a href="#">MEMBERS</a></li>
			<li><a href="../subscribe/">SUBSCRIBE</a></li>
		</ul>
	</div>
	<!-- HEADER  content 
	</body>
	-->

	<div class="front_photo" style="background: url('./img/members.jpg'); background-position: top; background-size: cover;"></div>
	<?php
$conn = create_connection("ces");
$query = "SELECT * FROM members WHERE year != 5 ORDER BY member_id ASC";
$result = $conn->query($query);
$count = 0;
while ($row = $result->fetch_assoc()) {
    $count = $count + 1;
    if ($count == 1) {
        echo ("	<div class=\"main\">");
    }
    ?>
		<div class="rect">
		<?php $temp_image = $row['image']; ?>
			<div class="img" style='background-image: url("./member_images/<?php echo($temp_image); ?>"), linear-gradient(to right, lightcoral, cyan);'></div>
		<br> <br> <br> <br> <br> <br> <br> ||&nbsp;&nbsp; <span
			style="font-family: Pacifico; text-transform: capitalize;"><?php echo(strtolower($row['name'])); ?></span>
		&nbsp;&nbsp;|| <br> <br> <span
			style="font-family: sans-serif; text-transform: capitalize;"><?php echo($row['designation']); ?></span>
		<div class="person-detail-icon">
			<a href="<?php echo($row['linkedin']); ?>" target="_blank">
				<div class="icon-linkdin">
					<div class="linkdin-wireframe"></div>
					<div class="liner l1"></div>
				</div>
			</a> <a href="<?php echo($row['facebook']); ?>" target="_blank">
				<div class="icon-facebook">
					<div class="fb-wireframe"></div>
					<div class="liner l2"></div>
				</div>
			</a> <a href="mailto:<?php echo($row['email']); ?>" target="_blank">
				<div class="icon-mail">
					<div class="mail-wireframe"></div>
					<div class="liner l3"></div>
				</div>
			</a>
		</div>
	</div>
			<?php
    if ($count == 4) {
        echo ("</div>");
    }
    $count = $count == 4 ? 0 : $count;
}
if ($count != 4) {
    echo ("</div>");
}
?>

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
      <div class="footer_email">cesatmmmut@gmail.com</div>
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