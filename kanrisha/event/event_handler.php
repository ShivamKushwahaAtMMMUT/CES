<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );

if ( !isset( $_SESSION[ 'admin' ] ) ) {
   redirect( "../index.php" );
}

//Handle New event creation request
if ( isset( $_POST[ 'create_event' ] ) ) {
   $event_group = trim( $_POST[ 'event_group' ] );
   $event_title = htmlspecialchars( trim( $_POST[ 'event_title' ] ) );
   $event_category = htmlspecialchars( trim( $_POST[ 'event_category' ] ) );
   $event_date = $_POST[ 'event_date' ] != null ? date( 'Y-m-d', strtotime( $_POST[ 'event_date' ] ) ) : "";
   $event_desc = htmlspecialchars( trim( $_POST[ 'event_desc' ] ) );
   $event_rules = $_POST[ 'event_rules' ];
   $event_coord = isset( $_POST[ 'event_coord' ] ) ? htmlspecialchars( $_POST[ 'event_coord' ] ) : "";
   $image = "";

   //Image resource
   if ( isset( $_FILES[ 'event_poster' ][ 'tmp_name' ] ) && $_FILES[ 'event_poster' ][ 'tmp_name' ] != null ) {
      $image_dir = "../../event/images/";
      $thumb_dir = "../../event/image_thumbs/";
      $exp_name = explode( ".", basename( $_FILES[ 'event_poster' ][ 'name' ] ) );
      $image = "event_poster" . round( microtime( true ) ) . "." . end( $exp_name );
      $target_image = $image_dir . $image;
      $target_thumb = $thumb_dir . $image;

      //Handle the image poster
      //check for valid image and resize it
      $imageFileType = pathinfo( $target_image, PATHINFO_EXTENSION );
      $check = getimagesize( $_FILES[ 'event_poster' ][ 'tmp_name' ] );
      $uploadOk = 1;
      if ( $check === false ) {
         $uploadOk = 0;
      }
      if ( $imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'gif' && $imageFileType != 'png' ) {
         $uploadOk = 0;
      }
      if ( $uploadOk != 0 ) {

         copy( $_FILES[ 'event_poster' ][ 'tmp_name' ], $target_image );
         move_uploaded_file( $_FILES[ 'event_poster' ][ 'tmp_name' ], $target_thumb );

         $info = pathinfo( $target_image );
         if ( strtolower( $info[ 'extension' ] ) == 'jpg' || strtolower( $info[ 'extension' ] ) == 'jpeg' ) {
            $img = imagecreatefromjpeg( $target_image );
            $width = imagesx( $img );
            $height = imagesy( $img );
            //create thumb image 
            $thumb_width = 300;
            $thumb_height = $thumb_width * ( $height / $width );
            $new_thumb_image = imagecreatetruecolor( $thumb_width, $thumb_height );
            //create poster image
            $poster_width = 1080;
            $poster_height = $poster_width * ( $height / $width );
            $new_poster_image = imagecreatetruecolor( $poster_width, $poster_height );
            //copy and resize the old image into new
            imagecopyresampled( $new_thumb_image,
               $img,
               0, 0,
               0, 0,
               $thumb_width, $thumb_height,
               $width, $height );
            imagecopyresampled( $new_poster_image,
               $img,
               0, 0,
               0, 0,
               $poster_width, $poster_height,
               $width, $height );
            //Save image into a new file
            imagejpeg( $new_thumb_image, $target_thumb, 80 );
            imagejpeg( $new_poster_image, $target_image, 80 );

         }
         if ( strtolower( $info[ 'extension' ] ) == 'png' ) {
            $img = imagecreatefrompng( $target_image );
            $width = imagesx( $img );
            $height = imagesy( $img );
            //create thumb image 
            $thumb_width = 300;
            $thumb_height = $thumb_width * ( $height / $width );
            $new_thumb_image = imagecreatetruecolor( $thumb_width, $thumb_height );
            //create poster image
            $poster_width = 1080;
            $poster_height = $poster_width * ( $height / $width );
            $new_poster_image = imagecreatetruecolor( $poster_width, $poster_height );
            //copy and resize the old image into new
            imagecopyresampled( $new_thumb_image,
               $img,
               0, 0,
               0, 0,
               $thumb_width, $thumb_height,
               $width, $height );
            imagecopyresampled( $new_poster_image,
               $img,
               0, 0,
               0, 0,
               $poster_width, $poster_height,
               $width, $height );
            //Save image into a new file
            imagepng( $new_thumb_image, $target_thumb, 80 );
            imagepng( $new_poster_image, $target_image, 80 );
         }
         if ( strtolower( $info[ 'extension' ] ) == 'gif' ) {
            $img = imagecreatefromgif( $target_image );
            $width = imagesx( $img );
            $height = imagesy( $img );
            //create thumb image 
            $thumb_width = 300;
            $thumb_height = $thumb_width * ( $height / $width );
            $new_thumb_image = imagecreatetruecolor( $thumb_width, $thumb_height );
            //create poster image
            $poster_width = 1080;
            $poster_height = $poster_width * ( $height / $width );
            $new_poster_image = imagecreatetruecolor( $poster_width, $poster_height );
            //copy and resize the old image into new
            imagecopyresampled( $new_thumb_image,
               $img,
               0, 0,
               0, 0,
               $thumb_width, $thumb_height,
               $width, $height );
            imagecopyresampled( $new_poster_image,
               $img,
               0, 0,
               0, 0,
               $poster_width, $poster_height,
               $width, $height );
            //Save image into a new file
            imagegif( $new_thumb_image, $target_thumb, 80 );
            imagegif( $new_poster_image, $target_image, 80 );
         }
      }
   }
   //Insert data into database
   $conn = create_connection( "ces" );
   if ( $event_date !== "" ) {
      if ( $image != "" ) {
         $query = "INSERT INTO event (event_group, event_title, event_category, event_poster, event_date, event_desc, event_rules, event_coordinators) values (?, ?, ?, ?, ?, ?, ?, ?)";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'ssssssss', $event_group, $event_title, $event_category, $image, $event_date, $event_desc, $event_rules, $event_coord );
         $stmt->execute();
      } else {
         $query = "INSERT INTO event (event_group, event_title, event_category, event_date, event_desc, event_rules, event_coordinators) values (?, ?, ?, ?, ?, ?, ?)";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'sssssss', $event_group, $event_title, $event_category, $event_date, $event_desc, $event_rules, $event_coord );
         $stmt->execute();
      }
   } else {
      if ( $image != "" ) {
         $query = "INSERT INTO event (event_group, event_title, event_category, event_poster, event_desc, event_rules, event_coordinators) values (?, ?, ?, ?, ?, ?, ?)";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'sssssss', $event_group, $event_title, $event_category, $image, $event_desc, $event_rules, $event_coord );
         $stmt->execute();
      } else {
         $query = "INSERT INTO event (event_group, event_title, event_category, event_desc, event_rules, event_coordinators) values (?, ?, ?, ?, ?, ?)";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'ssssss', $event_group, $event_title, $event_category, $event_desc, $event_rules, $event_coord );
         $stmt->execute();
      }
   }
   $conn->close();
   echo( $stmt->error );
   redirect( "./" );
}

