
<?php


    require "config/config.php";

    $output = '';
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ( $mysqli->connect_errno ) {
      echo $mysqli->connect_error;
      exit();
    }
  
    $mysqli->set_charset('utf8');

$general_id = $mysqli->escape_string($_POST['general_id']);
$item_user_id = $mysqli->escape_string($_POST['item_user_id']);
$item_expiration = $mysqli->escape_string($_POST['item_expiration']);
$item_fridgelist_id = $mysqli->escape_string($_POST['item_id']);
$item_quantity = $mysqli->escape_string($_POST['item_quantity']);


$sql_edit = "SELECT *
        FROM mastersheet
        LEFT JOIN fridgelists
        ON fridgelists.fridgelist_id = mastersheet.fridgelist_id
        WHERE user_id=$item_user_id AND
        mastersheet.fridgelist_id=$item_fridgelist_id AND
        quantity=$item_quantity AND
        expiration_date='$item_expiration';";



$results_edit = $mysqli->query($sql_edit);

if (!$results_edit) {
  // echo $item_id;
  echo $mysqli->error;
  $mysqli->close();
  exit();
}
$row = $results_edit->fetch_assoc();


//echo $sql_edit;
//print_r($row);


$mysqli->close();
   

    $output .= 
// <div id="edit-modal" class="existing-modal" data-id=>
    '<div class="ingredient-image">
          <img src="' . $row['img_url'] . '" />
        </div>
        <h4>' . $row['fridgelist_name'] . '</h4>
        <form>


      <div class="inline-edit weight-input">
          <div class="left-edit">
            <h4>Weights (oz)</h4>
          </div>
          <div class="right-edit">
            <input 
            type="number"
            class="form-control"
            name="expires"
            id="weight"
            value = "' . $row['quantity'] . '"
          />
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
              class="form-control date-final"
              name="expires"
              id="expires"
              value = "' . $row['expiration_date'] . '"
            />
          </div>
        </div>

            <input
              type="hidden"
              class="form-control currency-input existing-item"
              value="' . $row['cost'] . '"
            />

            <input 
            type="hidden"
            class="form-control"
            name="expires"
            id="hidden-weight"
            value="' . $row['quantity'] . '"
          />

          <input
              type="hidden"
              class="general_id"
              value="' . $row['general_id'] . '"
            />

        <button type="button" id="edit-submit" class="btn btn-primary button-after-inline-edit">
          <span class="fa fa-check fa-fw mr-3"></span>Update ingredient
        </button>
        </form>
    
    
    ';
    // echo $sql_edit ."<br>";
    echo $output;


  



?>

<script type="text/javascript">

$('#edit-submit').click(function() {
    var general_id = $('.general_id').val();
    var item_weight = $('#weight').val();
    var item_date = $('.date-final').val();
    var item_cost = $('.currency-input.existing-item').val();
    var item_og_weight = $('#hidden-weight').val();

    if(item_date != "" && item_weight != "" && item_cost != "") {
    $.fancybox.close();

    $.ajax({
              url:"edititems.php",
              method: "post",
              data: {item_weight:item_weight, item_date:item_date, item_cost:item_cost, item_og_weight:item_og_weight, general_id:general_id},
              success: function(data) {
                alert("Succesfully updated your fridge list item")
              }

            });


        }
        else {
            alert("Please fill out all required fields")
        }
});
</script>


