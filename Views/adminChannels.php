<?php
require_once '../Controller/DBController.php';
session_start();
if (isset($_SESSION['admin'])) {
  $db = new DBController();
  $db->startConnection();
  $qry = "SELECT * FROM channel";
  $result = $db->select($qry);
  $db->closeConnection();
  if (isset($_POST['LogOutBtn'])) {
    header("Location: ./index.php");
    session_destroy();
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ZesTube Admin</title>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>

  <body>
    <div class="container-scroller">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <h5>Zes<span class="text-danger">Tube</span></h5>
        </div>
        <ul class="nav">
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="./adminUsers.php">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="./adminChannels.php">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Channels</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="./adminVideos.php">
              <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
              </span>
              <span class="menu-title">Videos</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="./videosReported.php">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
              <span class="menu-title">Reported Videos</span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <nav class="navbar p-0 fixed-top d-flex flex-row">

          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>

            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="uploads/profilePics/Default-Profile-Pic.png" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Admin</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu ">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <a class="dropdown-item preview-item">
                    <form method="post">
                      <input type="submit" value="Log Out" class="btn btn-outline-danger btn-lg" name="LogOutBtn">
                    </form>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Channels</h4>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th> Channel ID </th>
                        <th> Channel Name </th>
                        <th> User ID</th>
                        <th> Date Created </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['channel_ID'] . "</td>";
                        echo "<td>" . $row['channelName'] . "</td>";
                        echo "<td>" . $row['user_ID'] . "</td>";
                        echo "<td>" . $row['DateCreated'] . "</td>";
                        echo "<td>
                                  <button type='button' class='btn btn-outline-danger btn-rounded btn-fw'><a class='text-light' href='./delete.php?channel_ID=" . $row['channel_ID'] . "' style='text-decoration:none;'>Delete</a></button>
                                </td>";
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="assets/vendors/js/vendor.bundle.base.js"></script>
      <script src="assets/vendors/chart.js/Chart.min.js"></script>
      <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
      <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
      <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
      <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
      <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
      <script src="assets/js/off-canvas.js"></script>
      <script src="assets/js/hoverable-collapse.js"></script>
      <script src="assets/js/misc.js"></script>
      <script src="assets/js/settings.js"></script>
      <script src="assets/js/todolist.js"></script>
      <script src="assets/js/dashboard.js"></script>
  </body>

  </html>
<?php
} else {
  echo '<script>
  alert("Access denied");
  </script>';
  echo "<script>setTimeout(\"location.href = './index.php';\");</script>";

}

?>