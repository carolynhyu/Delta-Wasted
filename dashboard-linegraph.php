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

  $sql = "SELECT SUM(cost) AS cost_sum, MONTHNAME(expiration_date) AS month
                 FROM mastersheet
                 WHERE user_id = $user_id AND expiration_date < CURRENT_DATE
                 GROUP BY MONTH(expiration_date)
                 ORDER BY expiration_date ASC;";

  $results = $mysqli->query($sql);

  if ( !$results ) {
    echo $mysqli->error;
    exit();
  }

  while ( $item_row = $results->fetch_assoc() ) {

   $cost_sum[] = $item_row['cost_sum'];
   $month_labels[] = $item_row['month'];

    }


  $cost_sum = json_encode($cost_sum,JSON_PRETTY_PRINT);
  $month_labels = json_encode($month_labels,JSON_PRETTY_PRINT);


  $mysqli->close();

  ?>