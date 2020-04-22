<?php 

require "config/config.php";

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $mysqli->set_charset('utf8');

$sql_items = "SELECT * FROM fridgelists WHERE fridgelist_name LIKE'%".$_POST["search"]."%'";


$results_items = $mysqli->query($sql_items);
if ( !$results_items ) {
    echo $mysqli->error;

    exit();
}

$mysqli->close();

$food_original_names = array();
$food_original_ids = array();
if(mysqli_num_rows($results_items) > 0) {

while($row = mysqli_fetch_array($results_items)) {
    if (!in_array($row['fridgelist_name'], $food_original_names)) {
        array_push($food_original_names, $row['fridgelist_name']);
      array_push($food_original_ids, $row['fridgelist_id']);
      }
      if (in_array($row['fridgelist_id'], $food_original_ids)) {
    $output .= '<div class="col-md-3 ingredient-outer"><a data-fancybox class="ope" data-src="#ingredient-modal"><div class="ingredient-inner" item-id="' . $row['fridgelist_id'] . '"><div class="ingredient-check"><span class="fa fa-check fa-fw ml-3"></span></div><div class="ingredient-image"><img src="' . $row['img_url'] . '" /></div><h4>' . $row['fridgelist_name'] . '</h4></div></a></div>';
      }
}

echo $output;

}
else {
    echo "Not found";
}




?>
<script type="text/javascript">
$('.ingredient-inner').click(function() {
  console.log('te')
  var item_id = $(this).attr('item-id');
  $('.existing-modal').attr("data-id", item_id)
  console.log(item_id)

  $.ajax({
    url:"item.php",
    method: "post",
    data:{item_id:item_id},
    success: function(data) {
      $('#ingredient-modal').html(data)
    }

  });
});

$('.ope').fancybox(
        {
            href:'ajax/test.php',
            titleShow:false
        }); 


</script>