//Handle event group creation request
if ( isset( $_POST[ 'create_event_group' ] ) ) {
   $event_group = htmlspecialchars( trim( $_POST[ 'group_name' ] ) );
   $conn = create_connection( "ces" );
   $query = "INSERT INTO event_group (group_name) values (?)";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 's', $event_group );
   $stmt->execute();
   $conn->close();
   redirect( "./" );
}

//Handle event deletion request
if ( isset( $_GET[ 'delete_event' ] ) && $_GET[ 'delete_event' ] == "true" ) {
   $event_id = ( int )$_GET[ 'event_id' ];
   /*
   $conn = create_connection( "ces" );
   $query = "SELECT event_poster FROM event WHERE event_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $event_id );
   $event_poster = "";
   $stmt->bind_result( $event_poster );
   $stmt->execute();
   $stmt->fetch();
   //Delete images
   if ( $event_poster != "event_poster_default.jpg" ) {
      unlink( "../../event/images/" . $event_poster );
      unlink( "../../event/image_thumbs/" . $event_poster );
   }
   $conn->close();
   //Delete records from database
   $conn = create_connection( "ces" );
   $query = "DELETE FROM event WHERE event_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $event_id );
   $stmt->execute();
   $conn->close();
   redirect("./");
   */
   $conn = create_connection( "ces" );
   $query = "UPDATE event SET display_flag = 0 WHERE event_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $event_id );
   $stmt->execute();
   $conn->close();
   redirect("./");
}

