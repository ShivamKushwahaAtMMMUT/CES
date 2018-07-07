<?php
session_start();
require( "../include/connection.php" );
require( "../include/functions.php" );
if ( !isset( $_SESSION[ 'admin' ] ) ) {
   redirect( "../index.php" );
}

//Handle preview request when new notice is geerated
if ( isset( $_POST[ 'preview' ] ) && $_POST[ 'edit' ] == "false" ) {
   //Load Data
   $title = trim( htmlspecialchars( $_POST[ 'title' ] ) );
   $validity = date( 'Y-m-d', strtotime( $_POST[ 'validity' ] ) );
   $content = trim( htmlspecialchars( $_POST[ 'content' ] ) );
   $image = isset( $_POST[ 'image_uploaded' ] ) ? $_POST[ 'image_uploaded' ] : "";
   $document = isset( $_POST[ 'document_uploaded' ] ) ? $_POST[ 'document_uploaded' ] : "";
   $link = isset( $_POST[ 'link' ] ) ? trim( htmlspecialchars( $_POST[ 'link' ] ) ) : "";
   $associates = isset( $_POST[ 'associates' ] ) ? trim( htmlspecialchars( $_POST[ 'associates' ] ) ) : "";
   //Parse url from video
   $video_url = isset( $_POST[ 'video' ] ) ? trim( htmlspecialchars( $_POST[ 'video' ] ) ) : "";
   $video = str_replace( "youtu.be", "www.youtube.com/embed", $video_url );
   $video = str_replace( "www.youtube.com/watch?v=", "www.youtube.com/embed/", $video );

   //Handle image file
   if ( isset( $_FILES[ 'image' ][ 'tmp_name' ] ) && $_FILES[ 'image' ][ 'tmp_name' ] != null ) {
      if ( is_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ] ) ) {
         $target_dir_image = "./temp_images/";
         $temp = explode( ".", $_FILES[ 'image' ][ 'name' ] );
         $image = "ces_notice_image" . round( microtime( true ) ) . "." . end( $temp );
         $target_file_image = $target_dir_image . basename( $image );
         $uploadOk = 1;
         $imageFileType = pathinfo( $target_file_image, PATHINFO_EXTENSION );
         $check = getimagesize( $_FILES[ 'image' ][ 'tmp_name' ] );
         if ( $check == false ) {
            $uploadOk = 0;
         }
         if ( $imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'gif' && $imageFileType != 'png' ) {
            $uploadOk = 0;
         }
         if ( $uploadOk != 0 ) {
            move_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ], $target_file_image );
            $info = pathinfo( $target_dir_image . $image );
            if ( strtolower( $info[ 'extension' ] ) == 'jpg' || strtolower( $info[ 'extension' ] ) == 'jpeg' ) {
               $img = imagecreatefromjpeg( "{$target_dir_image}{$image}" );
               $width = imagesx( $img );
               $height = imagesy( $img );
               $new_width = 800;
               $new_height = floor( $height * ( $new_width / $width ) );
               $new_image = imagecreatetruecolor( $new_width, $new_height );
               imagecopyresized( $new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
               imagejpeg( $new_image, "{$target_dir_image}{$image}" );
            }
            if ( strtolower( $info[ 'extension' ] ) == 'png' ) {
               $img = imagecreatefrompng( "{$target_dir_image}{$image}" );
               $width = imagesx( $img );
               $height = imagesy( $img );
               $new_width = 800;
               $new_height = floor( $height * ( $new_width / $width ) );
               $new_image = imagecreatetruecolor( $new_width, $new_height );
               imagecopyresized( $new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
               imagepng( $new_image, "{$target_dir_image}{$image}" );
            }
            if ( strtolower( $info[ 'extension' ] ) == 'gif' ) {
               $img = imagecreatefromgif( "{$target_dir_image}{$image}" );
               $width = imagesx( $img );
               $height = imagesy( $img );
               $new_width = 800;
               $new_height = floor( $height * ( $new_width / $width ) );
               $new_image = imagecreatetruecolor( $new_width, $new_height );
               imagecopyresized( $new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
               imagegif( $new_image, "{$target_dir_image}{$image}" );
            }
         }
      }
   }
   //Handle document file
   if ( isset( $_FILES[ 'document' ][ 'tmp_name' ] ) && $_FILES[ 'document' ][ 'tmp_name' ] != null ) {
      if ( is_uploaded_file( $_FILES[ 'document' ][ 'tmp_name' ] ) ) {
         $target_dir_doc = "./temp_documents/";
         $temp = explode( ".", $_FILES[ 'document' ][ 'name' ] );
         $document = "ces_notice_document" . round( microtime( true ) ) . "." . end( $temp );
         $target_file_doc = $target_dir_doc . basename( $document );
         move_uploaded_file( $_FILES[ 'document' ][ 'tmp_name' ], $target_file_doc );
      }
   }

   $conn = create_connection( "ces" );
   $query = "INSERT INTO notice_temp (title, validity, content, image, video, document, link, associates) values(?, ?, ?, ?, ?, ?, ?, ?)";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'ssssssss', $title, $validity, $content, $image, $video, $document, $link, $associates );
   $stmt->execute();
   $conn->close();

   $conn = create_connection( 'ces' );
   $query = "SELECT notice_id FROM notice_temp ORDER BY notice_id DESC LIMIT 1";
   $result = $conn->query( $query );
   $data = $result->fetch_assoc();
   $_SESSION[ 'temp_notice_id' ] = $data[ 'notice_id' ];
   $result->free();
   $conn->close();

   redirect( "./preview.php" );
}

