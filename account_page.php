<?php

  require "config/config.php";

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ( $mysqli->connect_errno ) {
    echo $mysqli->connect_error;
    exit();
  }

  $mysqli->set_charset('utf8');

?>

<!DOCTYPE html>
<html>
  <head>
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
        </style>
  </head>
  <body>
      <?php include 'navbar.html'; ?>

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
                          <label for="name"><b>First Name</b></label>
                          <input type="text" placeholder="First Name" name="name" required>

                          <label for="name"><b>Last Name</b></label>
                          <input type="text" placeholder="Last Name" name="name" required>

                          <label for="email"><b>Email</b></label>
                          <input type="text" placeholder="Email" name="email" required>
                    
                          <label for="psw"><b>Password</b></label>
                          <input type="password" placeholder="Password" name="psw" required>

                    
                    
                          <div class="clearfix">
                            <button>Edit</button>
                            <button>Save</button>
                          </div>
                        </div>
                      
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
