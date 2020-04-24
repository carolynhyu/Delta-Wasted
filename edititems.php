<?php

  // Check for required data.
  if ( empty($_POST['general_id']) 
    || empty($_POST['item_weight'])
    || empty($_POST['item_date'])
    || empty($_POST['item_cost'])
    || empty($_POST['item_og_weight'])
  ) {
    $error = "Please fill out all required fields.";
  } else {
    
     require "config/config.php";

    // Establish MySQL Connection.
     $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check for any Connection Errors.
    if ( $mysqli->connect_errno ) {
      echo $mysqli->connect_error;
      exit();
    }

    $general_id = $_POST['general_id'];
    $item_weight = $_POST['item_weight'];
    $item_date = $_POST['item_date'];
    $item_cost = $_POST['item_cost'];
    $item_og_weight = $_POST['item_og_weight'];

    $ratio = $item_cost/$item_og_weight;
    $new_cost = $ratio*$item_weight;

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

$sql_update = "UPDATE mastersheet
SET quantity = $item_weight,
expiration_date = '$item_date',
cost = $new_cost
WHERE general_id = $general_id AND
user_id = $user_id;";

    $results = $mysqli->query($sql_update);

    if ( !$results ) {
      echo $mysqli->error;
      $mysqli->close();
      exit();
    }

    $mysqli->close();
  }

?>