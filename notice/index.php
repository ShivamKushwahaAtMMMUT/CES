<?php 
require("../include/connection.php");
require("../include/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="../images/ces_logo.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/notice.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Anton">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
<title>Notice</title>
</head>

<body>

<!-- HEADER content
</body>
  -->

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
@keyframes loading{
    0%{
        transform: translate(-50%, -50%) rotateZ(0deg);
    }
    50%{
        transform: translate(-50%, -50%) rotateZ(180deg);
    }
    100%{
        transform: translate(-50%, -50%) rotateZ(360deg);
    }
}
	</style>

<!-- HEADer Content -->

<div class="content">
  <div class="left_list">
	  <header>
	
		<div class="ces_logo"><span>CES</span></div>
		<div class="menu">
			<div class="menu_items"><a href="../">HOME</a></div>
		<div class="menu_items"><a href="../event/">EVENTS</a></div>
		<div class="menu_items"><a href="#">NOTICE</a></div>
		<div class="menu_items"><a href="../gallery/">GALLERY</a></div>
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
	<div class="cross" onclick="this.parentNode.style.padding='100px 0px'; this.parentNode.style.width='0%';">
		<div class="c-1"></div>
		<div class="c-2"></div>
	</div>
  <ul>
    <li><a href="../">HOME</a></li>
    <li><a href="../event/">EVENTS</a></li>
    <li><a href="#">NOTICE</a></li>
    <li><a href="../gallery/">GALLERY</a></li>
    <li><a href="../members/">MEMBERS</a></li>
    <li><a href="../subscribe/">SUBSCRIBE</a></li>
  </ul>
</div>
    <div class="notice_list visible_notice">	  
	  <?php 
	  $conn = create_connection("ces");
	  $query = "SELECT * FROM notice WHERE TIMESTAMPDIFF(DAY, CURRENT_TIMESTAMP, validity) >= 0 ORDER BY issue_date DESC";
	  $result = $conn->query($query);
	  while($active_row = $result->fetch_assoc()){
	  ?>
      <div class="notice_head" onclick="open_notice(this); display_notice(this);" data-notice="<?php echo($active_row['notice_id']); ?>"> <span><?php echo($active_row['title']); ?></span>
        <div class="issued"> <span>Issue date: <?php echo(date('M d, Y', strtotime($active_row['issue_date']))); ?></span> </div>
        <div class="liner"></div>
      </div>
      <hr>
      <?php } ?>
    </div>
    
    <!--
            /////////////////////////////////////////////////////////
            //
            //
            //////   This is Archive notice content division   //////
            //
            //
            /////////////////////////////////////////////////////////
            -->
    <div class="notice_list ">
    <?php 
           $conn = create_connection("ces");
           $query = "SELECT * FROM notice WHERE TIMESTAMPDIFF(DAY, CURRENT_TIMESTAMP, validity) < 0 ORDER BY issue_date DESC LIMIT 10";
           $result = $conn->query($query);
           while($archieved_row = $result->fetch_assoc()){
         ?>
      <div class="notice_head" onclick="open_notice(this); display_notice(this);" data-notice="<?php echo($archieved_row['notice_id']); ?>"> <span><?php echo($archieved_row['title'])?></span>
        <div class="issued"> <span>Issue date: <?php echo(date('M d, Y', strtotime($archieved_row['issue_date']))); ?></span> </div>
        <div class="liner"></div>
      </div>
      <hr>
      <?php } ?>
    </div>
    <div class="archive_btn" onclick="swap_notices(this);"> Archived </div>
  </div>
  
  <!--
           Right Side notice board content
       -->
  <div class="board">
    <div class="notice_content">
    	<div id="loading" style="height: 100%; background: white; z-index: 14;">
            <div id="loader" style="height: 100px; width: 100px; border-radius: 100px; border:solid 10px white; border-left-color: rgba(0,0,0,0); border-right-color: rgba(0,0,0,0); border-bottom-left-radius: 100px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); animation: loading 1.5s infinite ease-in-out; z-index: 2"></div>
            <div style="height: 118px; width: 118px; background: linear-gradient(#0d47a1 , #64dd17); position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); border-radius: 100px;"></div>
            <div style="height: 101px; width: 101px; position: absolute; top: 50%; left:50%; transform: translate(-50%, -50%); background: white; border-radius: 90px;"></div>
        </div>
      <div class="noti">
        <!-- You Go Here.... -->
      </div>
      <div class="close btn" onclick="open_notice_list();"> Close </div>
    </div>
  </div>
</div>
</body>
<script>
    var list = document.querySelector(".left_list");

    function open_notice_list(a) {
		list.style.transform = "translate(0%, 0%)";
        list.style.width = "100%";
        remove_bars();

    }

    function remove_bars() {

        var l_liner = document.querySelector('.right_liner');

        if (l_liner != null) {
            l_liner.parentElement.style.background = "rgba(255, 255, 255, 0.0)";
            l_liner.parentNode.removeChild(l_liner);
            var r_liner = document.querySelector('.left_liner');
            r_liner.parentNode.removeChild(r_liner);
        }
    }

    function open_notice(a) {
        list.style.width = "26%";
		if(parseInt(window.innerWidth) < 1001){
			list.style.transform = "translate(-100%, 0)";
		};
        remove_bars();

        var left_liner = document.createElement('div');
        var right_liner = document.createElement('div');

        left_liner.classList.add('left_liner');
        right_liner.classList.add('right_liner');

        a.appendChild(left_liner);
        a.appendChild(right_liner);
        a.style.background = "rgba(100, 100, 100, 0.5)";
    }

    function swap_notices(a) {
        if (a.innerHTML.trim() == 'Archives') {
            a.innerHTML = "Current";
        } else {
            a.innerHTML = "Archives";
        }

        var notice_lists = document.getElementsByClassName('notice_list');

        if (notice_lists[0].classList.contains('visible_notice')) {
            notice_lists[0].classList.remove('visible_notice');
            notice_lists[1].classList.add('visible_notice');
        } else {
            notice_lists[0].classList.add('visible_notice');
            notice_lists[1].classList.remove('visible_notice');
        }
    }

    // ajax for receiving pages
    function display_notice(notice){
        var notice_id = notice.dataset.notice;
        console.log(notice_id);
        document.getElementById("loading").style.display="block";
        document.querySelector(".noti").innerHTML = "";
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
           if ( this.readyState == 4 && this.status == 200 ) {
        	   document.getElementById("loading").style.display="none";
              text = this.responseText;
              console.log( text );
              if ( text != "empty" ) {
                 document.querySelector(".noti").innerHTML = text;
              } else {
                 open_notice_list();
                 alert("No record found for requested notice.");
              }
           }
        };
        xhttp.open("POST", "serve_notice.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("notice_id="+notice_id);
    }

</script>

</html>
