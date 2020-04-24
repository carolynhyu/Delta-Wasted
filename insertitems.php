<?php

    require 'config/config.php';
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $item_id = $mysqli->escape_string( $_POST['item_id'] );
  $item_weight = $mysqli->escape_string( $_POST['item_weight'] );
  $item_date = $mysqli->escape_string( $_POST['item_date'] );
  $item_cost = $mysqli->escape_string( $_POST['item_cost'] );

  $email = $_SESSION['user_email'];
  $password = $_SESSION['user_password'];

  $sql_user = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password';";
        $results_user = $mysqli->query($sql_user);
        if ( !$results_user ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

  $row = $results_user->fetch_assoc();

  $user_id = $row['user_id'];


    // Username & email are available.
    $sql = "INSERT INTO `mastersheet` (`user_id`, `fridgelist_id`, `quantity`, `expiration_date`, `cost`, `og_quantity`) VALUES ('$user_id', '$item_id', '$item_weight', '$item_date', '$item_cost', '$item_weight')";

    $results = $mysqli->query($sql);

    if (!$results) {
        echo $item_id;
      echo $mysqli->error;
      $mysqli->close();
      exit();
    }

  $mysqli->close();


   
?>