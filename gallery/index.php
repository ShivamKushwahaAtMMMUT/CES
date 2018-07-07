<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="../images/ces_logo.jpg" />
	<link rel="stylesheet" href="../css/gallery.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="./images/ces_logo.jpg">
<title>Gallery</title>

<style>
		
header {
	position: absolute;
	width:100vw;
	z-index: 3;
	display: flex;
	justify-content: space-between;
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
</head>
<body>
	<!--  
		HEADer ConTent
</body>
-->
	
	<header>
  <div class="ces_logo"><span>CES</span></div>
  <div class="menu">
    <div class="menu_items"><a href="../">HOME</a></div>
    <div class="menu_items"><a href="../event/">EVENTS</a></div>
    <div class="menu_items"><a href="../notice/">NOTICE</a></div>
    <div class="menu_items"><a href="#">GALLERY</a></div>
    <div class="menu_items"><a href="../members/">MEMBERS</a></div>
    <div class="menu_items"><a href="../subscribe/">SUBSCRIBE</a></div>
  </div>
  <div class="burger_menu" onclick="document.querySelector('.side_menu').style.width='60%'; document.querySelector('.side_menu').style.padding='100px 5px';" >
    <div class="burger">
      <div class="b-1 b"></div>
      <div class="b-2 b"></div>
      <div class="b-3 b"></div>
    </div>
  </div>
</header>
<div class="side_menu">
  <div class="cross" onclick="this.parentNode.style.padding='100px 0px';this.parentNode.style.width='0%' ;">
    <div class="c-1"></div>
    <div class="c-2"></div>
  </div>
  <ul>
    <li><a href="../home/">HOME</a></li>
    <li><a href="../event/">EVENTS</a></li>
    <li><a href="../notice/">NOTICE</a></li>
    <li><a href="#">GALLERY</a></li>
    <li><a href="../members/">MEMBERS</a></li>
    <li><a href="../subscribe/">SUBSCRIBE</a></li>
  </ul>
</div>
	
	
	<div class="photo">
		
	</div>
	
	<div class="gallery">
		<div><img src="./Ennexus 2017/1.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/2.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/3.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/4.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/5.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/6.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/7.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/8.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/10.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/12.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/13.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/14.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/15.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/16.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/17.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/20.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/21.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/22.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/23.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/24.jpg" alt="images"></div>
		<div><img src="./Ennexus 2017/26.jpg" alt="images"></div>
	</div>
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
