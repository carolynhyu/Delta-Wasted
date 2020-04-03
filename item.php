<?php
if(isset($_POST["item_id"])){
    require "config/config.php";

    $output = '';
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ( $mysqli->connect_errno ) {
      echo $mysqli->connect_error;
      exit();
    }
  
    $mysqli->set_charset('utf8');
  
    $sql_single = "SELECT * FROM fridgelists WHERE fridgelist_id='".$_POST["item_id"]."'";
    $results_single = $mysqli->query($sql_single);
    if ( !$results_single ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }
  
    $row = $results_single->fetch_assoc();

    $mysqli->close();

    $output .= '
    
    <div class="ingredient-image">
          <img src="' . $row['img_url'] . '" />
        </div>
        <h4>' . $row['fridgelist_name'] . '</h4>
        <p>
          These values are automatically suggested based off of the ingredient
          you chose. You can edit them if they are not accurate.
        </p>
        <div class="inline-edit weight-input">
          <div class="left-edit">
            <h4>Weight (oz)</h4>
          </div>
          <div class="right-edit">
            <div class="qty">
              <span class="minus bg-dark">-</span>
              <input type="number" class="count" name="qty" value="1" />
              <span class="plus bg-dark">+</span>
            </div>
          </div>
          <div class="clear: both"></div>
        </div>
        <div class="inline-edit">
          <div class="left-edit">
            <h4>Expires</h4>
          </div>
          <div class="right-edit">
            <input
              type="date"
              class="form-control"
              name="expires"
              id="expires"
            />
          </div>
        </div>

        <div class="inline-edit">
          <div class="left-edit">
            <h4>Cost ($)</h4>
          </div>
          <div class="right-edit">
            <input
              type="number"
              class="form-control currency-input"
              min="0.01"
              step="0.01"
              max="2500"
              value="25.67"
            />
          </div>
        </div>
        <button type="button" class="btn btn-primary button-after-inline-edit">
          <span class="fa fa-check fa-fw mr-3"></span>Add ingredient
        </button>
    
    
    ';

    echo $output;


  


}
?>