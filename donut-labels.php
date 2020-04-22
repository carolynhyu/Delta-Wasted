<?php
require "config/config.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $mysqli->set_charset('utf8');

  // pull user session information 
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

  $sql_items = "SELECT category, SUM(quantity) AS sum, color
                FROM mastersheet
                LEFT JOIN fridgelists
                ON mastersheet.fridgelist_id = fridgelists.fridgelist_id
                LEFT JOIN categories
                ON fridgelists.category_id = categories.category_id
                WHERE user_id=$user_id AND expiration_date < CURRENT_DATE
                GROUP BY categories.category_id;";

  $item_results = $mysqli->query($sql_items);

  if ( !$item_results ) {
    echo $mysqli->error;
    exit();
  }

  // $item_row = $item_results->fetch_assoc(); 
  //$quantity = $item_row['sum'];
  //$color = $item_row['color'];

  $labels = [];

  while ( $item_row = $item_results->fetch_assoc() ) {

   $quantity[] = $item_row['sum'];
   $color[] = $item_row['color'];
   $labels[] = $item_row['category'];

    }


  $labels = json_encode($labels,JSON_PRETTY_PRINT);
  $quantity = json_encode($quantity,JSON_PRETTY_PRINT);
  $color = json_encode($color,JSON_PRETTY_PRINT);
  // $data = json_encode($data,JSON_PRETTY_PRINT);
  //echo $labels;
  // echo $quantity;
  // echo $color;
  // echo $data;

  $mysqli->close();

?>