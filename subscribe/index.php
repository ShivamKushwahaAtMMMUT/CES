<!DOCTYPE  html>
<html>

<head>
   <title> New Subscribe</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="shortcut icon" href="../images/ces_logo.jpg" />
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
   <link rel="stylesheet" href="../css/subscribe.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">


   <style>
      a {
         text-decoration: none;
      }
      
      header {
      	 top: 0px;
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

</head>

<body>
<!-- 
</body>
 -->
   <header>
      <div class="ces_logo"><span>CES</span>
      </div>
      <div class="menu">
         <div class="menu_items"><a href="../">HOME</a>
         </div>
         <div class="menu_items"><a href="../event/">EVENTS</a>
         </div>
         <div class="menu_items"><a href="../notice/">NOTICE</a>
         </div>
         <div class="menu_items"><a href="../gallery/">GALLERY</a>
         </div>
         <div class="menu_items"><a href="../members/">MEMBERS</a>
         </div>
         <div class="menu_items"><a href="#">SUBSCRIBE</a>
         </div>
      </div>
      <div class="burger_menu" onclick="document.querySelector('.side_menu').style.width='60%'; document.querySelector('.side_menu').style.padding='100px 5px';">
         <div class="burger">
            <div class="b-1 b"></div>
            <div class="b-2 b"></div>
            <div class="b-3 b"></div>
         </div>
      </div>
   </header>
   <div class="side_menu">
      <div class="cross" onclick="this.parentNode.style.padding='100px 0px'; this.parentNode.style.width='0%';">
         <div class="c-1"></div>
         <div class="c-2"></div>
      </div>
      <ul>
         <li><a href="../">HOME</a>
         </li>
         <li><a href="../event/">EVENTS</a>
         </li>
         <li><a href="../notice/">NOTICE</a>
         </li>
         <li><a href="../gallery/">GALLERY</a>
         </li>
         <li><a href="../members/">MEMBERS</a>
         </li>
         <li><a href="#">SUBSCRIBE</a>
         </li>
      </ul>
   </div>
   <div class="form-container">
      <span class="show"> Subscribe for Notifications</span>
      <form method="post" action="./info.php">
         <div class="input_cover">
            <input class="form-control" type="text" name="name" placeholder="Name" onfocus="this.parentNode.style.border='solid 1px #5d90c9';" onfocusout="this.parentNode.style.border='solid 1px black';"/><br>
         </div>
         <div class="validation-normal">
            <input class="form-control" type="email" name="email" onfocus="this.parentNode.setAttribute('class', 'validation-normal'); document.querySelector( '.validation-image' ).style.backgroundImage = 'url()'; this.parentNode.style.border='solid 1px #5d90c9';" onfocusout="this.parentNode.style.border='solid 1px black'; checkEmail(this);" placeholder="Email" style="width: 265px; outline: none;"/>
            <div class="validation-image"></div>
         </div>
         <div class="input_cover">
            <select name="category" class="form-control" onfocus="this.parentNode.style.border='solid 1px #5d90c9';" onfocusout="this.parentNode.style.border='solid 1px black';">
               <option value="firstYear" selected> First Year</option>
               <option value="secondYear"> Second Year</option>
               <option value="thirdYear"> Third Year</option>
               <option value="finalYear"> Final Year</option>
            </select>
         </div><br>
         <input type="submit" name="subscribe" value="Subscribe" class="form-control cool-btn"/>
      </form>
   </div>
   
   <!-- Footer -->
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
<script type="text/javascript">
   function checkEmail( email ) {
      if ( email.checkValidity() == false ) {
         email.parentNode.setAttribute( "class", "validation-error" );
         email.parentNode.style.border = 'solid 1px red';
         document.querySelector( ".validation-image" ).style.backgroundImage = "url('../images/error.png')";
         return;
      }
      document.querySelector( ".validation-image" ).style.backgroundImage = "url('../images/loading.gif')";
      if ( email.value.trim() == "" ) {
         email.parentNode.setAttribute( "class", "validation-normal" );
         email.parentNode.style.border = 'solid 1px black';
         document.querySelector( ".validation-image" ).style.backgroundImage = "url('')";
         return;
      }
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
         if ( this.readyState == 4 && this.status == 200 ) {
            text = this.responseText;
            console.log( text );
            if ( text == "ok" ) {
               email.parentNode.setAttribute( "class", "validation-success" );
               email.parentNode.style.border = 'solid 1px greenyellow';
               document.querySelector( ".validation-image" ).style.backgroundImage = "url('../images/success.png')";
            } else {
               email.parentNode.setAttribute( "class", "validation-error" );
               email.parentNode.style.border = 'solid 1px red';
               document.querySelector( ".validation-image" ).style.backgroundImage = "url('../images/error.png')";
            }
         }
      };
      xhttp.open( "GET", "./info.php?subscription_check=true&email=" + email.value, true );
      xhttp.send();
   }
</script>

</html>