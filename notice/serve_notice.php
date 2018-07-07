<?php
require("../include/connection.php");
require("../include/functions.php");

if(isset($_POST['notice_id']) && $_POST['notice_id'] != null){
    $notice_id = (int) $_POST['notice_id'];
    $conn = create_connection("ces");
    $query = "SELECT * FROM notice WHERE notice_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $notice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row == null){
        echo("empty");
        die();
    }
?>

<div class="notice_heading"> <p style="font-weight: 800;">NOTICE-</p> <?php echo($row['title']); ?> </div>
        <br>
        <div class="notice_desc"><?php echo($row['content']); ?></div>
        <?php if($row['image'] != ""){ ?>
        <div class="notice_img">
          <center>
            <img src="./images/<?php echo($row['image']);?>" alt="Pen icon">
          </center>
        </div>
        <?php } ?>
        <?php if($row['video'] != ""){ ?>
        <div style="position: relative; margin: 15px 5px;">
          <center>
            <iframe  src="<?php echo($row['video']); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </center>
        </div>
        <?php } ?>
        <?php if($row['document'] != "" || $row['link']) {?>
        <div class="external_content">
          <p style="font-family: 'Open Sans'; font-weight: bold; text-decoration: underline magenta;">External Content </p>
          <?php if($row['document'] != ""){?>
          <a href="./documents/<?php echo($row['document']); ?>" target="_blank"><div class="docs btn"> Document File </div></a>
          <?php } ?>
          <?php if($row['link'] != ""){
              $parsed_link = parse_url( $row[ 'link' ] );
              $domain = $parsed_link[ 'host' ];
              ?>
          <a href="<?php echo($row['link']); ?>" target="_blank"><div class="docs btn"> <?php echo($domain); ?> </div></a>
          <?php } ?>
        </div>
        <?php } ?>
        <div class="associates">
          <p style="font-size: 110%; font-family: 'Open Sans'; font-weight: bold; text-decoration: underline magenta;">&nbsp;Associates&nbsp; </p>
          <div class="bande">
            <div class="bande_info" style="whitespace: pre-line;"> <span><?php echo($row['associates']); ?></span> <br>
            </div>
          </div>
        </div>

<?php }else{echo("empty"); } ?>