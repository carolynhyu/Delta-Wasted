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

            body {
            font-family: "Muli", sans-serif;
            background-color: #ccc;
            color: #fff;
            }
            p {
            color: #fff;
            font-size: 0.9em;
            padding-left: 10px;
            padding-top: 10px;
            }
            li {
            list-style: none;
            }
            #nav-header {
            padding-top: 30px;
            padding-left: 30px;
            }
            /*span#collapse-icon.fa.fa-2x.mr-3.fa-angle-double-left {
            margin-left: 15px;
            }
            */
            h3.nav-link {
            margin: 0;
            color: #fff;
            padding: 0;
            }
            .nav-item h3 {
            color: #fff;
            }
            .nav-item p {
            color: #fff;
            font-size: 0.9em;
            font-family: "Muli";
            }
            .nav-item a {
            color: #fff;
            transition: all 1s;
            }
            .nav-item a:hover {
            transition: all 1s;
            color: #ccc;
            }
            #nav-logo {
            width: 35px;
            margin-right: 5px;
            }
            #arrow {
            position: absolute;
            left: 180px;
            top: 38px;
            width: 20px;
            }

            /*JS addClasses*/
            .hide {
            display: none;
            }
            .nav-size {
            width: 60px;
            }
            .toggle {
            display: inline-block;
            }

            #body-row {
            margin-left: 0;
            margin-right: 0;
            }
            #sidebar-container {
            min-height: 100vh;
            background-color: #a0d468;
            padding: 0;
            position: relative;
            }

            #sidebar-container .list-group a {
            /*background-color: #a0d468;*/
            color: #fff;
            height: 50px;
            }
            a.list-group-item.list-group-item-action {
            border: 0px;
            padding-left: 20px;
            }

            /* Sidebar sizes when expanded and expanded */
            .sidebar-expanded {
            width: 100%;
            }
            .sidebar-collapsed {
            width: 60px;
            }

            /* Submenu item*/
            #sidebar-container .list-group .sidebar-submenu a {
            height: 45px;
            padding-left: 30px;
            }
            .sidebar-submenu {
            font-size: 0.9rem;
            }

            #dashboard {
            margin-top: 60px;
            }
            #my-acct {
            margin-top: 140px;
            }

            /* nav footer */
            div#nav-add {
            background-color: #fff;
            position: absolute;
            bottom: 0;
            width: 230px;
            border-radius: 10% 10% 0 0;
            padding-top: 3%;
            }
            #nav-add li#nav-add-li.nav-item {
            background-color: #fff !important;
            }
            li.nav-item #nav-add-a .desc {
            color: #a0d468;
            }
            li.nav-item img {
            width: 30px;
            margin-right: 10%;
            }

            .container-fluid,
            .col-md-2,
            .col-md-10 {
            padding: 0px !important;
            }

            .container-fluid,
            .col-md-2,
            .col-md-10,
            .hidePadding {
            padding: 0px !important;
            }

            .row {
            margin: 0px !important;
            }

            .main-content {
            padding: 5%;
            background: #f5f5f5;
            min-height: 100vh;
            }

            .sidebar-outer {
            position: absolute !important;
            z-index: 99;
            }
            #nav {
                float: left;
            }
            #main-con {
                float: right;
            }
            .main-content{
                color: black;
            }
            .clearfix button {
                width: 100px;
            }

            /* Account Page */
            h5 {
              /* display: block; */
              margin-top: 40px;
              margin-bottom: 40px;
            }
            #navbar {
              position: fixed;
              top: 0;
              bottom: 0;
              left: 0;

              background-color:#a0d468;
            }
        </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 sidebar-outer">
          <div
            id="sidebar-container"
            class="sidebar-expanded d-none d-md-block"
          >
            <!-- Bootstrap List Group -->
            <ul id="navbar" class="list-group">
              <!-- SECTION 1 -->
              <div id="nav-header">
                <li class="nav-item toggle">
                  <h3 class="nav-link" href="#">
                    <img id="nav-logo" src="assets/img/logo.png" alt="Wasted logo" />
                    <span id="wasted" class="desc">Wasted</span>
                  </h3>
                  <p>Hey Sara!</p>

                  <!-- <a id="arrow-a" href="#">
                    <div id="arrow-container">
                      <img id="arrow" src="img/arrow.png" alt="arrow">
                    </div>
                  </a> -->
                </li>

                <!-- <div>
                    <p class="toggle">Hey Sara!</p>
                </div> -->
              </div>
              <!-- nav header -->

             <a
                href="#top"
                data-toggle="sidebar-collapse"
                class="list-group-item list-group-item-action d-flex align-items-center"
                style="background-color: #a0d468;"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <!-- <h3 class="nav-link toggle" href="#">
                                <img id="nav-logo" src="img/logo.png" alt="Wasted logo">
                                <span id="wasted" class="desc">Wasted</span>
                            </h3> -->
                  <span
                    id="collapse-icon"
                    class="fa fa-angle-double-left fa-2x mr-3"
                  ></span>
                  <span id="collapse-text" class="menu-collapsed"
                    >Collapse</span
                  >
                </div>
              </a>

              <!-- SECTION 2 -->
              <a
                aria-expanded="false"
                class="list-group-item list-group-item-action flex-column align-items-start"
                id="dashboard"
                style="background-color: #a0d468;"
                href="dashboard.html"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <span class="fa fa-home fa-fw mr-3"></span>
                  <span class="menu-collapsed">Dashboard</span>
                </div>
              </a>

              <a
                aria-expanded="false"
                class="list-group-item list-group-item-action flex-column align-items-start"
                style="background-color: #a0d468;"
                href="fridge-list.html"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <span class="fa fa-igloo fa-fw mr-3"></span>
                  <span class="menu-collapsed">Fridge</span>
                </div>
              </a>

              <a
                aria-expanded="false"
                class="list-group-item list-group-item-action flex-column align-items-start"
                style="background-color: #a0d468;"
                href="#"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <span class="fa fa-utensils fa-fw mr-3"></span>
                  <span class="menu-collapsed">Recipes</span>
                </div>
              </a>

              <!-- <a
                aria-expanded="false"
                class="list-group-item list-group-item-action flex-column align-items-start"
                style="background-color: #a0d468;"
                href="#"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <span class="fa fa-dashboard fa-fw mr-3"></span>
                  <span class="menu-collapsed">Reports</span>
                </div>
              </a> -->

              <!-- SECTION 3 -->
              <a
                aria-expanded="false"
                class="list-group-item list-group-item-action flex-column align-items-start"
                id="my-acct"
                style="background-color: #a0d468;"
                href="account_page.html"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <span class="fa fa-user fa-fw mr-3"></span>
                  <span class="menu-collapsed">My Account</span>
                </div>
              </a>

              <a
                aria-expanded="false"
                class="list-group-item list-group-item-action flex-column align-items-start"
                style="background-color: #a0d468;"
                href="logout.php"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <span class="fas fa-sign-out-alt fa-fw mr-3"></span>
                  <span class="menu-collapsed">Log Out</span>
                </div>
              </a>
              <!-- ????? -->

              <!-- add ingredients -->
              <div id="nav-add">
                <li class="nav-item" id="nav-add-li">
                  <a id="nav-add-a" class="nav-link" href="add-ingredients.html">
                    <img src="assets/img/plus.png" alt="Add ingredients" />
                    <span class="desc toggle">Add Ingredient</span>
                  </a>
                </li>
              </div>
              <!-- nav-add  -->
            </ul>
            <!-- List Group END-->
          </div>
          <!-- sidebar-container  END -->
          <!-- MAIN -->
        </div>

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
