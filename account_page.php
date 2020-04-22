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

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"
    />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <link rel="stylesheet" href="assets/css/main.css" />

    <!-- sign up modal style sheet -->
    <link rel="stylesheet" href="assets/css/sign_up.css">

    <title>Account Page</title>

     <style>
            @import url("https://fonts.googleapis.com/css?family=Muli&display=swap");


            /* Account Page */
            h5 {
              /* display: block; */
              margin-top: 40px;
              margin-bottom: 40px;
            }
            /* #navbar {
              position: fixed;
              top: 0;
              bottom: 0;
              left: 0;

              background-color:#a0d468;
            } */
        </style>
  </head>
  <body>

  <?php include ('navbar.php'); ?>
    

        <!-- MAIN CONTENT FOR EACH PAGE -->

        <div class="col-md-10 offset-md-2 hidePadding">
          <div class="main-content add-ingredients">
            <div class="container-fluid main-content-header">

                  <h3>My Account</h3>

                  <!-- <div id="id02" class="modal"> -->
                      <!-- <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal"></span> -->
                      <!-- <form class="modal-content" action="/action_page.php"> -->
                        <div class="container">
                          <!-- <p>Please fill in this form to create an account.</p> -->
                
                          <hr>

                        <form action="edit_confirmation.php" method="POST">  
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">                    

                          <h5>Account Information</h5>

                          <!-- Pre-populate -->
                          <label for="name"><b>First Name</b></label>
                          <input type="text" placeholder="First Name" name="name" 
                          value="<?php echo $row['user_firstname']; ?>" required>

                          <label for="name"><b>Last Name</b></label>
                          <input type="text" placeholder="Last Name" name="name" 
                          value="<?php echo $row['user_lastname']; ?>" required>

                          <label for="email"><b>Email</b></label>
                          <input type="text" placeholder="Email" name="email" 
                          value="<?php echo $row['user_email']; ?>" required>

                          <h5>Account Password</h5>

                          <!-- Don't pre-populate -->
                          <label for="psw"><b>Current Password<span class="text-danger">*</span></b></label>
                          <input type="password" placeholder="Password" name="current_psw" required>

                          <label for="psw"><b>New Password<span class="text-danger">*</span></b></label>
                          <input type="password" placeholder="Password" name="new_psw" required>
                    
                          <div class="clearfix">
                            <button type="submit">Save</button>
                            <button type="reset">Reset</button>
                          </div>
                        </div>
                      </form>
                      
              </div> <!--END of MAIN-CONTENT-->

          </div> <!--END of HIDEPADDING-->
        </div>
      </div> <!--END of CONTAINER FLUID-->

             



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
