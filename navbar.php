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
    <link rel="stylesheet" href="assets/css/dashboard_stylesheet.css" />
    <link rel="stylesheet" href="assets/css/stylesheet.css" />

    <title></title>
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
            <ul class="list-group">
              <!-- SECTION 1 -->
              <div id="nav-header">
                <li class="nav-item toggle">
                  <h3 class="nav-link" href="#">
                    <a href="dashboard.php">
                    <img id="nav-logo" src="assets/img/logo.png" alt="Wasted logo" /></a>
                    <span id="wasted" class="desc">Wasted</span>

                  </h3>
                  <p>Hey <?php echo $row['user_firstname'];?>!</p>

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

                href="dashboard.php"

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

                href="fridge-list.php"

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
                href="add-ingredients.php"
              >
                <div
                  class="d-flex w-100 justify-content-start align-items-center"
                >
                  <span class="fa fa-utensils fa-fw mr-3"></span>
                  <span class="menu-collapsed">Add Ingredients</span>
                </div>
              </a>


             <!--  <a
                aria-expanded="false"
                class="list-group-item list-group-item-action flex-column align-items-start"
                style="background-color: #a0d468;"

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

                href="account_page.php"

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

                  <a id="nav-add-a" class="nav-link" href="information.php">

                    <img src="assets/img/question.png" alt="Add ingredients" />
                    <span class="desc toggle">Why Food Waste?</span>
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


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- <script src="assets/js/core.js"></script> -->

  </body>
</html>
