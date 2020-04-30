<?php

    require 'config/config.php';
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }
  $output;
  $custom_name = $mysqli->escape_string( $_POST['custom_name'] );
  $custom_weight = $mysqli->escape_string( $_POST['custom_weight'] );
  $custom_date = $mysqli->escape_string( $_POST['custom_date'] );
  $custom_cost = $mysqli->escape_string( $_POST['custom_cost'] );
  $custom_category = $mysqli->escape_string( $_POST['custom_category'] );
  $category_img = $mysqli->escape_string( $_POST['category_img'] );

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

  $sql_check = $mysqli->query("SELECT * FROM fridgelists WHERE fridgelist_name='$custom_name'");

  $number_of_rows = mysqli_num_rows($sql_check);

  if ($number_of_rows > 0)
  {
      echo "This item already exists!";
      die();
  }
    // Username & email are available.
    $sql_new = "INSERT INTO `fridgelists` (`fridgelist_name`, `fridgelist_days`, `temp_id`, `category_id`, `img_url`) VALUES ('$custom_name', '', '0', '$custom_category', '$category_img')";

    $results = $mysqli->query($sql_new);

    if (!$results) {
      echo $mysqli->error;
      $mysqli->close();
      exit();
    }
    else {

      $sql_check_fridgelist_id = $mysqli->query("SELECT * FROM fridgelists");

      $number_of_fridge_items = mysqli_num_rows($sql_check_fridgelist_id);

      $new_fridgelist_id = $number_of_fridge_items + 7;

      $sql_new_custom = "INSERT INTO `mastersheet` (`user_id`, `fridgelist_id`, `quantity`, `expiration_date`, `cost`, `og_quantity`) VALUES ('$user_id', '$new_fridgelist_id', '$custom_weight', '$custom_date', '$custom_cost', '$custom_weight')";

      $results_custom_master = $mysqli->query($sql_new_custom);

      if (!$results_custom_master) {
        echo $mysqli->error;
        $mysqli->close();
        die();
      }

      echo "Item added to your fridgelist!";
    }



  $mysqli->close();


   
?>