//Handle event edit request
if ( isset( $_POST[ 'update_event' ] ) ) {
   $event_group = trim( $_POST[ 'event_group' ] );
   $event_id = (int)$_POST['event_id'];
   $event_title = htmlspecialchars( trim( $_POST[ 'event_title' ] ) );
   $event_category = htmlspecialchars( trim( $_POST[ 'event_category' ] ) );
   $event_date = $_POST[ 'event_date' ] != null ? date( 'Y-m-d', strtotime( $_POST[ 'event_date' ] ) ) : "";
   $event_desc = htmlspecialchars( trim( $_POST[ 'event_desc' ] ) );
   $event_rules = $_POST[ 'event_rules' ];
   $event_coord = isset( $_POST[ 'event_coord' ] ) ? htmlspecialchars( $_POST[ 'event_coord' ] ) : "";
   $image = "";
   //Image resource
   if ( isset( $_FILES[ 'event_poster' ][ 'tmp_name' ] ) && $_FILES[ 'event_poster' ][ 'tmp_name' ] != null ) {
      $image_dir = "../../event/images/";
      $thumb_dir = "../../event/image_thumbs/";
      $exp_name = explode( ".", basename( $_FILES[ 'event_poster' ][ 'name' ] ) );
      $image = "event_poster" . round( microtime( true ) ) . "." . end( $exp_name );
      $target_image = $image_dir . $image;
      $target_thumb = $thumb_dir . $image;

      //Handle the image poster
      //check for valid image and resize it
      $imageFileType = pathinfo( $target_image, PATHINFO_EXTENSION );
      $check = getimagesize( $_FILES[ 'event_poster' ][ 'tmp_name' ] );
      $uploadOk = 1;
      if ( $check === false ) {
         $uploadOk = 0;
      }
      if ( $imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'gif' && $imageFileType != 'png' ) {
         $uploadOk = 0;
      }
      if ( $uploadOk != 0 ) {

         copy( $_FILES[ 'event_poster' ][ 'tmp_name' ], $target_image );
         move_uploaded_file( $_FILES[ 'event_poster' ][ 'tmp_name' ], $target_thumb );

         $info = pathinfo( $target_image );
         if ( strtolower( $info[ 'extension' ] ) == 'jpg' || strtolower( $info[ 'extension' ] ) == 'jpeg' ) {
            $img = imagecreatefromjpeg( $target_image );
            $width = imagesx( $img );
            $height = imagesy( $img );
            //create thumb image 
            $thumb_width = 300;
            $thumb_height = $thumb_width * ( $height / $width );
            $new_thumb_image = imagecreatetruecolor( $thumb_width, $thumb_height );
            //create poster image
            $poster_width = 1080;
            $poster_height = $poster_width * ( $height / $width );
            $new_poster_image = imagecreatetruecolor( $poster_width, $poster_height );
            //copy and resize the old image into new
            imagecopyresampled( $new_thumb_image,
               $img,
               0, 0,
               0, 0,
               $thumb_width, $thumb_height,
               $width, $height );
            imagecopyresampled( $new_poster_image,
               $img,
               0, 0,
               0, 0,
               $poster_width, $poster_height,
               $width, $height );
            //Save image into a new file
            imagejpeg( $new_thumb_image, $target_thumb, 80 );
            imagejpeg( $new_poster_image, $target_image, 80 );

         }
         if ( strtolower( $info[ 'extension' ] ) == 'png' ) {
            $img = imagecreatefrompng( $target_image );
            $width = imagesx( $img );
            $height = imagesy( $img );
            //create thumb image 
            $thumb_width = 300;
            $thumb_height = $thumb_width * ( $height / $width );
            $new_thumb_image = imagecreatetruecolor( $thumb_width, $thumb_height );
            //create poster image
            $poster_width = 1080;
            $poster_height = $poster_width * ( $height / $width );
            $new_poster_image = imagecreatetruecolor( $poster_width, $poster_height );
            //copy and resize the old image into new
            imagecopyresampled( $new_thumb_image,
               $img,
               0, 0,
               0, 0,
               $thumb_width, $thumb_height,
               $width, $height );
            imagecopyresampled( $new_poster_image,
               $img,
               0, 0,
               0, 0,
               $poster_width, $poster_height,
               $width, $height );
            //Save image into a new file
            imagepng( $new_thumb_image, $target_thumb, 80 );
            imagepng( $new_poster_image, $target_image, 80 );
         }
         if ( strtolower( $info[ 'extension' ] ) == 'gif' ) {
            $img = imagecreatefromgif( $target_image );
            $width = imagesx( $img );
            $height = imagesy( $img );
            //create thumb image 
            $thumb_width = 300;
            $thumb_height = $thumb_width * ( $height / $width );
            $new_thumb_image = imagecreatetruecolor( $thumb_width, $thumb_height );
            //create poster image
            $poster_width = 1080;
            $poster_height = $poster_width * ( $height / $width );
            $new_poster_image = imagecreatetruecolor( $poster_width, $poster_height );
            //copy and resize the old image into new
            imagecopyresampled( $new_thumb_image,
               $img,
               0, 0,
               0, 0,
               $thumb_width, $thumb_height,
               $width, $height );
            imagecopyresampled( $new_poster_image,
               $img,
               0, 0,
               0, 0,
               $poster_width, $poster_height,
               $width, $height );
            //Save image into a new file
            imagegif( $new_thumb_image, $target_thumb, 80 );
            imagegif( $new_poster_image, $target_image, 80 );
         }
      }
   }
   //Insert data into database
   $conn = create_connection( "ces" );
   if ( $event_date !== "" ) {
      if ( $image != "" ) {
         $query = "UPDATE event SET event_group = ?, event_title = ?, event_category = ?, event_poster = ?, event_date = ?, event_desc = ?, event_rules = ?, event_coordinators = ? WHERE event_id = ?";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'ssssssssi', $event_group, $event_title, $event_category, $image, $event_date, $event_desc, $event_rules, $event_coord, $event_id );
         $stmt->execute();
      } else {
         $query = "UPDATE event SET event_group = ?, event_title = ?, event_category = ?, event_date = ?, event_desc = ?, event_rules = ?, event_coordinators = ? WHERE event_id = ?";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'sssssssi', $event_group, $event_title, $event_category, $event_date, $event_desc, $event_rules, $event_coord, $event_id );
         $stmt->execute();
      }
   } else {
      if ( $image != "" ) {
         $query = "UPDATE event SET event_group = ?, event_title = ?, event_category = ?, event_poster = ?, event_desc = ?, event_rules = ?, event_coordinators = ? WHERE event_id = ?";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'sssssssi', $event_group, $event_title, $event_category, $image, $event_desc, $event_rules, $event_coord, $event_id );
         $stmt->execute();
      } else {
         $query = "UPDATE event SET event_group = ?, event_title = ?, event_category = ?, event_desc = ?, event_rules = ?, event_coordinators = ? WHERE event_id = ?";
         $stmt = $conn->prepare( $query );
         $stmt->bind_param( 'ssssssi', $event_group, $event_title, $event_category, $event_desc, $event_rules, $event_coord, $event_id );
         $stmt->execute();
      }
   }
   $conn->close();
   echo( $stmt->error );
   redirect( "./" );
}
redirect( "./" );
?>