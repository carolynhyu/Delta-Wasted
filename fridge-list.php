<?php

  require "config/config.php";

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $mysqli->set_charset('utf8');

  //LOGIN INFORMATION

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
  $sql_items = "SELECT * FROM fridgelists";

  $results_items = $mysqli->query($sql_items);
    if ( !$results_items ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

  $row_items = mysqli_fetch_array($results_items);

  //CATEGORY FILTER

  $sql_categories = "SELECT * FROM categories";

  $results_categories = $mysqli->query($sql_categories);
    if ( !$results_categories ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    //RETRIEVE SPECIFIC USER'S FRIDGE LIST ITEMS
    $sql_user_fridgelist = "SELECT general_id, user_id, fridgelists.img_url AS image, fridgelists.fridgelist_name AS item, mastersheet.fridgelist_id AS item_id, mastersheet.quantity AS quantity, mastersheet.expiration_date AS date
        FROM mastersheet
        LEFT JOIN fridgelists
              ON mastersheet.fridgelist_id=fridgelists.fridgelist_id
              WHERE mastersheet.user_id=$user_id;";

    $results_user_fridgelist = $mysqli->query($sql_user_fridgelist);
    if ( !$results_user_fridgelist ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }


    //DELETE SPECIFC ROW ITEM
    // $ = "DELETE FROM mastersheet
    //       WHERE mastersheet.user_id=$user_id"

  $mysqli->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <link href='assets/js/fullcalendar-4.4.0/packages/core/main.css' rel='stylesheet' />
    <link href='assets/js/fullcalendar-4.4.0/packages/daygrid/main.css' rel='stylesheet' />
    <script src='assets/js/fullcalendar-4.4.0/packages/core/main.js'></script>
    <script src='assets/js/fullcalendar-4.4.0/packages/interaction/main.js'></script>
    <script src='assets/js/fullcalendar-4.4.0/packages/daygrid/main.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var CalendarEl = document.getElementById('calendar');
        
        //var events = <?php // echo json_encode($events); ?>;

        var Calendar = new FullCalendar.Calendar(CalendarEl, {
          plugins: [ 'interaction', 'dayGrid' ],
          editable: true,

          eventLeave: function(info) {
            console.log('event left!', info.event);
          },

          events: window.location.origin + '/Delta-Wasted-develop/fridge-list-data.php'

        });

        Calendar.render();
      });

    </script>

    <!--calendar-->
    <link rel="stylesheet" href="assets/css/stylesheet.css" />
    <link rel="stylesheet" href="assets/css/bootstrap_nav.css" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <script
      src="https://kit.fontawesome.com/cddc03767c.js"
      crossorigin="anonymous"
    ></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"
    />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css"/>

    <style>

      body {
/*        margin: 20px 0 0 20px;*/
      /*  font-size: 14px;*/
        /*font-family: Arial, Helvetica Neue, Helvetica, sans-serif;*/
        font-family: 'Muli', sans-serif !important;
      }

/*      #source-calendar,*/
      #destination-calendar {
        float: left;
       /* width: 600px;*/
        margin: 0 20px 20px 0;
      }

      #scrollable {
/*      background-color: lightblue;*/
/*      width: 500px;*/
      margin-left: auto;
      margin-right: auto;
      height: 60vh;
      overflow: scroll;
    }

    #fridge-list td {
      border: none;
    }

    #fridge-list tr {
      padding: 15px 0;
      border-top: 15px solid #f5f5f5;
    }

    .food-name{
      font-weight:bold;
    }


    /*#calendar{
      font-family:Century Gothic;
    }

    /*#fridge-list {
      border-collapse: collapse;
    }
    #fridge-list tr {
      border: 1px solid #000;
      width: 480px;
      margin: 10px;
      display: block;
      border-radius: 20px;
    }
    #fridge-list td {
      display: block;
      text-align: center;
    }*/

    #calendar .fc-scroller {
      height: auto !important;
    }

    #calendar{
      font-size:10px;
    }

    .delete{
      width:50px;
    }

    #delete-item-submit:hover{
      cursor:pointer;
    }

    .edit{
      width:50px;
    }

    .edit:hover{
      cursor:pointer;
    }

