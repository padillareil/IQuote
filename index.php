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
<body class="hold-transition sidebar-mini layout-fixed bg-primary-subtle">
  <div class="wrapper d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg py-2 shadow bg-primary">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#main-menu" aria-controls="main-menu" 
                aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-menu">
          <ul class="navbar-nav me-auto nav-underline">
            <li class="nav-item"><a class="nav-link text-white active" href="#" name="menu" menucode="dashboard">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="accounts">Accounts</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="branch">Branch</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="bank">Banks</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="policycontrol">Policy</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="termspolicy">Payment Term</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="pdfheaders">PDF Header</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="contacts">Contacts</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="settings">Settings</a></li>
          </ul>
          <div class="d-flex align-items-center">
            <a href="#" class="text-white text-decoration-none" onclick="Logout()">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </div>
        </div>
      </div>
    </nav>
  

    <!-- MAIN CONTENT AREA -->
    <div class="d-flex flex-grow-1">
      <div class="content-wrapper flex-grow-1">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end" id="main-breadcrumb">
                </ol>
              </div>
            </div>
          </div>
        </div>

        <section class="content d-flex justify-content-center align-items-center">
          <div class="container-fluid" id="main-content">
          </div>
        </section>
      </div>
    </div>
  </div>

  <div class="container">
    <footer class="py-3 my-4">
      <p class="text-center text-body-secondary">&copy; Vic Imperial Appliance Corporation. All rights reserved.</p>
    </footer>
  </div>


<?php include 'modal.php';  ?>


<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>
<script src="assets/plugins/chart.js/Chart.min.js"></script>
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


