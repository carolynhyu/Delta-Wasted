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


        $sql_categories = "SELECT * FROM categories";

  $results_categories = $mysqli->query($sql_categories);
        if ( !$results_categories ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

  $mysqli->close();

?>

<!DOCTYPE html>
<html>
  <head>
      <link rel="stylesheet" href="assets/css/main.css" />

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"
    />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

  <style>

  </style>
    <title></title>
  </head>
  <body>

      <?php include ('navbar.php'); ?>

        <!-- MAIN CONTENT FOR EACH PAGE -->

        <div class="col-md-10 offset-md-2 hidePadding">
          <div class="main-content add-ingredients">
            <div class="container-fluid main-content-header">
              <div class="row">
                <div class="col-md-12">
                  <h4>Add ingredients</h4>
                  <a data-fancybox data-src="#custom-ingredient-modal">
                    <button
                      type="button"
                      class="btn btn-primary button-after-header right-float-button"
                    >
                      <span class="fa fa-plus-circle fa-fw mr-3"></span>Can't
                      find your ingredient?
                    </button>
                  </a>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
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
                      Filter by food category
                    </button>
                    <div
                      class="dropdown-menu categories"
                      aria-labelledby="dropdownMenuButton"
                    >
                    <a class="dropdown-item reset" href="#">All items</a>
                    <?php
                    while($row = mysqli_fetch_assoc($results_categories))
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
                </div>
              </div>
            </div>
            <div class="container-fluid add-ingredient-boxes">
              <div class="row">
              <?php
              $food_names = array();
              $food_ids = array();
                    while($row = mysqli_fetch_assoc($results_items))
                    {
                      if (!in_array($row['fridgelist_name'], $food_names)) {
                        array_push($food_names, $row['fridgelist_name']);
                      array_push($food_ids, $row['fridgelist_id']);
                      }
                      if (in_array($row['fridgelist_id'], $food_ids)) {
                        echo '<div class="col-md-3 ingredient-outer"><a data-fancybox class="ope" data-src="#ingredient-modal"><div class="ingredient-inner" item-id="' . $row['fridgelist_id'] . '"><div class="ingredient-check"><span class="fa fa-check fa-fw ml-3"></span></div><div class="ingredient-image"><img src="' . $row['img_url'] . '" /></div><h4>' . $row['fridgelist_name'] . '</h4></div></a></div>';
                          }
                      
                    }

              ?>
              </div>
            </div>
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

    var user_id = 1;
    var item_ids = [];
    var item_quantities = new Array();
    var item_dates = [];
    var item_costs = [];
 
      $(document).ready(function() {

        $('.ingredient-search').keyup(function() {
          var term = $(this).val();
          if (term != '') {
            $.ajax({
              url:"search.php",
              method: "post",
              data:{search:term},
              success: function(data) {
                $('.add-ingredient-boxes .row').html(data)
              }

            });
          }
          else {
            $.ajax({
              url:"search.php",
              method: "post",
              data:{search:term},
              success: function(data) {
                $('.add-ingredient-boxes .row').html(data)
              }

            });
          }


        });

        $('.ope').fancybox(
        {
            href:'ajax/test.php',
            titleShow:false
        }); 

          

        $('.categories .dropdown-item').click(function() {
          if($(this).hasClass('reset')) {
            $.ajax({
              url:"search.php",
              method: "post",
              data:{search:""},
              success: function(data) {
                $('.add-ingredient-boxes .row').html(data)
              }

            });
          }
          else {
          var catId = $(this).attr('category-id');
          if (catId != '') {
            $.ajax({
              url:"filter.php",
              method: "post",
              data:{category:catId},
              success: function(data) {
                $('.add-ingredient-boxes .row').html(data)
              }

            });
          }
        }
        });

      });
    </script>


  </body>
</html>
