<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="./images/ces_logo.jpg" />
<link rel="stylesheet" href="./css/home.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anton">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CES</title>
</head>


<style>
			
	header {
	    top: 0px;
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
<body>

<!--  ///////////////////////////           HEaDer        ///////////////////// --> 
<!-- 
</body>
-->

<header>
  <div class="ces_logo"><span>CES</span></div>
  <div class="menu">
    <div class="menu_items"><a href="#">HOME</a></div>
    <div class="menu_items"><a href="./event/">EVENTS</a></div>
    <div class="menu_items"><a href="./notice/">NOTICE</a></div>
    <div class="menu_items"><a href="./gallery/">GALLERY</a></div>
    <div class="menu_items"><a href="./members/">MEMBERS</a></div>
    <div class="menu_items"><a href="./subscribe/">SUBSCRIBE</a></div>
  </div>
  <div class="burger_menu" onclick="document.querySelector('.side_menu').style.width='60%'; document.querySelector('.side_menu').style.padding='100px 5px'; " >
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
    <li><a href="#">HOME</a></li>
    <li><a href="./event/">EVENTS</a></li>
    <li><a href="./notice/">NOTICE</a></li>
    <li><a href="./gallery/">GALLERY</a></li>
    <li><a href="/members/">MEMBERS</a></li>
    <li><a href="./subscribe/">SUBSCRIBE</a></li>
  </ul>
</div>
<div class="main">
  <div class="cse">
    <div class="cse_decl">
      <div class="cse_anim delay_1">Computer</div>
      <div class="cse_anim delay_2">Engineering</div>
      <div class="cse_anim delay_3">Society</div>
      <span style="font-size: 16px; color: #202B36;">Madan Mohan Malaviya University of Technology</span> </div>
    <div class="mmmut"> <a href="http://mmmut.ac.in" target="_blank">MMMUT</a> </div>
  </div>
</div>

<!--	<div class="content"> </div>-->
<div class="about_society">
  <div class="declaring_society"> CES @ glance... </div>
  <div class="about_society_content">
    <p>The Computer Engineering Society has been functioning since 1993 with the collective effort of a group of B.Tech and MCA students who had a strong urge to complement the theoretical and practical knowledge imparted in the classroom and laboratory, with emphasis on development of overall personality of budding engineering graduates.</p>
    <p> With a humble beginning, the society has grown steadily to it present strength of more than 300 student as well as teacher members and is one of the most active and popular technical societies in the campus. The society can proudly boast of having committed members."</p>
    <p>"It provides a platform to the students to share and increase their 'engineering' know-how through increased interaction between students at all levels, group activity, brainstorming to name a few.</p>
  </div>
</div>
<div class="society_officials">
  <div class="declaring_heading">Faculty Mentors</div>
  <div class="mentors">
    <div class="mentor_container">
      <div class="mentor_img">
        <div class="img"><img alt="Prof. Rakesh Kumar" src="../images/Prof Rakesh Kumar.jpg"> </div>
      </div>
      <div class="mentor_name"> Prof. Rakesh Kumar<br>
        <span>PRESIDENT</span><br>
        <br>
        <span style="color:#121213; font-size: 15px; font-weight: 100; font-style: italic; ">"Professor and Head"</span> </div>
    </div>
    <div class="mentor_container">
      <div class="mentor_img">
        <div class="img"><img alt="Dr. AK Daniel" src="../images/AK1.jpg"> </div>
      </div>
      <div class="mentor_name"> Dr. A. K. Daniel<br>
        <span>VICE PRESIDENT</span><br>
        <br>
        <span style="color:#121213; font-size: 15px; font-weight: 100; font-style: italic; ">"Associate Professor"</span> </div>
    </div>
    <div class="mentor_container">
      <div class="mentor_img">
        <div class="img"><img alt="Prof. NP Singh" src="../images/NPS1.jpg"> </div>
      </div>
      <div class="mentor_name">Prof. Nagedra Pratap Singh<br>
        <span>SECRETARY</span><br>
        <br>
        <span style="color:#121213; font-size: 15px; font-weight: 100; font-style: italic; ">"Assistant Professor"</span> </div>
    </div>
    <div class="mentor_container">
      <div class="mentor_img">
        <div class="img"><img alt="Sri MK Srivastava" src="../images/Bhagwan.jpg"> </div>
      </div>
      <div class="mentor_name"> Sri M. K. Srivastava<br>
        <span>TREASURER</span><br>
        <br>
        <span style="color:#121213; font-size: 15px; font-weight: 100; font-style: italic; ">"Assistant Professor"</span> </div>
    </div>
  </div>
</div>
<div class="contact_us_form"> <span> Contact Us </span>
  <div style="display: flex; justify-content: space-around; flex-wrap: wrap;">
    <div class="form">
      <form id="contact_us_form" action="./contact_us.php" method="post">
        <input type="text" placeholder="Name" name="name" required />
        <br>
        <input type="email" placeholder="em@il" name="email" required />
        <br>
        <textarea form="contact_us_form" name="query" id="" cols="30" rows="10" placeholder="Your questions/Suggestions" required></textarea>
        <br>
        <input type="submit" name="submit" value="Submit" />
      </form>
    </div>
	  
    <div class="map">
		<div class="wrapper"><div class="container"><iframe id="gmap_canvas" src="https://maps.google.com/maps?q=Madan Mohan Malaviya University of Technology&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>
	</div>
	</div>
  </div>
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