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
  
    $row = $results_single->fetch_array();

    $item_name = $row['fridgelist_name'];

    $sql_variants = "SELECT * FROM fridgelists WHERE fridgelist_name='".$item_name."'";
    $results_variants = $mysqli->query($sql_variants);
    if ( !$results_variants ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    $sql_temps = "SELECT * FROM temperatures";
    $results_temps = $mysqli->query($sql_temps);
    if ( !$results_variants ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    $temp_ref = array();

    while($row_temps = mysqli_fetch_array($results_temps))
        {
            array_push($temp_ref, $row_temps['temp']);
        }


    $mysqli->close();
    

    $output .= '
    
    <div class="ingredient-image">
          <img src="' . $row['img_url'] . '" />
        </div>
        <h4>' . $row['fridgelist_name'] . '</h4>
        <form>
    <div class="dropdown">
        <button
          class="btn btn-secondary dropdown-toggle official-temp"
          type="button"
          id="dropdownMenuButton"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          Select storage type
        </button>
        <div
          class="dropdown-menu"
          aria-labelledby="dropdownMenuButton"
        >';

        while($row_variants = mysqli_fetch_array($results_variants))
        {
            $temp_adjust = $row_variants['temp_id'] - 1;
            $output .= '<a class="dropdown-item" temp-id=' . $row_variants['temp_id'] . ' item-id=' . $row_variants['fridgelist_id'] . '>' . $temp_ref[$temp_adjust] . '</a>';
        }


          
        $output .= '
        </div>
      </div>

    
        <div class="inline-edit weight-input">
          <div class="left-edit">
            <h4>Weight (oz)</h4>
          </div>
          <div class="right-edit">
            <input
            type="number"
            class="form-control"
            name="expires"
            id="weight"
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
              class="form-control currency-input existing-item"
              min="0.01"
              step="0.01"
              max="2500"
              value=""
            />
          </div>
        </div>
        <button type="button" id="add-item-submit" class="btn btn-primary button-after-inline-edit">
          <span class="fa fa-check fa-fw mr-3"></span>Add ingredient
        </button>
        </form>
    
    
    ';

    echo $output;


  


}
?>

<script type="text/javascript">
$(document).ready(function() {
		
$('.dropdown-item').click(function() {
    let selection = $(this).html();
    $(this).parent().prev().html(selection)
    $(this).parent().prev().attr('temp-id', $(this).attr('temp-id'))
    $('.existing-modal').attr('data-id', $(this).attr('item-id'))
})

$('#add-item-submit').click(function() {

    var item_id = $('.existing-modal').attr('data-id');
    var item_weight = $('#weight').val();
    var item_date = $('.date-final').val();
    var item_cost = $('.currency-input.existing-item').val();

    if(item_date != "" && item_weight != "" && item_cost != "") {
    $.fancybox.close();
    var currentSingle = $('.existing-modal').attr("data-id")
    $('.ingredient-inner[item-id="' + currentSingle + '"').addClass("selected")



    console.log("id: ", item_id)

    $.ajax({
              url:"insertitems.php",
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