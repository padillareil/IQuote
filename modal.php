<div id="gen-spinner" hidden>
  <div class="d-flex justify-content-center" hidden>
    <div class="spinner-border" role="status">
      <span class="visually-hidden"></span>
    </div>
  </div>
</div>
<div id="gen-btn-spinner" class="justify-content-center" hidden>
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="visually-hidden"></span>
</div>
<script>
  /*Logout*/
  function logoutAccount() {
    $("#logout-modal").modal("show");
  }



  function gen_spinner(spinnersize, spinnerclass){

    // // spinner-border-xs
    // // spinner-border-sm
    // // spinner-border-md
    // // spinner-border-lg
    // // spinner-border-xl
    $("#gen-spinner").find("div[name='spinner-holder']")
    .removeClass("text-primary")
    .removeClass("text-secondary")
    .removeClass("text-success")
    .removeClass("text-danger")
    .removeClass("text-warning")
    .removeClass("text-info")
    .removeClass("text-light")
    .removeClass("text-dark")
    .removeClass("spinner-border-xs")
    .removeClass("spinner-border-sm")
    .removeClass("spinner-border-md")
    .removeClass("spinner-border-lg")
    .removeClass("spinner-border-xl")
    $("#gen-spinner").find("div[name='spinner-holder']")
    .addClass(spinnersize)
    .addClass(spinnerclass);
    return $("#gen-spinner").html();
  }
  function gen_btn_spinner(spinnersize, spinnerclass){
    // spinner-border-xs
    // spinner-border-sm
    // spinner-border-md
    // spinner-border-lg
    // spinner-border-xl
    $("#gen-btn-spinner").find("div[name='spinner-holder']")
    .removeClass("text-primary")
    .removeClass("text-secondary")
    .removeClass("text-success")
    .removeClass("text-danger")
    .removeClass("text-warning")
    .removeClass("text-info")
    .removeClass("text-light")
    .removeClass("text-dark")
    .removeClass("spinner-border-xs")
    .removeClass("spinner-border-sm")
    .removeClass("spinner-border-md")
    .removeClass("spinner-border-lg")
    .removeClass("spinner-border-xl")
    $("#gen-btn-spinner").find("div[name='spinner-holder']")
    .addClass(spinnersize)
    .addClass(spinnerclass);
    return $("#gen-btn-spinner").html();
  }
</script>


<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" data-bs-backdrop="false" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header p-2" style="background-color: #38b6ff;">
      </div>
      <div class="modal-body p-4 text-center">
        <p class="mb-0" style="font-family: sans-serif;">Are you sure you want to log out? Make sure all tasks are completed.</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button
          type="button"
          class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end"
          onclick="logout()">
          Confirm
        </button>
        <button
          type="button"
          class="btn btn-sm btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0"
          data-bs-dismiss="modal">
          No
        </button>
      </div>

    </div>
  </div>
</div>

<script>
    function logout() {
    $.post("actions/logoutinventory.php", {}, function(data) {
        if ($.trim(data) == "OK") {
            window.location.assign("index.php");
        }
    });
}
</script>



<!-- Modal: Setup Account -->
<div class="modal fade" id="mdl-setup-account" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center bg-secondary-subtle">
        <a class="navbar-brand d-flex align-items-center me-2" href="#">
         <!--  <img src="../assets/image/logo/qtlogo.png" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"> -->
        </a>
        <h1 class="modal-title fs-5 text-muted mb-0">Welcome to iQuote</h1>
      </div>
      <div class="modal-body">
        <h6 class="text-muted mb-1">Setup Account Security</h6>
        <small class="text-muted d-block mb-3">
          For your security, please update your password before continuing.
        </small>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="new-password" placeholder="New Password">
          <label for="new-password">New Password</label>
          <small class="text-secondary" id="error-password">
            Make sure both passwords match.
          </small>
          <small class="text-danger d-none" id="special-password">
            Password must contain at least one special character.
          </small>

        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password">
          <label for="confirm-password">Confirm Password</label>
          <small class="text-danger d-none" id="dontmatch-password">
            Passwords don't match.
          </small>
        </div>
        <div class="form-check d-flex justify-content-end mb-2">
          <input class="form-check-input" type="checkbox" id="show-password" onclick="setupviewpassword()">
          <label class="form-check-label text-muted ms-2" for="show-password">
            Show Password
          </label>
        </div>
        <hr>
        <h6 class="text-muted mb-1">Account Recovery Question</h6>
        <small class="text-muted d-block mb-3">
          This will help you recover your account if you forget your password.
        </small>
        <div class="form-floating mb-3">
          <select class="form-select" id="recovery-question">
            <option selected disabled></option>
            <option value="1">What is your mother’s maiden name?</option>
            <option value="2">What was the name of your first pet?</option>
            <option value="3">What was the name of your first school?</option>
            <option value="4">What city were you born in?</option>
          </select>
          <label for="recovery-question">Question</label>
        </div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="recovery-answer" placeholder="Your Answer">
          <label for="recovery-answer">Answer</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveUpdates()">Save</button>
      </div>
    </div>
  </div>
