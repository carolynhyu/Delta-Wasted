<?php

require "config/config.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ( $mysqli->connect_errno ) {
  echo $mysqli->connect_error;
  exit();
}

$mysqli->set_charset('utf8');

//save form input into session variables
$email = $_SESSION['user_email'];
$password = $_SESSION['user_password'];

//retrieve the row of info which is user selected
$sql_user = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password';";
$results_user = $mysqli->query($sql_user);

//print_r($results_user);

if ( $results_user->num_rows <=0 ) {
    echo "Can't find user, please login first";
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
  <!-- Hotjar Tracking Code for http://460.itpwebdev.com/~bo/-daizhuwu -->
<script>
(function(h,o,t,j,a,r){
    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
    h._hjSettings={hjid:1752462,hjsv:6};
    a=o.getElementsByTagName('head')[0];
    r=o.createElement('script');r.async=1;
    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
    a.appendChild(r);
})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
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

  <!-- sign up modal style sheet -->
  <link rel="stylesheet" href="assets/css/sign_up.css">

  <title>Information Page</title>

   <style>
        @import url("https://fonts.googleapis.com/css?family=Muli&display=swap");

        h3 {
            color: #A0D468 !important; 
        }
        #container-paragraph p {
            color: black !important; 
        }
        #container-paragraph {
            float: left;
            width: 50%;
        }
        .paragraph {
            margin-top: 10%;
        }
        #container-img {
            width: 50%;
            height: 50%;
            float: right;
        }
        #container-img img {
            width: 100%;
            height: auto;
            float: right;
        }
      </style>
</head>
<body>

<?php include ('navbar.php'); ?>
  

      <!-- MAIN CONTENT FOR EACH PAGE -->

      <div class="col-md-10 offset-md-2 hidePadding">
        <div class="main-content add-ingredients">
          <div class="container-fluid main-content-header">

                <!-- <h3>My Account</h3> -->

                    <div id="container-paragraph">  
                        <div class="paragraph">
                            <h3>Food Waste in Households</h3>
                            <p>America produces around 125 to 160 billion pounds of food waste every year, and among them approximately 40 to 50 percent happen on a consumer level. With food spoilage take up over two thirds of household food waste, preventative measures such as increasing visibility of ingredients in refrigerators and effective planning are necessary to be taken.</p>
                        </div>             

                        <div class="paragraph">
                            <h3>Our Mission</h3>
                            <p>Among several macro-level drivers of food waste in America, one of them is turning consumer awareness into action. To eliminate food waste and to raise consumer awareness about food waste, we created Wasted as a tool that enables food saving practices and ingredients tracking service, together creating a more sustainable environment at a larger scope.</p>
                        </div>
                    </div>          

                    <div id="container-img">
                        <div id="img-container">
                            <img src="assets/img/information.png" alt="information">
                        </div>
                    </div>

          </div><!--END of CONTAINER FLUID-->
        </div> <!--END of MAIN CONTENT-->
      </div> <!--END of HIDE PADDING--> 




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
  <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>  
  <script src="assets/js/core.js"></script>
  

</body>
</html>
