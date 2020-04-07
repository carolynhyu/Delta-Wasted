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

  $item_row = $item_results->fetch_assoc();

  // today's date
  $today_date = strtotime(date('Y-m-d'));
  $expiration_date = strtotime($item_row['expiration_date']);
  $days_left = abs(($expiration_date - $today_date)/60/60/24);

  // json if/else statements (append to given variable)
  $color = '';
  if ( $days_left >= 7 ) {
    $color .= '#a0d468';
  } else if ( $days_left < 7 && $days_left >= 3 ) {
    $color .= '#ffaf66';
  } else if ( $days_left < 3 ) {
    $color .= '#ff6666';
  } else {
    $color .= '#000';
  }

  // $events = '';
  // while ( $item_row = $item_results->fetch_assoc() ) {
  //   $events .= '{title: \''. $item_row['item'] . '\', start: \'' . $item_row['expiration_date'];
  //   $events .= '\', color: \'' . $color . '\'' . '}, ';
  // }
  $events = [];

  while ( $item_row = $item_results->fetch_assoc() ) {
      $events[] = ['title' => $item_row['item'], 'start' => $item_row['expiration_date'], 'color' => $color];
    }


  $events = json_encode($events,JSON_PRETTY_PRINT);
  echo $events;

  $mysqli->close();

?>