//Handle preview request after edit mode
if ( isset( $_POST[ 'preview' ] ) && $_POST[ 'edit' ] == "true" ) {
   //Load Data
   $temp_notice_id = ( int )$_SESSION[ 'temp_notice_id' ];
   $title = trim( htmlspecialchars( $_POST[ 'title' ] ) );
   $validity = date( 'Y-m-d', strtotime( $_POST[ 'validity' ] ) );
   $content = trim( htmlspecialchars( $_POST[ 'content' ] ) );
   $image = $_POST[ 'image_uploaded' ] !== "" ? $_POST[ 'image_uploaded' ] : "";
   $document = $_POST[ 'document_uploaded' ] !== "" ? $_POST[ 'document_uploaded' ] : "";
   $link = isset( $_POST[ 'link' ] ) ? trim( htmlspecialchars( $_POST[ 'link' ] ) ) : "";
   $associates = isset( $_POST[ 'associates' ] ) ? trim( htmlspecialchars( $_POST[ 'associates' ] ) ) : "";
   //Parse url from video
   $video_url = isset( $_POST[ 'video' ] ) ? trim( htmlspecialchars( $_POST[ 'video' ] ) ) : "";
   $video = str_replace( "youtu.be", "www.youtube.com/embed", $video_url );
   $video = str_replace( "www.youtube.com/watch?v=", "www.youtube.com/embed/", $video );

   //Handle image file
   if ( $_POST[ 'image_uploaded' ] == "" ) {
      if ( isset( $_FILES[ 'image' ][ 'tmp_name' ] ) && $_FILES[ 'image' ][ 'tmp_name' ] != null ) {
         if ( is_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ] ) ) {
            $target_dir_image = "./temp_images/";
            $temp = explode( ".", $_FILES[ 'image' ][ 'name' ] );
            $image = "ces_notice_image" . round( microtime( true ) ) . "." . end( $temp );
            $target_file_image = $target_dir_image . basename( $image );
            $uploadOk = 1;
            $imageFileType = pathinfo( $target_file_image, PATHINFO_EXTENSION );
            $check = getimagesize( $_FILES[ 'image' ][ 'tmp_name' ] );
            if ( $check == false ) {
               $uploadOk = 0;
            }
            if ( $imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'gif' && $imageFileType != 'png' ) {
               $uploadOk = 0;
            }
            if ( $uploadOk != 0 ) {
               move_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ], $target_file_image );
               $info = pathinfo( $target_dir_image . $image );
               if ( strtolower( $info[ 'extension' ] ) == 'jpg' || strtolower( $info[ 'extension' ] ) == 'jpeg' ) {
                  $img = imagecreatefromjpeg( "{$target_dir_image}{$image}" );
                  $width = imagesx( $img );
                  $height = imagesy( $img );
                  $new_width = 800;
                  $new_height = floor( $height * ( $new_width / $width ) );
                  $new_image = imagecreatetruecolor( $new_width, $new_height );
                  imagecopyresized( $new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                  imagejpeg( $new_image, "{$target_dir_image}{$image}" );
               }
               if ( strtolower( $info[ 'extension' ] ) == 'png' ) {
                  $img = imagecreatefrompng( "{$target_dir_image}{$image}" );
                  $width = imagesx( $img );
                  $height = imagesy( $img );
                  $new_width = 800;
                  $new_height = floor( $height * ( $new_width / $width ) );
                  $new_image = imagecreatetruecolor( $new_width, $new_height );
                  imagecopyresized( $new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                  imagepng( $new_image, "{$target_dir_image}{$image}" );
               }
               if ( strtolower( $info[ 'extension' ] ) == 'gif' ) {
                  $img = imagecreatefromgif( "{$target_dir_image}{$image}" );
                  $width = imagesx( $img );
                  $height = imagesy( $img );
                  $new_width = 800;
                  $new_height = floor( $height * ( $new_width / $width ) );
                  $new_image = imagecreatetruecolor( $new_width, $new_height );
                  imagecopyresized( $new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                  imagegif( $new_image, "{$target_dir_image}{$image}" );
               }
            }
         }
      }
   }
   //Handle document file
   if ( $_POST[ 'document_uploaded' ] == "" ) {
      if ( isset( $_FILES[ 'document' ][ 'tmp_name' ] ) && $_FILES[ 'document' ][ 'tmp_name' ] != null ) {
         if ( is_uploaded_file( $_FILES[ 'document' ][ 'tmp_name' ] ) ) {
            $target_dir_doc = "./temp_documents/";
            $temp = explode( ".", $_FILES[ 'document' ][ 'name' ] );
            $document = "ces_notice_document" . round( microtime( true ) ) . "." . end( $temp );
            $target_file_doc = $target_dir_doc . basename( $document );
            move_uploaded_file( $_FILES[ 'document' ][ 'tmp_name' ], $target_file_doc );
         }
      }
   }

   $conn = create_connection( "ces" );
   $query = "UPDATE notice_temp SET title = ?, validity = ?, content = ?, image = ?, video = ?, document = ?, link = ?, associates = ? WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'ssssssssi', $title, $validity, $content, $image, $video, $document, $link, $associates, $temp_notice_id );
   $stmt->execute();
   $conn->close();

   redirect( "./preview.php" );
}