</style>

    <title>Wasted | Fridge List</title>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
        <!-- MAIN CONTENT FOR EACH PAGE -->

        <div class="col-md-10 offset-md-2 hidePadding">
          <div class="main-content add-ingredients">
            <div class="container-fluid main-content-header">
              <div class="row">
                <div class="col-md-12">
                  <h4><?php echo $row['user_firstname'];?>'s Fridge List</h4>
                </div> 
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <input
                  placeholder="start typing to search for ingredients..."
                  type="text"
                  name="search"
                  class="ingredient-search form-control"
                  />
                </div>
              </div>
            </div>
            <div class="container-fluid filter-section">
              <div class="row">
                <div class="col-md-12">
                  <div class="dropdown">
                    <button
                    class="btn btn-secondary dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >
                    Categories
                  </button>
                  <div
                  class="dropdown-menu categories"
                  aria-labelledby="dropdownMenuButton"
                  >
                  <a class="dropdown-item reset" href="#">All items</a>
                  <?php while($row = mysqli_fetch_assoc($results_categories))
                  {
                    echo '<a class="dropdown-item" id="category-chosen" name="category_id" category-id="' . $row['category_id'] . '">' . $row['category'] . '</a>';
                  } ?>
                </div>
              </div>
              <div class="dropdown">
                <button
                class="btn btn-secondary dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                >
                Sort
              </button>
              <div
              class="dropdown-menu sort"
              aria-labelledby="dropdownMenuButton"
              >
                
                <a class="dropdown-item" sort-id="ascending">Ascending</a>
                <a class="dropdown-item" sort-id="descending">Descending</a>
                <a class="dropdown-item" sort-id="date-ascending">Expires quickest</a>
                <a class="dropdown-item" sort-id="date-descending">Expires slowest</a>
            </div>
          </div>
        <div style="display:none">
      <div id="ingredient-modal" class="existing-modal" data-id=>
        <div class="ingredient-image">
          <img src="assets/img/ingredients/olives.png" />
        </div>
        <h4>Black Olives</h4>
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
      </div>
    </div>
    </div>
  </div>
</div>

            <div class="row">
                <div class="col-md-6" id="expiringfood">  <!--A list of expiring soon food-->
                  <div id="scrollable">
                  <table id="fridge-list" class="table">
                    <tbody id="tbody2">

                     <?php while ($row_table = $results_user_fridgelist->fetch_assoc() ) : ?> 
                      <tr class="row align-items-center">
                        <input type="hidden" id="user_id_<?php echo $row_table['general_id']; ?>" value="<?php echo $row_table['user_id']; ?>">
                        <input type="hidden" id="general_id_<?php echo $row_table['general_id']; ?>" value="<?php echo $row_table['general_id']; ?>">
                        <input type="hidden" id="fridgelist_id_<?php echo $row_table['general_id']; ?>" value="<?php echo $row_table['item_id']; ?>">
                        <td class="col-md-2"><img class="food_pic" alt="<?php echo $row_table['fridgelist_name']; ?>" src="<?php echo $row_table['image']; ?>"></td>
                        <td class="col-md-3 align-middle">
                          <div class="food-name"><?php echo $row_table['item']; ?></div>
                          <input type="hidden" id="quantity_id_<?php echo $row_table['general_id']; ?>" value="<?php echo $row_table['quantity']; ?>">
                          <div class="food-count"><?php echo $row_table['quantity']; ?> ounces</div>
                        </td>
                        <td class="col-md-3 date">
                          <input type="hidden" id="expiration_date_<?php echo $row_table['general_id']; ?>" value="<?php echo $row_table['date']; ?>">

                          <?php

                            $today_date = strtotime(date('Y-m-d'));
                            $expiration_date = strtotime($row_table['date']);
                            $days_left = ($expiration_date - $today_date)/60/60/24;

                            $orgDate = $row_table['date'];  
                            $newDate = date("M jS", strtotime($orgDate));

                          if ( $days_left >= 7 ) : ?>
                            <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector.png">
                            <div class="green-clock exp-date">
                          <?php echo $newDate; ?></div>

                          <?php elseif ( $days_left < 7 && $days_left >= 3 ): ?>
                            <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-1.png">
                            <div class="yellow-clock exp-date">
                          <?php echo $newDate; ?></div>

                          <?php elseif ( $days_left < 3 && $days_left >=0 ): ?>
                            <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-2.png">
                            <div class="red-clock exp-date">
                            <?php echo $newDate; ?></div>

                          <?php elseif ( $days_left < 0 ): ?>
                            <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-3.png">
                            <div class="black-clock exp-date">
                            <?php echo $newDate; ?></div>
                         
                          <?php endif; ?>

                        </td>
                        <td class="col-md-2">


        <!--************EDIT FANCY BOX****************-->

                            <a data-fancybox class="ope" data-src="#edit-modal">
                              <img general_id="<?php echo $row_table['general_id']; ?>" class="edit edit-item-submit" alt="food" src="assets/img/edit.png">
                            </a>

        <!--************EDIT FANCY BOX****************-->

                        </td>

                        <td class="col-md-2">
                          <img general_id="<?php echo $row_table['general_id']; ?>" class="delete delete-item-submit" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>
                      <?php endwhile; ?>

                    </tbody>
                  </table>
                </div>
              </div>
     

                <!--calendar-->

                  <div class="col-md-6" id='calendar'></div>

            </div>


