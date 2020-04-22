
<?php


    require "config/config.php";

    $output = '';
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ( $mysqli->connect_errno ) {
      echo $mysqli->connect_error;
      exit();
    }
  
    $mysqli->set_charset('utf8');

$item_user_id = $_POST['item_user_id'];
$item_expiration = "$_POST['item_expiration']";
$item_fridgelist_id = $_POST['item_id'];
$item_quantity = $_POST['item_quantity'];


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

    '<div id="edit-modal" class="existing-modal" data-id=>
    <div class="ingredient-image">
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



        <div class="inline-edit">
          <div class="left-edit">
            <h4>Cost ($)</h4>
          </div>
          <div class="right-edit">
            <input
              type="hidden"
              class="form-control currency-input existing-item"
              value="' . $row['cost'] . '"
            />
          </div>
        </div>

        <div class="inline-edit weight-input">
          <div class="left-edit">
            <h4>Weight (oz)</h4>
          </div>
          <div class="right-edit">
            <input 
            type="hidden"
            class="form-control"
            name="expires"
            id="hidden-weight"
            value="' . $row['quantity'] . '"
          />
          </div>
          <div class="clear: both"></div>
        </div>
       

        <button type="button" id="edit-submit" class="btn btn-primary button-after-inline-edit">
          <span class="fa fa-check fa-fw mr-3"></span>Add ingredient
        </button>
        </form>
    
    
    ';
    echo $sql_edit ."<br>";
    echo $output;


  



?>
<!--
<script type="text/javascript">
$(document).ready(function() {
    
$('.dropdown-item').click(function() {
    let selection = $(this).html();
    $(this).parent().prev().html(selection)
    $(this).parent().prev().attr('temp-id', $(this).attr('temp-id'))
    $('.edit-modal').attr('data-id', $(this).attr('item-id'))
})

$('#edit-submit').click(function() {

    var item_id = $('.edit-modal').attr('data-id');
    var item_weight = $('#weight').val();
    var item_date = $('.date-final').val();
    var item_cost = $('.currency-input.existing-item').val();

    if(item_date != "" && item_weight != "" && item_cost != "") {
    $.fancybox.close();
    var currentSingle = $('.edit-modal').attr("data-id")
    $('.ingredient-inner[item-id="' + currentSingle + '"').addClass("selected")



    console.log("id: ", item_id)

    $.ajax({
              url:"edititems.php",
              method: "post",
              data: {item_id:item_id, item_weight:item_weight, item_date:item_date, item_cost:item_cost},
              success: function(data) {
                alert("Succesfully added to your fridge list")
              }

            });


        }
        else {
            alert("Please fill out all required fields")
        }
})

});
</script>
-->