//Handle edit request from unfinished notices
if ( isset( $_GET[ 'edit_unfinished' ] ) ) {
   $notice_id = ( int )$_GET[ 'notice_id' ];
   $_SESSION[ 'temp_notice_id' ] = $notice_id;
   redirect( "./generate_notice.php" );
}

//Handle notice submit request
if ( isset( $_GET[ 'submit_notice' ] ) ) {
   $temp_notice_id = ( int )$_SESSION[ 'temp_notice_id' ];
   $conn = create_connection( "ces" );
   $query = "SELECT * FROM notice_temp WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $temp_notice_id );
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $title = $row['title'];
   $issue_date = $row['issue_date'];
   $content = $row['content'];
   $image = $row[ 'image' ];
   $document = $row[ 'document' ];
   $associates = $row['associates'];
   $result->free();
   $conn->close();

   //move the image and document files from temporary to permanent folder
   if ( $image !== "" ) {
      rename( "./temp_images/" . $image, "../../notice/images/" . $image );
   }
   if ( $document !== "" ) {
      rename( "./temp_documents/{$document}", "../../notice/documents/{$document}" );
   }

   //Copy table data from temp to main
   $conn = create_connection( "ces" );
   $query = "INSERT INTO notice (title, issue_date, validity, content, image, video, document, link, associates) SELECT title, issue_date, validity, content, image, video, document, link, associates FROM notice_temp WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $temp_notice_id );
   $stmt->execute();
   $conn->close();

   //Delete temporary data from temporary table
   $conn = create_connection( "ces" );
   $query = "DELETE FROM notice_temp WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $temp_notice_id );
   $stmt->execute();
   $conn->close();

   //Remove temporary notice id from session
   $_SESSION[ 'temp_notice_id' ] = 0;
   
   //Mail the submitted notice to subscribers
   $content = substr($content, 0, 200);
   $conn = create_connection("ces");
   $query = "SELECT * FROM subscribers";
   $result = $conn->query($query);
   while($row = $result->fetch_assoc()){
      send_notice_mail($row['email'], $row['name'], $title, $content, $issue_date, $associates);
   }
   $conn->close();
   //Mail notice to ces members
   $conn = create_connection("ces");
   $query = "SELECT * FROM members WHERE year IN(1, 2, 3, 4) AND email != ''";
   $result = $conn->query($query);
   while($row = $result->fetch_assoc()){
      send_notice_mail($row['email'], $row['name'], $title, $content, $issue_date, $associates);
   }
   $conn->close();

   redirect( './' );
}

