<?php 
require("../include/connection.php");
require("../include/functions.php");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Pacifico">
    <title>Perspective</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: linear-gradient(50deg, lightblue 50%, #06BCFF 100%);
            background-size: 700% 200%;
            animation: 7s grad infinite alternate ease-in-out;
        }

        .main {
            perspective: 100px;
            width: 80%;
            height: 600px;
            margin: auto;
        }

        .rect {
            float: left;
            position: relative;
            font-stretch: 300px;
            padding: 10px;
            text-align: center;
            height: 280px;
            width: 180px;
            margin: 150px 3%;
            background: white;
            animation-duration: 1s;
            border-radius: 10px;
        }

        @keyframes grad {
            0% {
                background-position: 0, 50%;
            }
            100% {
                background-position: 100%, 50%;
            }
        }

        .rect:hover {

            animation: 0.7s from_top 1 alternate ease-out forwards;
        }

        .rect:mouseout {
            background: red;
        }

        @keyframes from_top {
            0% {
                transform-origin: 50% 0%;
                transform: rotateX(0deg) scale(1, 1);
                box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.2);
            }
            45% {
                transform: rotateX(-4deg) scale(1.15, 1.15);
            }
            100% {
                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.4);
                transform: scale(1.2, 1.2);
            }
        }

        .img {
            position: absolute;
            text-align: center;
            color: #fff;
            font-size: 130px;
            background: white;
            background-image: linear-gradient(to right, lightcoral, cyan);
            border-radius: 100%;
            box-shadow: 0px 0px 0px 6px white;
            top: 0%;
            left: 50%;
            transform: translate(-50%, -30%);
            width: 160px;
            height: 160px;

        }

        /*			Social icons style	
*/

        .person-detail-icon {
            position: relative;
            width: 80%;
            margin-left: 9%;
            height: 35px;
            margin-top: 7.5px;
        }

        .person-detail-icon * {

            transition-duration: 1.5s;
            transform: rotate(0deg);
        }

        .icon-linkdin {
            cursor: pointer;
            border-radius: 120%;
            width: 35px;
            height: 100%;
            margin-left: 10%;
            position: absolute;
            background-position: center;
            background-size: contain;
            border: solid 3px white;
        }

        .liner {
            position: absolute;
            bottom: 0px;
            margin-top: 10px;
            height: 2px;
            background: lightcoral;
            transition-duration: 0.4s;
            width: 0px;
        }

        .l1 {
            left: 0px;
        }

        .l2 {
            left: 50%;
            transform: translate(-50%, 0);
        }

        .l3 {
            right: 0px;
        }

        .icon-linkdin:hover .liner,
        .icon-facebook:hover .liner,
        .icon-mail:hover .liner {
            width: 100%;
        }

        .icon-facebook {
            cursor: pointer;
            border-radius: 100%;
            width: 35px;
            height: 100%;
            margin-left: 40%;
            position: absolute;
            background-position: center;
            background-size: contain;
            border: solid 3px white;
        }

        .icon-mail {
            cursor: pointer;
            border-radius: 100%;
            width: 35px;
            height: 100%;
            margin-left: 70%;
            position: absolute;
            background-position: center;
            background-size: contain;
            border: solid 3px white;
        }

        .linkdin-wireframe {
            width: 100%;
            height: 85%;
            position: absolute;
            left: 50%;
            transform: translate(-50%, 0);
            background: url("./img/linkdin_wireframe.png") no-repeat;
            background-position: center;
            background-size: contain;
        }

        .fb-wireframe {
            width: 100%;
            height: 85%;
            position: absolute;
            left: 50%;
            transform: translate(-50%, 0);
            background: url("./img/fb_wireframe.png") no-repeat;
            background-size: contain;
            background-position: center;
        }

        .mail-wireframe {
            width: 100%;
            height: 85%;
            position: absolute;
            left: 50%;
            transform: translate(-50%, 0);
            background: url("./img/mail_wireframe.png") no-repeat;
            background-size: contain;
            background-position: center;
        }

    </style>


</head>

<body>

    <div class="main">
       
       <?php 
       $conn = create_connection("ces");
       $query = "SELECT * FROM (SELECT *, 1 AS count FROM members WHERE year = 0) AS a UNION SELECT * FROM (SELECT *, 2 AS count FROM members WHERE year != 0) AS b ORDER BY count ASC, year DESC, name ASC";
       $result = $conn->query($query);
       while($row = $result->fetch_assoc())
       {
       ?>
        <div class="rect">
           <?php $temp_image = $row['image']; ?>
            <div class="img" style='background-image: url("../admin/members/member_images/<?php echo($temp_image); ?>"), linear-gradient(to right, lightcoral, cyan);'>
            </div>
            <br><br><br><br><br><br><br> ||&nbsp;&nbsp;
            <span style="font-family: Pacifico; text-transform: capitalize;"><?php echo(strtolower($row['name'])); ?></span> &nbsp;&nbsp;||
            <br>
            <br>
            <span style="font-family: sans-serif; text-transform: capitalize;"><?php echo($row['designation']); ?></span>
            <div class="person-detail-icon">
               <a href="<?php echo($row['linkedin']); ?>" target="_blank">
                <div class="icon-linkdin">
                    <div class="linkdin-wireframe"></div>
                    <div class="liner l1"></div>
                </div>
               </a>
               <a href="<?php echo($row['facebook']); ?>" target="_blank">
                <div class="icon-facebook">
                    <div class="fb-wireframe"></div>
                    <div class="liner l2"></div>
                </div>
               </a>
               <a href="<?php echo($row['email']); ?>" target="_blank">
                <div class="icon-mail">
                    <div class="mail-wireframe"></div>
                    <div class="liner l3"></div>
                </div>
               </a>
            </div>
        </div>
        <?php } ?>
    </div>



    <script type="text/javascript">
        /* Social icon functions  */
        function rotate(d) {
            var par = d.parentNode;
            var c1 = par.childNodes[1];
            var c2 = par.childNodes[3];
            c1.style.transform = "rotate(360deg)";
            c1.style.opacity = 0;
            c2.style.transform = 'rotate(0deg)';
            c2.style.opacity = 1;
        }

        function rotateBack(d) {
            var par = d.parentNode;
            var c1 = par.childNodes[1];
            var c2 = par.childNodes[3];
            c1.style.transform = "rotate(0deg)";
            c1.style.opacity = 1;
            c2.style.transform = 'rotate(360deg)';
            c2.style.opacity = 0;
        }

    </script>

</body>

</html>
