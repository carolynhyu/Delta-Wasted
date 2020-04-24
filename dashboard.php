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

//************FOOD WASTE PERCENTAGE CALCULATION****************//
  $sql_percent = "SELECT Round(SUM(quantity)/ SUM(og_quantity)*100,2) AS waste_percent, MONTHNAME(expiration_date) AS month 
                  FROM mastersheet 
                  WHERE user_id = $user_id AND expiration_date < CURRENT_DATE AND MONTH(expiration_date)= MONTH(CURRENT_DATE);";

  $results_waste_percentage = $mysqli->query($sql_percent);
    
    if ( !$results_waste_percentage ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

//***********PAYTON'S***************//
  $sql_items = "SELECT * FROM fridgelists";

  $results_items = $mysqli->query($sql_items);
    if ( !$results_items ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

     //RETRIEVE SPECIFIC USER'S FRIDGE LIST ITEMS
    $sql_user_fridgelist = "SELECT user_id, fridgelists.img_url AS image, fridgelists.fridgelist_name AS item, mastersheet.fridgelist_id AS item_id, mastersheet.quantity AS quantity, mastersheet.expiration_date AS date
        FROM mastersheet
        LEFT JOIN fridgelists
              ON mastersheet.fridgelist_id=fridgelists.fridgelist_id
              WHERE mastersheet.user_id=$user_id AND mastersheet.expiration_date > CURRENT_DATE
               ORDER BY expiration_date ASC;";

    $results_user_fridgelist = $mysqli->query($sql_user_fridgelist);

    if ( !$results_user_fridgelist ) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }
//***********PAYTON'S***************//

  $mysqli->close();

  include "donut-labels.php";
  include "dashboard-linegraph.php";

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

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"
    />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css" />

    <style>
      #scrollable {
/*    background-color: lightblue;*/
     /* width: 400px;*/
      margin-left: auto;
      margin-right: auto;
      height: 40vh;
      overflow: scroll;
    }

   #fridge-list td {
      border: none;
   /*   margin-left: 5%*/
    }

    #fridge-list tr {
      padding: 15px 0;
      border-top: 15px solid #f5f5f5;
    }

    .food-name{
      font-weight:bold;
    }

    .food_pic{
      padding-left: 11%;
    }

    #main-tree p{
      color: gray;
    }

    #displayed-tree{
      width:120px;
      height:auto;
      margin-left: 39%;
    }

    #sub-trees{
      margin-left: 3%;
    }

    .sub-tree{
      width:30px;
      height:auto;
      margin: 0 13%;
    }

    #user-tree{
      text-align: center;
      font-weight: bold;
    }

    .tree-text{
      color:black;
    }

    .percent-text{
      margin-top: -6%;
      color: gray;
      font-weight: lighter;
    }

    #yellow-tree-text{
      padding-left: 22%;
    }

    #bare-tree-text{
      padding-left: 22%;
    }

    .waste-percentage{
      float:left;
      padding-left: 15%;
      font-size: .8em;
      color:gray;
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
        <!--*************************PAYTON'S******************-->
              <div class="row">
                <div class="col-md-6" id="expiringfood">  <!--A list of expiring soon food-->
                  <div id="scrollable">
                  <table id="fridge-list" class="table">
                    <tbody id="tbody2">

                     <?php while ($row_table = $results_user_fridgelist->fetch_assoc() ) : ?> 
                      <tr class="row align-items-center">
                        <input type="hidden" id="user_id" value="<?php echo $row_table['user_id']; ?>">
                        <input type="hidden" id="fridgelist_id" value="<?php echo $row_table['item_id']; ?>">
                        <td class="col-md-5"><img class="food_pic" alt="<?php echo $row_table['fridgelist_name']; ?>" src="<?php echo $row_table['image']; ?>"></td>
                        <td class="col-md-4 align-middle">
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
                      </tr>
                      <?php endwhile; ?>

                    </tbody>
                  </table>
                </div> <!--scrollable-->
                </div>
          
              <!--Doughnut Chart-->
                 <div class="col-md-6" id="chartjs-wrapper"> 
                    <canvas id="myChart"></canvas>
                </div>
            </div> <!--END of List and CHART-->
             


<!--ROW 3 TITLE: GOALS and AREA GRAPH-->
        <div class="row" id="title-goals-and-area">
    
            <div class="col-md-6">
              <h4>Saving the Environment</h4>
            </div>
            <div class="col-md-6">
              <h4>Money Wasted</h4>
            </div>
          </div><!--END OF TITLE GOALS AND AREA-->
      

<!--ROW 4 GOALS and AREA GRAPH-->
        <div class="row" id="goals-and-area">
          <div class="col-md-6" id="goals">
            <div id="main-tree">
              <p>The lower the waste percentage, the greener your tree gets</p>
              <!-- If waste % < 20 then img = tree1, 20-80% then img = tree2, 80 > tehn img =tree 3 -->
              <?php 

              $row_percent = $results_waste_percentage->fetch_assoc();
              $percent = $row_percent['waste_percent'];


              if($percent<20): ?> 
                <img id="displayed-tree" src="assets/img/dashboard/tree.png" alt="tree">
  

              <?php elseif($percent >= 20 && $percent <= 80) : ?>
                 <img id="displayed-tree" src="assets/img/dashboard/tree2.png" alt="tree">
            

              <?php elseif($percent > 80) : ?>
               <img id="displayed-tree" src="assets/img/dashboard/tree3.png" alt="tree">
              

              <?php endif; ?>
             
            </div><!--END of main-tree-->
            <div id="user-tree">
              <p id="usertree" class="tree-text"><?php echo $row['user_firstname'];?>'s <?php echo date(F,time()) ?> Tree </p>
              <p id="percenttree" class="percent-text"> <?php echo $percent ?>% of your food was wasted this month</p>
            </div><!--END of user-tree-->
            <div id="sub-trees">
              <img id="tree1" class="sub-tree" src="assets/img/dashboard/tree.png" alt="tree">
              <img id="tree2" class="sub-tree" src="assets/img/dashboard/tree2.png" alt="tree">
              <img id="tree3" class="sub-tree" src="assets/img/dashboard/tree3.png" alt="tree">
            </div><!--END of sub-trees-->
            <div id="subtree-description">
              <div id="green-tree-text" class="waste-percentage"> < 20% </div>
              <div id="yellow-tree-text" class="waste-percentage"> 20% - 80% </div>
              <div id="bare-tree-text" class="waste-percentage"> > 80% </div>
            </div><!--END of subtree-description-->

          </div><!--END of GOALS--> 

          <div class="col-md-6" id="savings">
            <div class="row">
                <div class="chartjs-wrapper">
                  <canvas id="myChart2" width="500" height="300px"></canvas>
                </div><!--End of chartjs-wrapper for savings-->
            </div><!--End of ROW-->
          </div><!--End of SAVINGS-->
          

        </div><!--END of GOALS and AREA-->



      </div><!--END of CONTAINER FLUID-->
    </div> <!--END of MAIN CONTENT-->
  </div> <!--END of HIDE PADDING--> 




    
    <!--AREA CHART STUFF-->

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

    <!--*********************DOUGHNUT CHART*********************-->
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo $labels ?>,
            datasets: [{
                data: <?php echo $quantity ?>,
                backgroundColor: <?php echo $color ?>
            }]
        },
        
    });
    </script>

    <!--**************SAVINGS GRAPH*******************-->
    <script>
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $month_labels ?>,
            datasets: [{
                label: 'Wasted Money $',
                data: <?php echo $cost_sum ?>,
                backgroundColor: [
                    'rgba(160, 212, 104, 0.2)'
                ],
                borderColor: [
                    'rgb(160, 212, 104)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            fill: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    </script>

  </body>
</html>