//Handle the edit notice request for active notices
if ( isset( $_GET[ 'edit' ] ) ) {
   $notice_id = ( int )$_GET[ 'notice_id' ];
   $conn = create_connection( "ces" );
   $query = "SELECT image, document, issue_date, validity FROM notice WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $notice_id );
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $image = $row[ 'image' ];
   $document = $row[ 'document' ];
   $issue_date = $row[ 'issue_date' ];
   $validity = $row[ 'validity' ];
   $result->free();
   $conn->close();

   //move the image and document files from permanent to temporary folder
   if ( $image !== "" ) {
      rename( "../../notice/images/" . $image, "./temp_images/" . $image );
   }
   if ( $document !== "" ) {
      rename( "../../notice/documents/{$document}", "./temp_documents/{$document}" );
   }

   //Copy table data from main to temp
   $conn = create_connection( "ces" );
   $query = "INSERT INTO notice_temp (title, issue_date, validity, content, image, video, document, link, associates) SELECT title, issue_date, validity, content, image, video, document, link, associates FROM notice WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $notice_id );
   $stmt->execute();
   $conn->close();

   //Delete data from main table
   $conn = create_connection( "ces" );
   $query = "DELETE FROM notice WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $notice_id );
   $stmt->execute();
   $conn->close();

   //Remove temporary notice id from session
   $conn = create_connection( "ces" );
   $query = "SELECT notice_id FROM notice_temp WHERE issue_date = TIMESTAMP(?) AND validity = TIMESTAMP(?)";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'ss', $issue_date, $validity );
   $stmt->bind_result( $temp_notice_id );
   $stmt->execute();
   $stmt->fetch();
   //Set the temporary notice id into session
   $_SESSION[ 'temp_notice_id' ] = ( int )$temp_notice_id;
   $conn->close();

   redirect( './generate_notice.php' );
}


//Handle the edit notice request for unfinished notices
if ( isset( $_GET[ 'edit' ] ) ) {
   $notice_id = ( int )$_GET[ 'notice_id' ];
   $_SESSION[ 'temp_notice_id' ] = ( int )$temp_notice_id;
   redirect( './generate_notice.php' );
}

