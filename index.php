<?php
session_start();
require_once "config/local_db.php";

if (!isset($_SESSION['UserName'])) {
    header("Location: login.php");
    exit();
}

$User = $_SESSION['UserName'];

try {
    $ua = $conn->prepare("
        SELECT
            ua.UserName,
            ua.Role,
            ua.Position
        FROM usr ua
        WHERE ua.UserName = ?
    ");
    $ua->execute([$User]);
    $user = $ua->fetch(PDO::FETCH_ASSOC);

    // Allow only SA
    if (!$user || strtoupper($user['Role']) !== 'SA') {
        $_SESSION = [];
        session_destroy();
        header("Location: login.php");
        exit();
    }

} catch (PDOException $e) {
    // Better to log instead of showing DB details
    error_log("Database Error: " . $e->getMessage());
    header("Location: error.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>iQuote</title>
	 <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/plugins/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-lite.min.css">
  <link rel="stylesheet" href="assets/plugins/datepicker/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
	<link rel="icon" href="assets/image/icon/logo.png">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand bg-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item text-info">
                    <a href="#" class="nav-link text-center">
                        <i class="bi bi-clock ml-4"></i>
                        <strong class="ml-2">
                            <span id="clock"></span>
                            <input type="hidden" id="clockvalue">
                        </strong>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-info elevation-5">
            <p class="text-center brand-link">
                <a href="index.php" style="text-decoration: none; color: inherit;">
                    <img src="assets/image/icon/logo.png" alt="User Logo" id="profile-image"style="width: 100px; height: 100px; object-fit: cover;">
                    <br>
                </a>
                <br>
            </p>
            <div class="sidebar">
                <nav id="main-menu" class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <!-- MAIN -->
                    <li class="nav-item px-3 mt-2 mb-1">
                      <small class="text-uppercase text-muted fw-bold">Main</small>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link active" name="menu" menucode="dashboard">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                      </a>
                    </li>

                    <!-- ORGANIZATION -->
                    <li class="nav-item px-3 mt-3 mb-1">
                      <small class="text-uppercase text-muted fw-bold">Controls</small>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="branch">
                        <i class="nav-icon bi bi-building"></i>
                        <p>Branch</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="contacts">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Contacts</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="bank">
                        <i class="nav-icon bi bi-bank"></i>
                        <p>Banks</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="termspolicy">
                        <i class="nav-icon bi bi-calendar-check"></i>
                        <p>Payment Terms</p>
                      </a>
                    </li>

                    <!-- DOCUMENTS -->
                    <li class="nav-item px-3 mt-3 mb-1">
                      <small class="text-uppercase text-muted fw-bold">Documents</small>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="pdfheaders">
                        <i class="nav-icon bi bi-upload"></i>
                        <p>PDF Header</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="policycontrol">
                        <i class="nav-icon bi bi-clipboard2-check"></i>
                        <p>Policy Control</p>
                      </a>
                    </li>

                    <!-- SYSTEM -->
                    <li class="nav-item px-3 mt-3 mb-1">
                      <small class="text-uppercase text-muted fw-bold">System</small>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="accounts">
                        <i class="nav-icon bi bi-person-gear"></i>
                        <p>User Accounts</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="#" class="nav-link" name="menu" menucode="settings">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Settings</p>
                      </a>
                    </li>

                    <!-- DIVIDER -->
                    <li class="nav-item mt-3 mb-1">
                      <hr class="text-secondary">
                    </li>

                    <!-- LOGOUT -->
                    <li class="nav-item">
                      <a href="#" class="nav-link" onclick="logoutAdmin()">
                        <i class="nav-icon bi bi-box-arrow-right text-danger"></i>
                        <p class="text-danger">Logout</p>
                      </a>
                    </li>

                  </ul>
                </nav>
            </div>
        </aside>
    </div>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4 class="m-0 text-bold" id="main-title"></h4>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid" id="main-content"></div>
      </section>
    </div>
    <footer class="main-footer">
        <small>Imperial Appliance Plaza. All rights reserved.</small>
        <span id="current-year"></span>
        <div class="float-right d-none d-sm-inline-block">
        </div>
    </footer>
</div>


<?php include 'modal.php';  ?>


<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>
<script src="assets/plugins/chart.js/Chart.min.js"></script>
<script src="assets/js/adminlte.js"></script>
<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/summernote/summernote-lite.min.js"></script>
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="assets/plugins/datatables/datatables.min.js"></script>
<script src="assets/plugins/elevatezoom-plus-master/src/jquery.ez-plus.js"></script>
<script src="assets/plugins/datepicker/jquery-ui.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="assets/js/switch.js"></script>
</body>
</html>


