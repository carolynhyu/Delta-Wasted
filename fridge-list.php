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
        // var CalendarEl = document.getElementById('calendar');

        var Calendar = new FullCalendar.Calendar(CalendarEl, {
          plugins: [ 'interaction', 'dayGrid' ],
          editable: true,
          defaultDate: '2020-02-12',
          events: [
          {
            title: 'event1',
            start: '2020-02-11T10:00:00',
            end: '2020-02-11T16:00:00'
          },
          {
            title: 'event2',
            start: '2020-02-13T10:00:00',
            end: '2020-02-13T16:00:00'
          }
          ],
          eventLeave: function(info) {
            console.log('event left!', info.event);
          }
        });

        var Calendar = new FullCalendar.Calendar(CalendarEl, {
          plugins: [ 'interaction', 'dayGrid' ],
          defaultDate: '2020-02-12',
          editable: true,
      droppable: true, // will let it receive events!
      eventReceive: function(info) {
        console.log('event received!', info.event);
      }
    });

        // srcCalendar.render();
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
      border-top: 1px solid #dee2e6;
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
                      Categories
                    </button>
                    <div
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton"
                    >
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
                  <button
                      type="button"
                      class="btn btn-primary button-after-header"
                    >
                      <span class="fa fa-plus-circle fa-fw mr-2"></span>Add ingredients
                    </button>
                </div>
              </div>
            </div>


            <div class="row">
                <div class="col-md-6" id="expiringfood">  <!--A list of expiring soon food-->
                  <div id="scrollable">
                  <table id="fridge-list" class="table">
                    <tbody>
                      <tr class="row align-items-center">
                        <td class="col-md-3"><img class="food_pic" alt="food" src="assets/img/ingredients/mango.png"></td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">Mangos</div>
                          <div class="food-count">5 Count</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-1.png">
                          <div class="red-clock exp-date">Feb. 28th</div>
                        </td>
                      <!--   <td class="col-md-1 align-middle">
                          <button type="button" class="btn-sm btn-outline-warning edit">
                            <span>Edit</span>
                          </button>
                        </td> -->
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>

                      <tr class="row align-items-center">
                        <td class="col-md-3">
                          <img class="food_pic" alt="food" src="assets/img/ingredients/fish-steak.png">
                        </td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">Tuna Steak</div>
                          <div class="food-count">5 ounces</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-1.png">
                          <div class="red-clock exp-date">Mar. 1st</div>
                        </td>
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>

                      <tr class="row align-items-center">
                        <td class="col-md-3 align-middle">
                          <img class="food_pic" alt="food" src="assets/img/ingredients/brussels-sprouts.png">
                        </td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">Brussel Sprouts</div>
                          <div class="food-count">10 ounces</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-2.png"><div class="yellow-clock exp-date">Mar. 11th</div>
                        </td>
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>

                      <tr class="row align-items-center">
                        <td class="col-md-3 align-middle">
                          <img class="food_pic" alt="food" src="assets/img/ingredients/cherry.png">
                        </td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">Cherries</div>
                          <div class="food-count">1 lb.</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-2.png">
                          <div class="yellow-clock exp-date">Mar. 13th</div>
                        </td>
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>

                      <tr class="row align-items-center">
                        <td class="col-md-3 align-middle">
                          <img class="food_pic" alt="food" src="assets/img/ingredients/bread-1.png">
                        </td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">French Bread</div>
                          <div class="food-count">1 loaf (8 ounces)</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector-2.png"><div class="yellow-clock exp-date">Mar. 15th</div>
                        </td>
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>

                      <tr class="row align-items-center">
                        <td class="col-md-3 align-middle">
                          <img class="food_pic" alt="food" src="assets/img/ingredients/eggs.png">
                        </td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">Eggs</div>
                          <div class="food-count">1 dozen (20.5 ounces)</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector.png">
                          <div class="green-clock exp-date">Mar. 19th</div>
                        </td>
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>

                      <tr class="row align-items-center">
                        <td class="col-md-3 align-middle">
                          <img class="food_pic" alt="food" src="assets/img/ingredients/garlic.png">
                        </td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">Garlic</div>
                          <div class="food-count">2 ounces</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector.png"><div class="green-clock exp-date">Apr. 4th</div>
                        </td>
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>

                      <tr class="row align-items-center">
                        <td class="col-md-3 align-middle">
                          <img class="food_pic" alt="food" src="assets/img/ingredients/bacon.png">
                        </td>
                        <td class="col-md-4 align-middle">
                          <div class="food-name">Bacon</div>
                          <div class="food-count">2 ounces</div>
                        </td>
                        <td class="col-md-3 date">
                          <img class="clock_pic align-middle" alt="clocks" src="assets/img/clocks/Vector.png"><div class="green-clock exp-date">Apr. 7th</div>
                        </td>
                        <td class="col-md-2">
                          <img class="delete" alt="food" src="assets/img/delete.png">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div> <!--scrollable-->
                </div>

                <!--calendar-->

                  <div class="col-md-6" id='calendar'></div>

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
  </body>
</html>
