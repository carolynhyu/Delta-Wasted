<?php

  // Check for required data.
  if ( empty($_POST['track_name'])
    || empty($_POST['media_type'])
    || empty($_POST['genre'])
    || empty($_POST['milliseconds'])
    || empty($_POST['price'])
    || empty($_POST['track_id'])
  ) {
    $error = "Please fill out all required fields.";
  } else {
    $host = "304.itpwebdev.com";
    $user = "";
    $pass = "";
    $db = "";

    // Establish MySQL Connection.
    $mysqli = new mysqli($host, $user, $pass, $db);

    // Check for any Connection Errors.
    if ( $mysqli->connect_errno ) {
      echo $mysqli->connect_error;
      exit();
    }

    $track = $_POST['track_name'];
    $genre = $_POST['genre'];
    $media_type_id = $_POST['media_type'];
    $milliseconds = $_POST['milliseconds'];
    $price = $_POST['price'];

    if ( !empty($_POST['album']) ) {
      $album = $_POST['album'];
    } else {
      $album = "null";
    }

    if ( !empty($_POST['bytes']) ) {
      $bytes = $_POST['bytes'];
    } else {
      $bytes = "null";
    }

    if ( !empty($_POST['composer']) ) {
      $composer = "'" . $_POST['composer'] . "'";   // 'Tommy Trojan'
    } else {
      $composer = "null"; // null
    }

    $sql = "UPDATE tracks
            SET name = '$track',
            media_type_id = $media_type_id
            WHERE track_id = " . $_POST['track_id'] . ";";

    $results = $mysqli->query($sql);

    if ( !$results ) {
      echo $mysqli->error;
      $mysqli->close();
      exit();
    }

    $mysqli->close();
  }

?>