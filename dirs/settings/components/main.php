<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
  <div class="p-4 shadow bg-white" style="max-width: 400px; width: 100%;">
	<h4 class="text-center text-muted mb-4">Account Security</h4>

    <div class="form-floating mb-3">
      <input type="password" name="create-newpassword" id="create-newpassword" class="form-control rounded-0" placeholder="New Password">
      <label for="create-newpassword">New Password</label>
      <small class="text-muted">Make sure both password are matched.</small>
    </div>
    <div class="form-floating mb-2">
      <input type="password" name="confirm-password" id="confirm-password" class="form-control rounded-0" placeholder="Confirm Password">
      <label for="confirm-password">Confirm Password</label>
    </div>
    <small class="text-danger d-none" id="error-message"></small>
    <div class="form-check d-flex justify-content-end mb-3">
      <input class="form-check-input" type="checkbox" id="toggle-show-password" onclick="showBothPasswrd()">
      <label class="form-check-label text-muted ms-2" for="toggle-show-password">
        Show Password
      </label>
    </div>
    <div class="d-grid">
      <button class="btn btn-outline-secondary mb-2 btn-lg rounded-0" type="buttton" onclick="updatePassword()">
        Apply
      </button>
      <button class="btn btn-danger btn-lg rounded-0 text-white" type="buttton" onclick="clearInputs()">
        Clear
      </button>
    </div>
  </div>
</div>

<script>
	function showBothPasswrd() {
	  var passwordInputs = $("#create-newpassword, #confirm-password");
	  var isPassword = passwordInputs.first().attr("type") === "password";
	  passwordInputs.attr("type", isPassword ? "text" : "password");
	}
</script>