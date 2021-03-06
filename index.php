<?php

  session_start();

  require "config/config.php";

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $mysqli->set_charset('utf8');


//******************* KR's CODE **********************//
  // If not logged in
if ( !isset( $_SESSION['login'] ) || empty( $_SESSION['login'] ) ) {

    // If user tried logging in, check if everything is filled
    if ( !isset( $_POST['username'] ) || empty($_POST['username']) || !isset( $_POST['password'] ) || empty($_POST['password']) ) {
            $error = "Please fill out username and password.";
    }
    else {
        // If user filled in everything
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }
        $mysqli->set_charset('utf8');

        // Check if username already exists
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql_check = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password';";
        $results_check = $mysqli->query($sql_check);
        if ( !$results_check ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }
        $results_check_num = $results_check->num_rows;
        
        // When email exists
        if ($results_check_num == 1) {
            $_SESSION['login'] = true;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $_POST['password'];
            header('Location: search.php');
        }
        // When email doesn't exist
        else {
             $error = "Incorrect email or password.";
        }

    } 

}
// If logged in --> Search page
else {
    header('Location: search.php');
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">

    <!-- sign up modal style sheet -->
    <link rel="stylesheet" href="assets/css/sign_up.css">
    <title>Landing Page</title>

    <style>
        .selector-for-some-widget {
            box-sizing: content-box;
        }
        body {
          font-family: 'Muli', sans-serif;
        }
        #nav-container {
          height: 100px;
          /* margin-bottom: 100px; */
        }
        #logo-container {
          width: 200px;
          height: 80px;

          float: left;
          position: relative;
          top: 25px;
        }
        #logo-img {
          width: 100%;
          height: auto;
        }
        #login-container {
          float: right;

          position: relative;
          top: 40px;
        }
        .clearfloat {
          clear: both;
        }
        #header {
          /* margin-top: 100px; */
          height: 800px;

          position: relative;
        }
        #header-left {
          width: 40%;
          height: auto;

          float: left;
          position: absolute;
          left: 10%;
          top: 4%;
        }
        #header-left button {
          margin-top: 20px;
        }
        #header-right {
          width: 60%;
          height: auto;

          float: right;
        }

/* //////////////////////////////////////////////////// */
        /* make <h1> text size responsive */
        @media (min-width: 500px) {  
          h1, h3{font-size:1.4rem;} /*1rem = 16px*/
          #header {height: 280px;}
        }
        
        /* Medium devices (tablets, 768px and up) The navbar toggle appears at this breakpoint */
        @media (min-width: 768px) {  
          h1, h3 {font-size:2rem;} /*1rem = 16px*/
          #header { height: 500px;}
        }
        
        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) { 
          h1, h3 {font-size:2.5rem;} /*1rem = 16px*/
          #header { height: 550px; }
        }
        
        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {  
          h1 {font-size:3rem;} /*1rem = 16px*/  
          #header { height: 650px; }  
        }
        h3 {
          text-align: center;
          color: #A0D468;
        }
        .icon-container {
          width: 80px;
          height: 100px;
          margin-left: auto;
          margin-right: auto;
        }
        .icons {
          width: 100%;
          height: auto;
        }
        .captions {
          text-align: center;
          font-weight: bold;
        }
        .body-pic {
          width: 300px;
          height: 436px;
        }
        .body-pic img {
          width: 100%;
          height: auto;
        }
        h4 {
          color: #A0D468;
          font-weight: bold;
        }
        .col p {
          position: relative;
          top: 60px;
        }
        .col h4 {
          position: relative;
          top: 60px;
        }
        #footer {
          height: 50px;
          line-height: 50px;
          background-color: #A0D468;
          text-align: center;
        }
        /* #nav-container {
          position: relative;
          top: -30px;
        } */
    </style>
  </head>
  <body>
      <div id="nav-container" class="container mb-5">
        <div id="logo-container">
          <img id="logo-img" class="img-fluid" src="assets/img/homepage/logo.png" alt="logo">
        </div>

        <div id="login-container">
          <a href="sign-up.php"><button type="button" class="btn btn-outline-success" onclick="document.getElementById('id01').style.display='block'">Sign up</button></a>
          <a href="login.php"><button type="button" class="btn btn-success" onclick="document.getElementById('id02').style.display='block'">Log in</button></a>
        </div>
      </div>

      <div id="header" class="img-fluid container-fluid mt-5">
        <div id="header-left">
          <h1 class="$font-size-base mb-3">Keep track of your fridge to save money & eliminate food waste</h1>

          <a class="btn btn-success" href="index.php#saving" role="button" onclick="document.getElementById('id02').style.display='block'">START SAVING</a>
          
        </div>

        <div id="header-right">
          <img id="food" class="img-fluid" src="assets/img/homepage/food.png" alt="food">
        </div>

      </div>

    <div class="clearfloat"></div>

    <div class="container">
      <h3 id="saving" class="mt-5">How to get started?</h3>
      <div class="row mt-5">

        <div class="col">
          <div class="icon-container">
            <img class="icons" src="assets/img/homepage/harvest.png" alt="ingredients">
          </div>
          <div class="captions">Select Ingredients</div>
        </div>

        <div class="col">
          <div class="icon-container">
            <img class="icons" src="assets/img/homepage/shopping-list.png" alt="list">
          </div>
          <div class="captions">Add to Fridge List</div>
        </div>

        <div class="col">
          <div class="icon-container">
            <img class="icons" src="assets/img/homepage/bell.png" alt="bell">
          </div>
          <div class="captions">Receive Reminders</div>
        </div>

      </div>
    </div>

    <div class="container mt-5">
      <div class="row">
        <div class="col body-pic">
          <img src="assets/img/homepage/list.png" alt="list">
        </div>
        <div class="col">
          <h4>My Fridge</h4>
          <p>A clear display of ingredient name, quantity, expiration date and a calendar specified with expiring food on each day</p>
        </div>
        <div class="w-100"></div>
        <div class="col">
          <h4>Recipes</h4>
          <p>We curate recipe that are both delicious and easy-to-cook for your inspiration!</p>
        </div>
        <div class="col body-pic">
          <img src="assets/img/homepage/recipe.png" alt="recipe">
        </div>
        <div class="w-100"></div>
        <div class="col body-pic">
          <img src="assets/img/homepage/report.png" alt="report">
        </div>
        <div class="col">
          <h4>Reports</h4>
          <p>Food wastings, saving, goals...our reports feature helps you understanding your consuming habit and planning future saving</p>
        </div>
      </div>
    </div>

    <div class="container-fluid" id="footer">
      2020 &copy; University of Southern California
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Sign up modal -->
    <!-- <script>
      var modal = document.getElementById('id01');
      
      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }
      }
      </script> -->

<!-- Log in modal -->
    <!-- <script>
      var modal2 = document.getElementById('id02');
      
      window.onclick = function(event) {
          if (event.target == modal2) {
              modal2.style.display = "none";
          }
      }  -->
    </script>
  </body>
</html>