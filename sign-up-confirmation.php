<?php

    require 'config/config.php';

    if ( !isset($_POST['user_email']) || empty($_POST['user_email'])
        || !isset($_POST['user_firstname']) || empty($_POST['user_firstname'])
        || !isset($_POST['user_lastname']) || empty($_POST['user_lastname'])
        || !isset($_POST['user_password']) || empty($_POST['user_password'])
        || !isset($_POST['confirm_password']) || empty($_POST['confirm_password']))
        {
        $error = "Please fill out all required fields.";
        } 
      else if ($_POST['confirm_password'] != $_POST['confirm_password']){
        $error = "passwords dont match";
      }

else {
  // All fields provided.

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $user_email = $mysqli->escape_string( $_POST['user_email'] );
  $user_firstname = $mysqli->escape_string( $_POST['user_firstname'] );
  $user_lastname = $mysqli->escape_string( $_POST['user_lastname'] );
  $user_password = $mysqli->escape_string( $_POST['user_password'] );

  $sql_user = "SELECT *
              FROM users
              WHERE user_email = '$user_email';";

  $results_user = $mysqli->query($sql_user);

  if (!$results_user) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
  }

  // if we founds some rows, means username is taken.
  if ( $results_user->num_rows > 0 ) {
    $error = "Email is already registered.";
  } else {
    // Username & email are available.
    $sql = "INSERT INTO users (user_email, user_firstname, user_lastname, user_password)
    VALUES ('$user_email', '$user_firstname', '$user_lastname', '$user_password');";

    $results = $mysqli->query($sql);

    if (!$results) {
      echo $mysqli->error();
      $mysqli->close();
      exit();
    }
  }

  $mysqli->close();
}

   
?>

<!DOCTYPE html>
<html>
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
         <a href="index.php"> <img id="logo-img" class="img-fluid" src="assets/img/homepage/logo.png" alt="logo"></a>
        </div>

        <div id="login-container">
          <button type="button" class="btn btn-outline-success" onclick="document.getElementById('id01').style.display='block'">Sign up</button>
          <a href="login.php"><button type="button" class="btn btn-success" onclick="document.getElementById('id02').style.display='block'">Log in</button></a>
        </div>
</div>
<div id="id01">
  <!-- <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal"></span> -->
  
    <div class="container">

       <h1>Sign Up Confimation</h1>

    <div class="row mt-4">
      <div class="col-12">
        <?php if ( isset($error) && !empty($error) ) : ?>
          <div class="text-danger"><?php echo $error; ?></div>
        <?php else : ?>
          <div class="text-success"><?php echo $user_firstname; ?> was successfully registered.</div>
        <?php endif; ?>
    </div> <!-- .col -->
  </div> <!-- .row -->

  <div class="row mt-4 mb-4">
    <div class="col-12">
      <a href="login.php" role="button" class="btn btn-primary">Login</a>
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
    </div> <!-- .col -->
  </div> <!-- .row -->

</div> <!-- .container -->

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