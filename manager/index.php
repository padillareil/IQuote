<?php
session_start();
require_once "../config/local_db.php";

if (!isset($_SESSION['UserName'])) {
    header('Location: ../login.php');
    exit();
}
$User = $_SESSION['UserName'];

try {
    $ua = $conn->prepare("
        SELECT
            ua.UserName,
            ua.Role,
            ua.Bcode

          
        FROM
            usr ua
        WHERE ua.UserName = ?
    ");
    $ua->execute([$User]);
    $user = $ua->fetch(PDO::FETCH_ASSOC);

    /*Validate User role*/
    if (
        !$user || 
        ($user['Role'] !== 'Admin' && $user['Role'] !== 'ONLN')
    ) {
        session_destroy();
        header("Location: ../login.php");
        exit();
    }




} catch (PDOException $e) {
    echo "<b>Database Error:</b> " . htmlspecialchars($e->getMessage());
    exit(); 
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>iQuote</title>
	<link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="../assets/plugins/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" href="../assets/plugins/toastr/toastr.min.css">
	<link rel="stylesheet" href="../assets/plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="../assets/plugins/summernote/summernote-lite.min.css">
	<link rel="stylesheet" href="../assets/plugins/datepicker/jquery-ui.structure.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">
	<link rel="icon" href="../assets/image/icon/logo.png">
</head>
<body class="hold-transition sidebar-mini layout-fixed bg-primary-subtle">
  <div class="wrapper d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg py-2 navbar-dark" style="background-color: #00008B;">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
        <!-- <span class="ms-2 fw-semibold">i<span class="text-danger fs-4">Q</span>uote</span> -->
        <img src="../assets/image/icon/iapwhite.png" style="height: 8vh; width: 8vh;">
        </a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" 
                data-bs-target="#main-menu" aria-controls="main-menu" 
                aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-menu">
          <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link active text-white" href="#" name="menu" menucode="home">Form</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="quotations">Inbox</a></li>
            
            <!-- For Creating Account for branches base on the mother details -->
             <li id="nav-account" class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="allocate">Accounts</a></li>

             <!-- For Creating Account for branches asignment base on the seletected details -->
              <li id="nav-allocate" class="nav-item d-none" ><a class="nav-link text-white" href="#" name="menu" menucode="accounts">Accounts</a></li>

            <li class="nav-item"><a class="nav-link text-white" href="#" name="menu" menucode="settings">Settings</a></li>
          </ul>
          <div class="d-flex align-items-center">
            <a href="#" class="text-white text-decoration-none" onclick="clientLogout()">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </div>
        </div>
      </div>
    </nav>
  
  <!-- For condition of the navbar -->
  <input type="hidden" id="user-role" value="<?php echo $user['Role']; ?>">

  <!-- PAgination parameter -->
<input type="hidden" id="bcode-paramter" value="<?php echo $user['Bcode']; ?>">
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
    <footer class="">
      <p class="text-center text-body-secondary">&copy; Vic Imperial Appliance Corporation. All rights reserved.</p>
    </footer>
  </div>


<?php include '../modal.php';  ?>


<script src="../assets/jquery/jquery.min.js"></script>
<script src="../assets/plugins/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../assets/plugins/toastr/toastr.min.js"></script>
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<script src="../assets/plugins/moment/moment.min.js"></script>
<script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="../assets/plugins/summernote/summernote-lite.min.js"></script>
<script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../assets/plugins/datatables/datatables.min.js"></script>
<script src="../assets/plugins/elevatezoom-plus-master/src/jquery.ez-plus.js"></script>
<script src="../assets/plugins/datepicker/jquery-ui.min.js"></script>
<script src="../assets/js/scripts.js"></script>
<script src="script/switch.js"></script>
</body>



<!-- <script>
  function testNotify() {
    $("#liveToast").toast("show");
  }
</script> -->


<!-- <div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div> -->
<!-- Toast Container Approved (bottom-right) -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
  <div id="liveToast" class="toast bg-light border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex align-items-center justify-content-between">
      <div class="toast-body d-flex">
        <i class="bi bi-check-circle text-lg text-success me-2 fs-4"></i>
        <div>
          <div class="fw-bold">Approved</div>
          <small class="fs-bold">REF. NUMBER: <span id="quotation-id"></span></small>
          <br>
          <small class="text-muted">APPROVED BY: <span id="approver-user"></span></small>
        </div>
      </div>
      
      <!-- Close Button -->
      <button type="button" class="btn-close ms-3 me-2" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>



<!-- Modal logout prompt -->
<div class="modal fade" id="mdl-logout-dialog" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">You do not have permission to access this page. Please contact Merruel Tuvida for assistance.</p>
      </div>
      <input type="hidden" id="del-branch">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger me-2" onclick="clientLogout()">OK</button>
      </div>
    </div>
  </div>
</div>