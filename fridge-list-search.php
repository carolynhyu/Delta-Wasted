<?php 

require "config/config.php";

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $mysqli->set_charset('utf8');

$email = $_SESSION['user_email'];
$password = $_SESSION['user_password'];

$sql_user = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password';";
$results_user = $mysqli->query($sql_user);
if ( !$results_user ) {
  echo $mysqli->error;
  $mysqli->close();
  exit();
};

$row_user = $results_user->fetch_assoc();

$user_id = $row_user['user_id'];

$sql_items = "SELECT *, fridgelists.img_url AS image, fridgelists.fridgelist_name AS name, mastersheet.fridgelist_id AS id FROM mastersheet
    LEFT JOIN fridgelists
    ON mastersheet.fridgelist_id=fridgelists.fridgelist_id 
    WHERE mastersheet.user_id=$user_id AND fridgelist_name LIKE'%".$_POST['search']."%';";

$results_items = $mysqli->query($sql_items);
if ( !$results_items ) {
    echo $mysqli->error;
    exit();
}

$food_original_names = array();
$food_original_ids = array();
if(mysqli_num_rows($results_items) > 0) {

  while($row_table = mysqli_fetch_array($results_items)) {
    if (!in_array($row_table['fridgelist_name'], $food_original_names)) {
        array_push($food_original_names, $row_table['fridgelist_name']);
        array_push($food_original_ids, $row_table['mastersheet.fridgelist_id']);
      }
      if (in_array($row_table['mastersheet.fridgelist_id'], $food_original_ids)) {
    
        $today_date = strtotime(date('Y-m-d'));
        $expiration_date = strtotime($row_table['expiration_date']);
        $days_left = ($expiration_date - $today_date)/60/60/24;

        $orgDate = $row_table['expiration_date'];  
        $newDate = date("M jS", strtotime($orgDate));
        $dateSection = '';

        if ( $days_left >= 7 ) {
          $dateSection ='<img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector.png"><div class="green-clock exp-date">' . $newDate . '</div>';
        }
        else if ( $days_left < 7 && $days_left >= 3 ) {
          $dateSection ='<img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-1.png"><div class="yellow-clock exp-date">' . $newDate . '</div>';
        }
        else if ( $days_left < 3 && $days_left >=0 ) {
          $dateSection ='<img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-2.png"><div class="red-clock exp-date">' . $newDate . '</div>';
        }
        else if ( $days_left < 0 ) {
          $dateSection ='<img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-3.png"><div class="black-clock exp-date">'. $newDate . '</div>';
        };

        $output .= '<tr class="row align-items-center">
                      <input type="hidden" id="user_id" value="' . 
                      $row_table['user_id'] . '
                      "><input type="hidden" id="fridgelist_id" value="' . 
                      $row_table['id'] . '
                      "><td class="col-md-2"><img class="food_pic" alt="' . 
                      $row_table['name'] . '
                      " src="' . 
                      $row_table['image'] . '
                      "></td><td class="col-md-3 align-middle"><div class="food-name">' . 
                      $row_table['name'] . '                             
                      </div><input type="hidden" id="quantity_id" value="' . 
                      $row_table['quantity'] . '
                      "><div class="food-count">' . 
                      $row_table['quantity'] . '
                      ounces</div></td><td class="col-md-3 date"><input type="hidden" id="expiration_date" value="' . 
                      $row_table['date'] . '
                      ">' . 
                      $dateSection . '
                      </td><td class="col-md-2"><img class="edit" alt="food" src="assets/img/edit.png"></td>
                        <td class="col-md-2"><img id="delete-item-submit" class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>';

      }
}

echo $output;

}
else {
    echo "Not found";
}

$mysqli->close();

?>