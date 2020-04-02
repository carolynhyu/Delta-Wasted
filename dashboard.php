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
    <link rel="stylesheet" href="assets/css/dashboard_stylesheet.css" />
    <link rel="stylesheet" href="assets/css/bootstrap_nav.css" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

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

    <link rel="stylesheet" href="assets/css/main.css" />

    <script>
      window.onload = function () {

      var options = {
        exportEnabled: true,
        animationEnabled: true,
        title: {
        },
        data: [
        {
          type: "splineArea",
          dataPoints: [
            { y: 10 },
            { y: 6 },
            { y: 14 },
            { y: 12 },
            { y: 19 },
            { y: 14 },
            { y: 26 },
            { y: 10 },
            { y: 22 }
          ]
        }
        ]
      };
      $("#chartContainer").CanvasJSChart(options);

      }
    </script>
    <style>
            #scrollable {
/*      background-color: lightblue;*/
/*      width: 500px;*/
      margin-left: auto;
      margin-right: auto;
      height: 40vh;
      overflow: scroll;
    }

    #fridge-list td {
      border: none;
    }

    #fridge-list tr {
      border-top: 1px solid #dee2e6;
    }
    </style>

    <title></title>
  </head>
  <body>
    <?php include ('navbar.php'); ?>

        <!-- MAIN CONTENT FOR EACH PAGE -->

        <div class="col-md-10 offset-md-2 hidePadding">
          <div class="main-content add-ingredients">
            <div class="container-fluid main-content-header">
        
        <!--ROW 1 Title: EXPIRING SOON AND CATEGORY-->
              <div class="row">
                <div class="col-md-6">
                  <h4>Expiring Soon</h4>
                </div>
                <div class="col-md-6">
                  <h4>Food Wasted by Category</h4>
                </div>
              </div>

        <!--ROW 2 EXPIRING SOON LIST AND CATEGORY DONUT GRAPH-->
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
                 <!--  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <img class="food_pic" alt="food" src="assets/img/ingredients/apple.png">


                      <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Dapibus ac facilisis in
                      <span class="badge badge-primary badge-pill">2</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Morbi leo risus
                      <span class="badge badge-primary badge-pill">1</span>
                    </li>
                  </ul> -->
                <div class="col-md-6" id="chartjs-wrapper"> <!--GOALS boxes-->
                  <canvas id="chartjs-4" class="chartjs-wrapper chartjs"></canvas>
                    <script>new Chart(document.getElementById("chartjs-4"),
                      {"type":"doughnut",
                      "data":{
                        "labels":["Meat","Vegetables","Fruits"],
                        "datasets":[{"label":"My First Dataset","data":[300,50,100],
                        "backgroundColor":["rgb(255, 99, 132)",
                        "rgb(160, 212, 104)","rgb(255, 205, 86)"]}]}});
                      </script>
                </div>
            </div> <!--END of List and CHART-->
             
 
                  <!-- <button
                    type="button"
                    class="btn btn-primary right-float-button disabled"
                  >
                    Add selected ingredients<span
                      class="fa fa-arrow-right fa-fw ml-3"
                    ></span>
                  </button> -->


<!--ROW 3 TITLE: GOALS and AREA GRAPH-->
        <div class="row" id="title-goals-and-area">
          <div class="col-md-6">
            <h4>Goals</h4>
          </div>
          <div class="col-md-4">
            <h4>Savings</h4>
          </div>
          <div class="dropdown col-md-2">
              <button
                class="btn btn-secondary dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                Last Year
              </button>
              <div
                class="dropdown-menu"
                aria-labelledby="dropdownMenuButton"
              >
                <a class="dropdown-item" href="#">Last Week</a>
                <a class="dropdown-item" href="#">2 Weeks Ago</a>
                <a class="dropdown-item" href="#">3 Weeks Ago</a>
                <a class="dropdown-item" href="#">Last Month</a>
              </div>
            </div> <!--END of DROPDOWN-->
          </div>
        </div> <!--END OF TITLE GOALS AND AREA-->

<!--ROW 4 GOALS and AREA GRAPH-->
        <div class="row" id="goals-and-area">
          <div class="col-md-6" id="goals">

              <div class="food-box">
                <img class="goal-img" alt="food-img" src="assets/img/ingredients/bacon.png" />
                <div class="food-title">
                  Bacon
                </div>
                <div class="over-weight-mssg">
                </div>
                <div class="food-weight">
                  1 lbs / <span class="goal-weight">1.5 lbs</span>
                </div><!--End of FOOD-WEIGHT-->
                <button type="button" class="btn align-self-end btn-primary btn-lg btn-block">
                 Edit Goal
                </button>
              </div><!--END of food-box-->

              <div class="food-box">
                <img class="goal-img" alt="food-img" src="assets/img/ingredients/garlic.png" />
                <div class="food-title">
                  Garlic
                </div>
                <div class="over-weight-mssg">
                  1 oz over!
                </div>
                <div class="food-weight">
                  5 oz / <span class="goal-weight">4 oz</span>
                </div><!--End of FOOD-WEIGHT-->
                <button type="button" class="btn btn-primary btn-lg btn-block">
                 Edit Goal
                </button>
              </div><!--END of food-box-->

          </div> <!--END of GOALS-->

          <div class="col-md-6" id="savings">
            <!-- <div class="row mb-4">
              <div class="col-md-6 box text-center" id="savings-past-year">
                <div>
                  <span class="price">$1,325.56</span><br>
                  <span class="saving-caption">Total savings in the past year</span>
                </div>
              </div>
              <div class="col-md-6 box text-center" id="savings-past-month">
                <div>
                  <span class="price">$110.45</span><br>
                  <span class="saving-caption">Average savings per month</span>
                </div>
              </div>
            </div> -->

            <div class="row">
              <div id="chartContainer" style="height: 250px; width: 100%; background-color: gray;"></div>
            </div>
          </div> <!--END of SAVINGS-->

        </div><!--END of GOALS and AREA-->



      </div><!--END of CONTAINER FLUID-->
    </div> <!--END of MAIN CONTENT-->
  </div> <!--END of HIDE PADDING--> 






<!--DONUT CHART-->
    <script src="assets/js/Chart.bundle.min.js">
      var ctx = document.getElementById('myDoughnutChart').getContext('2d');

      var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {}
      });

      var data = {
            datasets: [{
              data: [10, 20, 30]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
              labels: [
                'Red',
                'Yellow',
                'Green'
            ]
      };

    </script>

<!--END of DONUT CHART STUFF-->



    
    <!--AREA CHART STUFF-->
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <!--END of AREA CHART STUFF-->

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