</div>



<script>
  function setupviewpassword() {
    const newPassword = document.getElementById('new-password');
    const confirmPassword = document.getElementById('confirm-password');
    const checkbox = document.getElementById('show-password');
    const type = checkbox.checked ? 'text' : 'password';
    newPassword.type = type;
    confirmPassword.type = type;
  }

/*Function update account*/
 function saveUpdates() {
     var NewPassword     = $("#new-password").val();
     var ConfirmPassword = $("#confirm-password").val();
     var RecQuestion     = $("#recovery-question").val();
     var RecAnswer       = $("#recovery-answer").val();
     var LogDetails      = 'Account Setup';
     var isValid = true;
     $("#new-password, #confirm-password, #recovery-question, #recovery-answer")
         .removeClass("is-invalid");
     $("#error-password, #dontmatch-password, #special-password").addClass("d-none");

     // Empty checks
     if (NewPassword === "") {
         $("#new-password").addClass("is-invalid");
         isValid = false;
     }
     if (ConfirmPassword === "") {
         $("#confirm-password").addClass("is-invalid");
         isValid = false;
     }
     if (NewPassword !== "" && ConfirmPassword !== "" && NewPassword !== ConfirmPassword) {
         $("#confirm-password").addClass("is-invalid");
         $("#dontmatch-password").removeClass("d-none");
         isValid = false;
     }
     var specialCharPattern = /[!@#$%^&*(),.?":{}|<>_\-+=~`[\]\\\/]/;
     if (NewPassword !== "" && !specialCharPattern.test(NewPassword)) {
         $("#new-password").addClass("is-invalid");
         $("#special-password").removeClass("d-none");
         isValid = false;
     }

     if (RecQuestion === "") {
         $("#recovery-question").addClass("is-invalid");
         isValid = false;
     }
     if (RecAnswer === "") {
         $("#recovery-answer").addClass("is-invalid");
         isValid = false;
     }
     if (!isValid) {
         return;
     }
     $.post("../actions/update_setup.php", {
         Password    : NewPassword,
         RecQuestion : RecQuestion,
         RecAnswer   : RecAnswer,
         LogDetails  : LogDetails,
     }, function(data) {
         if (jQuery.trim(data) === "success") {
             $("#mdl-setup-account").modal('hide');
             console.log('Update successful');
         } else {
             alert(data);
         }
     });
 }


</script>


<!-- Modal Update account -->
<div class="modal fade" id="modal-reset-pasword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h4 class="text-muted">Account Security Update</h4>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="password" id="update-password" name="update-password" class="form-control" placeholder="New Password">
            <label for="update-password">Create new Password</label>
          </div>
          <!-- <small class="text-muted">Create new password.</small> -->
          <div class="form-floating mt-3">
            <input type="password" id="reconfirm-password" name="reconfirm-password" class="form-control" placeholder="New Password">
            <label for="reconfirm-password">Confirm Password</label>
          </div>
          <small class="text-muted">Make sure both password matched.</small>
        </div>
        <small class="text-danger " id="error-message"></small>
        <div class="form-check d-flex justify-content-end mb-3">
          <input class="form-check-input" type="checkbox" id="view-password" onclick="viewPassword()">
          <label class="form-check-label text-muted ms-2" for="view-password">
            Show Password
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveNewPassword()">Save</button>
      </div>
    </div>
  </div>
</div>


<script>
  function viewPassword() {
    const newPassword = document.getElementById('update-password');
    const confirmPassword = document.getElementById('reconfirm-password');
    const checkbox = document.getElementById('view-password');
    const type = checkbox.checked ? 'text' : 'password';
    newPassword.type = type;
    confirmPassword.type = type;
  }

  /*Function update new password*/
  function saveNewPassword(){
    var NewPassword     = $("#update-password").val();
    var ConfirmPassword = $("#reconfirm-password").val();
    var ErrorMessage    = $("#error-message");

    ErrorMessage.addClass("d-none");
    if (NewPassword !== ConfirmPassword) {
        ErrorMessage.text("Passwords do not match.").removeClass("d-none");
        return;
    }

    if (NewPassword.trim() === "") {
        ErrorMessage.text("Password cannot be empty.").removeClass("d-none");
        return;
    }

    $.post("../actions/update_newpassword.php", {
        Password: NewPassword
    }, function(data){
        if ($.trim(data) === "success") {
            console.log("Password changed.");
            $("#modal-reset-pasword").modal("hide");
        } else {
            alert("Error: " + data);
        }
    });
}




</script>



