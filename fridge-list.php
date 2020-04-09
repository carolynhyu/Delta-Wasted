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
    $sql_user_fridgelist = "SELECT user_id, fridgelists.img_url AS image, fridgelists.fridgelist_name AS item, mastersheet.fridgelist_id AS item_id, mastersheet.quantity AS quantity, mastersheet.expiration_date AS date
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

          events: window.location.origin + '/fridge-list-data.php'

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

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
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
                    echo '<a class="dropdown-item" href="#" category-id=' . $row['category_id'] . '>' . $row['category'] . '</a>';
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
              class="dropdown-menu"
              aria-labelledby="dropdownMenuButton"
              >
              <a class="dropdown-item" href="#">Most added by you</a>
              <a class="dropdown-item" href="#">Alphabetical</a>
              <a class="dropdown-item" href="#">Expires quickest</a>
              <a class="dropdown-item" href="#">Expires slowest</a>
            </div>
          </div>
          <a data-fancybox data-src="#custom-ingredient-modal">
            <button
            type="button"
            class="btn btn-primary button-after-header right-float-button"
            >
            <span class="fa fa-plus-circle fa-fw mr-3"></span>Add new ingredient
          </button>
        </a>
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
                        <input type="hidden" id="user_id" value="<?php echo $row_table['user_id']; ?>">
                        <input type="hidden" id="fridgelist_id" value="<?php echo $row_table['item_id']; ?>">
                        <td class="col-md-2"><img class="food_pic" alt="<?php echo $row_table['fridgelist_name']; ?>" src="<?php echo $row_table['image']; ?>"></td>
                        <td class="col-md-3 align-middle">
                          <div class="food-name"><?php echo $row_table['item']; ?></div>
                          <input type="hidden" id="quantity_id" value="<?php echo $row_table['quantity']; ?>">
                          <div class="food-count"><?php echo $row_table['quantity']; ?> ounces</div>
                        </td>
                        <td class="col-md-3 date">
                          <input type="hidden" id="expiration_date" value="<?php echo $row_table['date']; ?>">

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
                          <img class="edit" alt="food" src="assets/img/edit.png">
                        </td>
                        <td class="col-md-2">
                          <img id="delete-item-submit" class="delete" alt="food" src="assets/img/delete.png">
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

                // DELETE FUNCTION
                $('#delete-item-submit').click(function() {

                  var item_user_id = $('#user_id').val();
                  var item_expiration = $('#expiration_date').val();
                  var item_fridgelist_id = $('#fridgelist_id').val();
                  var item_quantity = $('#quantity_id').val();

                  if(item_expiration != "" && item_fridgelist_id != "" && item_quantity != "") {
                    $.fancybox.close();
                    // var currentSingle = $('.existing-modal').attr("data-id")
                    // $('.ingredient-inner[item-id="' + currentSingle + '"').addClass("selected")

                    console.log("id: ", item_user_id)

                    $.ajax({
                      url:"deleteitems.php",
                      method: "post",
                      data: {item_user_id:item_user_id, item_expiration:item_expiration, item_fridgelist_id:item_fridgelist_id, item_quantity:item_quantity},
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
