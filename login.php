<?php



require 'config/config.php';
// If not logged in
if ( !isset( $_SESSION['login'] ) || empty( $_SESSION['login'] ) ) {

    // If user tried logging in, check if everything is filled
    if ( !isset( $_POST['user_email'] ) || empty($_POST['user_email']) || !isset( $_POST['user_password'] ) || empty($_POST['user_password']) ) {
            $error = "Please fill out email and password.";
    }
    else {
        // If user filled in everything
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }
        $mysqli->set_charset('utf8');

        // Check if user_email already exists
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        $sql_check = "SELECT * FROM users WHERE user_email='$user_email' AND user_password='$user_password';";
        $results_check = $mysqli->query($sql_check);
        if ( !$results_check ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        $results_check_num = $results_check->num_rows;
        
        // When user_email exists
        if ($results_check_num == 1) {
            $_SESSION['login'] = true;
            $_SESSION['user_email'] = $_POST['user_email'];
            $_SESSION['user_password'] = $_POST['user_password'];
            header('Location: dashboard.php');
        }
        // When user_email doesn't exist
        else {
             $error = "Incorrect email or password.";
        }

    } 

}
// If logged in --> Dashboard page
else {
    header('Location: dashboard.php');
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
    <title>Wasted</title>

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
          <a href="index.php"><img id="logo-img" class="img-fluid" src="assets/img/homepage/logo.png" alt="logo"></a>
        </div>

        <div id="login-container">
         <a href="sign-up.php"> <button type="button" class="btn btn-outline-success" onclick="document.getElementById('id01').style.display='block'">Sign up</button></a>
          <a href="login.php"><button type="button" class="btn btn-success" onclick="document.getElementById('id02').style.display='block'">Log in</button></a>
        </div>
</div>
<div id="id02">
 <!--  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal"></span> -->
  <form  action="login.php" method="POST">
    <div class="container">
      <h1>Log In</h1>
      <!-- <p>Please fill in this form to create an account.</p> -->
      <hr>

      <div>
         <?php if( isset($error) && !empty($error)) {
              echo $error;
          }?>
          <br>
          <br>
      </div>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="user_email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="user_password" required>

      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

    <!-- <p>Don't have an account? <button type="button" onclick="document.getElementById('id01').style.display='block'">Sign up</button></p> -->
    <p>Don't have an account? <span></span><a href="sign-up.php" onclick="document.getElementById('id02').style.display='none'; document.getElementById('id01').style.display='block'">Sign up</a></p>


      <div class="clearfix">
        <a href="index.php"><button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button></a>
        <button type="submit" class="signup">Log In</button>
      </div>
    </div>
  </form>
</div>


 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </script>
</body>
</html>