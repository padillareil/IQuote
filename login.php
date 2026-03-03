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
	<link rel="icon" href="assets/image/icon/logo.png">
</head>
<body>

	<form id="frm-login">
	  <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
	    <div class="p-4 shadow bg-white" style="max-width: 400px; width: 100%;">
	      <div class="d-flex justify-content-center mb-1">
	        <img src="assets/image/icon/logo.png" alt="iQuote Logo" style="border-radius: 50%; height: 150px; width: 150px;">
	      </div>
	      <div class="text-center mb-2">
	        <h3 class="text-danger">iQuote</h3>
	        <small>Version 2.0</small>
	      </div>
	      <div class="form-floating mb-3">
	          <input type="text" name="user-username" id="user-username" class="form-control rounded-0" placeholder="Username" required autocomplete="off">
	          <label for="user-username">Username</label>
	      </div>

	      <div class="form-floating mb-2">
	          <input type="password" name="user-password" id="user-password" class="form-control rounded-0" placeholder="Password" required autocomplete="off">
	          <label for="user-password">Password</label>
	      </div>
	      <div id="login-error" class="text-danger small mt-2 d-none">
	          Invalid username or password.
	      </div>
	      <div class="form-check d-flex justify-content-end mb-3">
	        <input class="form-check-input" type="checkbox" id="toggle-show-password" onclick="togglePassword()">
	        <label class="form-check-label text-muted ms-2" for="toggle-show-password">
	          Show Password
	        </label>
	      </div>
	      <div class="d-grid">
	        <button class="btn btn-danger btn-lg rounded-0 text-white" type="submit">
	          Log In
	        </button>
	      </div>
	      <!-- <div class="form-check d-flex justify-content-end mt-3">
	        <input class="form-check-input" type="checkbox" id="keep-signed-in">
	        <label class="form-check-label text-muted ms-2" for="keep-signed-in">
	          Keep me signed in
	        </label>
	      </div> -->
	      <div class="mt-2 mb-3 text-center">
	        <a href="#" class="text-secondary" onclick="contactSoftDev()">Forgot Password.</a>
	      </div>
	    </div>
	  </div>
	</form>


	

<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>
<script src="assets/plugins/chart.js/Chart.min.js"></script>
<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/summernote/summernote-lite.min.js"></script>
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="assets/plugins/elevatezoom-plus-master/src/jquery.ez-plus.js"></script>
<script src="assets/plugins/datepicker/jquery-ui.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>


<script>
	function togglePassword() {
	    const passwordField = document.getElementById('user-password');
	    const checkbox = document.getElementById('toggle-show-password');
	    passwordField.type = checkbox.checked ? 'text' : 'password';
	}

	function contactSoftDev() {
		$("#mdl-forgot-password").modal("show")
	}
	/*Remove invalid danger upon on type*/
	$("#user-username, #user-password").on("input", function () {
	    $(this).removeClass("input-error");
	    $("#login-error").addClass("d-none");
	});
</script>

<!-- Modal Forgot Password -->
<div class="modal fade" id="mdl-forgot-password" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Please contact Software Development Department for account recovery assistance, or call <br> <a href="#">0967-302-5163.</a></p>
      </div>
    </div>
  </div>
</div>



<style>
.input-error {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
}
</style>