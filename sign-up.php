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

        #error{
          color: red;
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
          <button type="button" class="btn btn-outline-success" onclick="document.getElementById('id01').style.display='block'">Sign up</button>
          <a href="login.php"><button type="button" class="btn btn-success" onclick="document.getElementById('id02').style.display='block'">Log in</button></a>
        </div>
</div>
<div id="id01">
  <!-- <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal"></span> -->
  <form action="sign-up-confirmation.php" method="POST">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      

      <label for="name"><b>First Name</b></label>
      <input type="text" placeholder="Enter First Name" name="user_firstname" required>

      <label for="name"><b>Last Name</b></label>
      <input type="text" placeholder="Enter Last Name" name="user_lastname" required>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="user_email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="user_password" id="user_password" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="confirm_password" id="confirm_password" required>

      <span id="error"></span>

      <script>

       document.querySelector('form').onsubmit = function(){ 

        var valid = true

        var password = document.querySelector("#user_password").value;
        var confirm_password = document.querySelector("#confirm_password").value;

        if(password != confirm_password){
          document.querySelector("#error").innerHTML = "The passwords do not match."
          valid = false;
        }

        return valid;
      }

      </script>


        

      <!-- <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label> -->

      <div class="clearfix">
        <a href="index.php"><button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button></a>
        <button type="submit" class="signup">Sign Up</button>
      </div>
    </div>
  </form>
</div>

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