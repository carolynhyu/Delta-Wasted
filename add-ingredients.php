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
 $sql_items = "SELECT * FROM fridgelists ORDER BY fridgelist_name ASC";

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

        $sql_categories_2 = "SELECT * FROM categories";

        $results_categories_2 = $mysqli->query($sql_categories_2);
              if ( !$results_categories_2 ) {
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

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
                  <a data-fancybox class="open-data" data-src="#custom-ingredient-modal">
                    <button
                      type="button"
                      class="btn btn-primary button-after-header right-float-button"
                    >
                      <span class="fa fa-plus-circle fa-fw mr-3"></span>Can't
                      find your ingredient?
                    </button>
                  </a>
                  <!-- <button
                    type="button"
                    class="btn btn-primary right-float-button disabled"
                  >
                    Add selected ingredients<span
                      class="fa fa-arrow-right fa-fw ml-3"
                    ></span>
                  </button> -->
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
                      class="btn btn-secondary dropdown-toggle filter-button"
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
                      class="btn btn-secondary dropdown-toggle sort-button"
                      type="button"
                      id="dropdownMenuButton"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                    Sort
                    </button>
                    <div
                      class="dropdown-menu sort-menu"
                      aria-labelledby="dropdownMenuButton"
                    >
                      <a class="dropdown-item" href="#" direction="ASC">Alphabetical (Ascending)</a>
                      <a class="dropdown-item" href="#" direction="DESC">Alphabetical (Descending)</a>
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
        <h4>Loading item...</h4>
        <p>
          These values are automatically suggested based off of the ingredient
          you chose. You can edit them if they are not accurate.
        </p>
        <div class="inline-edit weight-input">
          <div class="left-edit">
            <h6>Weight (oz)</h6>
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
            <h6>Expires</h6>
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
            <h6>Cost ($)</h6>
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
        <p id="customError"></p>
       

        <div class="inline-edit">
          <div class="left-edit">
          <h6>Ingredient name</h6>
          </div>
          <div class="right-edit">
          <input
          type="text"
          name="custom-name"
          class="form-control"
        />
          </div>
          <div class="clear: both"></div>
        </div>
        <div class="inline-edit weight-input">
          <div class="left-edit">
            <h6>Weight (oz)</h6>
          </div>
          <div class="right-edit">
            <input
            type="number"
            class="form-control"
            name="weight"
            id="weight"
          />
          </div>
          <div class="clear: both"></div>
        </div>
        <div class="inline-edit">
          <div class="left-edit">
            <h6>Category</h6>
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
              <div class="dropdown-menu customImage" aria-labelledby="dropdownMenuButton">
              <?php
                    while($row = mysqli_fetch_assoc($results_categories_2))
                    {
                      echo '<a class="dropdown-item" href="#" category-id=' . $row['category_id'] . ' img-data="' . $row['category_img'] . '">' . $row['category'] . '</a>';
                    } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="inline-edit">
          <div class="left-edit">
            <h6>Expires</h6>
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
            <h6>Cost ($)</h6>
          </div>
          <div class="right-edit">
            <input
              type="number"
              name="costs"
              class="form-control currency-input"
              min="0.01"
              step="0.01"
              max="2500"
              value=""
            />
          </div>
        </div>
        <button type="button" class="btn btn-primary button-after-inline-edit" id="add-custom-submit">
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
          $('.filter-button').html("Filter by food category")
          $('.sort-button').html("Sort")
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

        $('.open-data').fancybox(
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
            $('.sort-button').html("Sort")
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

        $('.sort-menu .dropdown-item').click(function() {
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
          var sortIt = $(this).attr('direction');
          console.log('sort direction:',sortIt)
          $('.filter-button').html("Filter by food category")
          if (sortIt != '') {
            $.ajax({
              url:"sort.php",
              method: "post",
              data:{sort:sortIt},
              success: function(data) {
                $('.add-ingredient-boxes .row').html(data)
              }

            });
          }
        }
        });

        
        $('.customImage a').click(function() {
          $(".custom-image img").attr("src", $(this).attr("img-data"))
          $('.ingredient-image.custom-image').css('opacity', '1');
          $('.ingredient-image.custom-image').css('filter', 'saturate(1)');
        });


        $('#add-custom-submit').click(function() {

var custom_name = $('#custom-ingredient-modal input[name="custom-name"]').val();
var custom_weight = $('#custom-ingredient-modal input[name="weight"]').val();
var custom_date = $('#custom-ingredient-modal input[name="expires"]').val();
var custom_cost = $('#custom-ingredient-modal input[name="costs"]').val();
var custom_category = $('#custom-ingredient-modal .dropdown-toggle').attr("category-id");
var category_img = $('#custom-ingredient-modal .ingredient-image img').attr("src");

console.log("custom_name:", custom_name, "custom_weight:", custom_weight, "custom_date:", custom_date)


if(custom_name != "" && custom_weight != "" && custom_date != "" && custom_cost != "" && custom_category != "") {


$.ajax({
          url:"addcustom.php",
          method: "post",
          data: {custom_name:custom_name,custom_weight:custom_weight,custom_date:custom_date,custom_cost:custom_cost,custom_category:custom_category, category_img:category_img},
          success: function(data) {
            alert(data);
            if(data != "This item already exists!") {
              $.fancybox.close();
            }
          }

        });


    }
    else {
        alert("Please fill out all required fields")
    }
});

      });
    </script>


  </body>
</html>
