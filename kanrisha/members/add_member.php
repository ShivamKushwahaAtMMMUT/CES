<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );
if(!isset($_SESSION['admin'])){
   redirect("../index.php");
}

if ( isset( $_POST[ 'add_member' ] ) ) {
   //Retreive form data
   $member_name = trim( htmlspecialchars( $_POST[ 'member_name' ] ) );
   $designation = trim( htmlspecialchars( $_POST[ 'designation' ] ) );
   $year = ( int )htmlspecialchars( $_POST[ 'year' ] );
   $linkedin = isset( $_POST[ 'linkedin' ] ) ? trim( htmlspecialchars( $_POST[ 'linkedin' ] ) ) : "";
   $facebook = isset( $_POST[ 'facebook' ] ) ? trim( htmlspecialchars( $_POST[ 'facebook' ] ) ) : "";
   $email = isset( $_POST[ 'email' ] ) ? trim( htmlspecialchars( $_POST[ 'email' ] ) ) : "";

   //Load image
   $target_dir = "../../members/member_images/";
   $temp = explode( ".", $_FILES[ 'image' ][ 'name' ] );
   $image = "member" . round( microtime( true ) ) . "." . end( $temp );
   $target_file = $target_dir . basename( $image );
   $uploadOk = 1;

   //check for valid image and resize it
   $imageFileType = pathinfo( $target_file, PATHINFO_EXTENSION );
   $check = getimagesize( $_FILES[ 'image' ][ 'tmp_name' ] );
   if ( $check === false ) {
      $uploadOk = 0;
   }
   if ( $imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'gif' && $imageFileType != 'png' ) {
      $uploadOk = 0;
   }
   if ( $uploadOk != 0 ) {

      move_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ], $target_file );

      $info = pathinfo( $target_dir . $image );
      if ( strtolower( $info[ 'extension' ] ) == 'jpg' || strtolower( $info[ 'extension' ] ) == 'jpeg' ) {
         $img = imagecreatefromjpeg( "{$target_dir}{$image}" );
         $width = imagesx( $img );
         $height = imagesy( $img );
         //create new image 
         $thumb_width = 500;
         $thumb_height = 500;
         $original_aspect = $width / $height;
         $thumb_aspect = $thumb_width / $thumb_height;
         if ( $original_aspect >= $thumb_aspect ) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ( $height / $thumb_height );
         } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ( $width / $thumb_width );
         }
         $new_image = imagecreatetruecolor( $thumb_width, $thumb_height );
         //copy and resize the old image into new and crop
         imagecopyresampled( $new_image,
            $img,
            0 - ( $new_width - $thumb_width ) / 2, // Center the image horizontally
            0 - ( $new_height - $thumb_height ) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height );
         //Save image into a new file
         imagejpeg( $new_image, $target_file, 80 );
      }
      if ( strtolower( $info[ 'extension' ] ) == 'png' ) {
         $img = imagecreatefrompng( "{$target_dir}{$image}" );
         $width = imagesx( $img );
         $height = imagesy( $img );
         //create new image 
         $thumb_width = 500;
         $thumb_height = 500;
         $original_aspect = $width / $height;
         $thumb_aspect = $thumb_width / $thumb_height;
         if ( $original_aspect >= $thumb_aspect ) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ( $height / $thumb_height );
         } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ( $width / $thumb_width );
         }
         $new_image = imagecreatetruecolor( $thumb_width, $thumb_height );
         //copy and resize the old image into new and crop
         imagecopyresampled( $new_image,
            $img,
            0 - ( $new_width - $thumb_width ) / 2, // Center the image horizontally
            0 - ( $new_height - $thumb_height ) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height );
         //Save image into a new file
         imagepng( $new_image, $target_file );
      }
      if ( strtolower( $info[ 'extension' ] ) == 'gif' ) {
         $img = imagecreatefromgif( "{$target_dir}{$image}" );
         $width = imagesx( $img );
         $height = imagesy( $img );
         $new_width = 500;
         $new_height = floor( $height * ( $new_width / $width ) );
         //create new image 
         $thumb_width = 500;
         $thumb_height = 500;
         $original_aspect = $width / $height;
         $thumb_aspect = $thumb_width / $thumb_height;
         if ( $original_aspect >= $thumb_aspect ) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ( $height / $thumb_height );
         } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ( $width / $thumb_width );
         }
         $new_image = imagecreatetruecolor( $thumb_width, $thumb_height );
         //copy and resize the old image into new and crop
         imagecopyresampled( $new_image,
            $img,
            0 - ( $new_width - $thumb_width ) / 2, // Center the image horizontally
            0 - ( $new_height - $thumb_height ) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height );
         //Save image into a new file
         imagegif( $new_image, $target_file, 80 );
      }
   }
   $conn = create_connection( "ces" );
   $query = "INSERT INTO members (name, image, year, designation, linkedin, facebook, email) VALUES (?, ?, ?, ?, ?, ?, ?)";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'ssissss', $member_name, $image, $year, $designation, $linkedin, $facebook, $email );
   $stmt->execute();
   $conn->close();
}
redirect( "./index.php" );
?>