<div style="display:none">
      <div id="edit-modal" class="existing-modal" data-id="" >
         <!-- <div class="ingredient-image">
          <img src="assets/img/ingredients/olives.png" />
        </div>
        <h4>Black Olives</h4>
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
      </div>
    </div>

    <div style="display:none">
      <div id="custom-ingredient-modal">
        <div class="ingredient-image custom-image">
          <img src="assets/img/ingredients/fruit-general.png" />
        </div>
        <h4>Add a custom ingredient</h4>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01"
              >Upload</span
            >
          </div>
          <div class="custom-file">
            <input
              type="file"
              class="custom-file-input"
              id="inputGroupFile01"
              aria-describedby="inputGroupFileAddon01"
            />
            <label class="custom-file-label" for="inputGroupFile01"
              >Choose a custom icon...</label
            >
          </div>
        </div>
        <h4>Ingredient name</h4>
        <input
          placeholder="What is your ingredient called?"
          type="text"
          name="custom-name"
          class="form-control"
        />
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
            <h4>Category</h4>
          </div>
          <div class="right-edit">
            <div class="dropdown">
              <button
                class="btn btn-secondary dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                What kind of food?
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Vegetables</a>
                <a class="dropdown-item" href="#">Fruits</a>
                <a class="dropdown-item" href="#">Grains</a>
                <a class="dropdown-item" href="#">Beans & Nuts</a>
                <a class="dropdown-item" href="#">Fish & Seafood</a>
                <a class="dropdown-item" href="#">Meat & Poultry</a>
                <a class="dropdown-item" href="#">Dairy</a>
                <a class="dropdown-item" href="#">Other</a>
              </div>
            </div>
          </div>
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
        </button> -->
      </div>
    </div>
        

            <script type="text/javascript">

              $(document).ready(function() {
                //SEARCH FUNCTION

                $('.ingredient-search').keyup(function() {
                  var term = $(this).val();
                  console.log(term);
                  if (term != '') {
                    $.ajax({
                      url:"fridge-list-search.php",
                      method: "post",
                      data:{search:term},
                      success: function(data) {
                        $('#tbody2').html(data)
                      }

                    });
                  }
                  else {
                    $.ajax({
                      url:"fridge-list-search.php",
                      method: "post",
                      data:{search:term},
                      success: function(data) {
                        $('#tbody2').html(data)
                      }

                    });
                  }

                });

                // CATEGORY FUNCTION

                $('.categories .dropdown-item').click(function() {
                  if($(this).hasClass('reset')) {
                    $.ajax({
                      url:"fridge-list-search.php",
                      method: "post",
                      data:{category:catId},
                      success: function(data) {
                        $('#tbody2').html(data)
                      }

                    });
                  }
                  else {
                    var catId = $(this).attr('category-id');
                    if (catId != '') {
                      $.ajax({
                        url:"fridge-list-categories.php",
                        method: "post",
                        data:{category:catId},
                        success: function(data) {
                          $('#tbody2').html(data)
                        }

                      });
                    }
                  }
                });

                // SORT ASCENDING FUNCTION
                $('.dropdown-item').click(function() {
                  var sortId = $(this).attr('sort-id');                    
                    if (sortId == 'ascending') {
                      $.ajax({
                        url:"fridge-list-ascending.php",
                        method: "post",
                        data:{sort:sortId},
                        success: function(data) {
                          $('#tbody2').html(data)
                        }
                      });
                    } else if (sortId == 'descending') {
                      $.ajax({
                        url:"fridge-list-descending.php",
                        method: "post",
                        data:{sort:sortId},
                        success: function(data) {
                          $('#tbody2').html(data)
                        }
                      });
                    } else if (sortId == 'date-ascending'){
                      $.ajax({
                        url:"fridge-list-date-ascending.php",
                        method: "post",
                        data:{sort:sortId},
                        success: function(data) {
                          $('#tbody2').html(data)
                        }
                      });
                    } else {
                      $.ajax({
                        url:"fridge-list-date-descending.php",
                        method: "post",
                        data:{sort:sortId},
                        success: function(data) {
                          $('#tbody2').html(data)
                        }
                      });
                    };


                  });

                //EDIT FUNCTION
                $('.edit-item-submit').click(function() {
                	var general_id = $(this).attr('general_id');
                  console.log(general_id);

                  //*********CAROLYN*************//
                  var userID = $('#user_id_' + general_id).val();
                  var expDate = $('#expiration_date_' + general_id).val();
                  var friID = $('#fridgelist_id_' + general_id).val();
                  var quanID = $('#quantity_id_' + general_id).val();
                  var genID = $('#general_id_' + general_id).val();
                  console.log(userID);
                  console.log(expDate);
                  console.log(friID);
                  console.log(quanID);

                	$('.existing-modal').attr("data-id", friID);
                  //Successfully carries the fridgelist id #
                	// console.log(item_id);

                	$.ajax({
                		url:"item-2.php",
                		method: "post",
                		// data:{"item_user_id":userID, "item_expiration":expDate, "item_id":friID, "item_quantity":quanID},
                		data:{item_user_id:userID, item_expiration:expDate, item_id:friID, item_quantity:quanID, general_id:genID},
                		success: function(data) {
                      //console.log(data);
                			$('#edit-modal').html(data);
                		}

                	});
                });




                // DELETE FUNCTION
                $('.delete-item-submit').click(function() {
                  var general_id = $(this).attr('general_id');
                  console.log(general_id);
                  
                  var item_user_id = $('#user_id'+ general_id).val();
                  var item_expiration = $('#expiration_date'+ general_id).val();
                  var item_fridgelist_id = $('#fridgelist_id'+ general_id).val();
                  var item_quantity = $('#quantity_id'+ general_id).val();
                  var genID = $('#general_id_' + general_id).val();

                  if(item_expiration != "" && item_fridgelist_id != "" && item_quantity != "") {
                    $.fancybox.close();
                    // var currentSingle = $('.existing-modal').attr("data-id")
                    // $('.ingredient-inner[item-id="' + currentSingle + '"').addClass("selected")

                    console.log("id: ", item_user_id)

                    $.ajax({
                      url:"deleteitems.php",
                      method: "post",
                      data: {item_user_id:item_user_id, item_expiration:item_expiration, item_fridgelist_id:item_fridgelist_id, item_quantity:item_quantity, general_id:genID},
                      success: function(data) {
                        alert("Succesfully deleted from your fridge list")
                      }

                    });


                  }
                  else {
                    alert("Please fill out all required fields")
                  }
                })

              });
            </script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js"
      integrity="sha256-yDarFEUo87Z0i7SaC6b70xGAKCghhWYAZ/3p+89o4lE="
      crossorigin="anonymous"
    ></script>
    <script src="assets/js/core.js"></script>
  </body>
</html>