//Handle delete request from active notices
if ( isset( $_GET[ 'delete' ] ) ) {
   $notice_id = ( int )$_GET[ 'notice_id' ];
   $image = $document = "";
   $conn = create_connection( "ces" );
   $query = "SELECT image, document FROM notice WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( "i", $notice_id );
   $stmt->bind_result( $image, $document );
   $stmt->execute();
   $stmt->fetch();

   //Delete files
   if ( $image !== "" ) {
      unlink( "../../notice/images/" . $image );
   }
   if ( $document !== "" ) {
      unlink( "../../notice/documents/" . $document );
   }
   $conn->close();

   //Delete records from database
   $conn = create_connection( "ces" );
   $query = "DELETE FROM notice WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $notice_id );
   $stmt->execute();
   $conn->close();
   redirect( "./index.php" );
}

//Handle delete request from archieved notices
if ( isset( $_GET[ 'delete_archieve' ] ) ) {
   $notice_id = ( int )$_GET[ 'notice_id' ];
   $image = $document = "";
   $conn = create_connection( "ces" );
   $query = "SELECT image, document FROM notice WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( "i", $notice_id );
   $stmt->bind_result( $image, $document );
   $stmt->execute();
   $stmt->fetch();

   //Delete files
   if ( $image !== "" ) {
      unlink( "../../notice/images/" . $image );
   }
   if ( $document !== "" ) {
      unlink( "../../notice/documents/" . $document );
   }
   $conn->close();

   //Delete records from database
   $conn = create_connection( "ces" );
   $query = "DELETE FROM notice WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $notice_id );
   $stmt->execute();
   $conn->close();
   redirect( "./archieves.php" );
}

//Handle delete request from unfinished notices
if ( isset( $_GET[ 'delete_temp' ] ) ) {
   $notice_id = ( int )$_GET[ 'notice_id' ];
   $image = $document = "";
   $conn = create_connection( "ces" );
   $query = "SELECT image, document FROM notice_temp WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( "i", $notice_id );
   $stmt->bind_result( $image, $document );
   $stmt->execute();
   $stmt->fetch();

   //Delete files
   if ( $image !== "" ) {
      unlink( "./temp_images/" . $image );
   }
   if ( $document !== "" ) {
      unlink( "./temp_documents/" . $document );
   }
   $conn->close();

   //Delete records from database
   $conn = create_connection( "ces" );
   $query = "DELETE FROM notice_temp WHERE notice_id = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'i', $notice_id );
   $stmt->execute();
   $conn->close();
   redirect( "./unfinished.php" );
}

//Handle request for Clean Unfinished
if ( isset( $_POST[ 'clean_unfinished' ] ) ) {
   $email = trim( htmlspecialchars( $_POST[ 'email' ] ) );
   $password = $_POST[ 'password' ];
   $conn = create_connection( "ces" );
   $query = "SELECT * FROM admin WHERE email = ? and password = ?";
   $stmt = $conn->prepare( $query );
   $stmt->bind_param( 'ss', $email, $password );
   $stmt->execute();
   $result = $stmt->get_result();
   $rows = ( int )$result->num_rows;
   $result->free();
   $conn->close();
   if ( $rows === 1 ) {
      $conn = create_connection( "ces" );
      $query = "SELECT image, document FROM notice_temp";
      $result = $conn->query( $query );
      while ( $row = $result->fetch_assoc() ) {
         if ( $row[ 'image' ] !== "" ) {
            unlink( "./temp_images/" . $row[ 'image' ] );
         }
         if ( $row[ 'document' ] !== "" ) {
            unlink( "./temp_documents/" . $row[ 'document' ] );
         }
      }
      $conn->close();
      $conn = create_connection( "ces" );
      $query = "DELETE FROM notice_temp";
      $result = $conn->query( $query );
      $conn->close();
      redirect( "./unfinished.php" );
   } else {
      redirect( "./unfinished.php?warning=" . urlencode( "Email or password is wrong" ) );
   }
}
redirect("./");
?>