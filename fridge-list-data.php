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

  // pull food items from users' individual fridgelists
  $sql_items = "SELECT fridgelists.fridgelist_name AS item, mastersheet.expiration_date AS expiration_date FROM mastersheet
                LEFT JOIN fridgelists 
                ON mastersheet.fridgelist_id = fridgelists.fridgelist_id
                WHERE mastersheet.user_id = $user_id;";

  $item_results = $mysqli->query($sql_items);

  if ( !$item_results ) {
    echo $mysqli->error;
    exit();
  }


  $events = [];

  while ( $item_row = $item_results->fetch_assoc() ) {
    $today_date = strtotime(date('Y-m-d'));
    $expiration_date = strtotime($item_row['expiration_date']);
    $days_left = ($expiration_date - $today_date)/60/60/24;

    $color = '';
    $textColor = '';

  if ( $days_left >= 7 ) {
    $color = '#a0d468';
    $textColor = '#000';
  } else if ( $days_left < 7 && $days_left >= 3 ) {
    $color = '#ffaf66';
    $textColor = '#000';
  } else if ( $days_left < 3 && $days_left >=0 ) {
    $color = '#ff6666';
    $textColor = '#000';
  } else if ( $days_left < 0) {
    $color = '#000';
    $textColor = '#FFF';
  }

      $events[] = ['title' => $item_row['item'], 'start' => $item_row['expiration_date'], 'color' => $color, 'textColor' => $textColor];
    }


  $events = json_encode($events,JSON_PRETTY_PRINT);
  echo $events;
  // var_dump($item_row); 
  $mysqli->close();

?>