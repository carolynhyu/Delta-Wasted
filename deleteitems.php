<?php

require 'config/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ( $mysqli->connect_errno ) {
  echo $mysqli->connect_error;
  exit();
}

$item_user_id = $mysqli->escape_string( $_POST['item_user_id'] );
$item_expiration = $mysqli->escape_string( $_POST['item_expiration'] );
$item_fridgelist_id = $mysqli->escape_string( $_POST['item_fridgelist_id'] );
$item_quantity = $mysqli->escape_string( $_POST['item_quantity'] );

$email = $_SESSION['user_email'];
$password = $_SESSION['user_password'];

// $sql_user = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password';";
// $results_user = $mysqli->query($sql_user);
// if ( !$results_user ) {
//   echo $mysqli->error;
//   $mysqli->close();
//   exit();
// }

// $row = $results_user->fetch_assoc();

// $user_id = $row['user_id'];


    // Find item based on values and delete from row
$sql_delete = "DELETE FROM mastersheet
        WHERE user_id=$item_user_id AND
        fridgelist_id=$item_fridgelist_id AND
        quantity=$item_quantity AND
        expiration_date='$item_expiration';";

$results_delete = $mysqli->query($sql_delete);

if (!$results_delete) {
  // echo $item_id;
  echo $mysqli->error;
  $mysqli->close();
  exit();
}

$mysqli->close();


   
?>