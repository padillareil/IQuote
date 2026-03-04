<!-- Modal Update Staff -->
<div class="modal fade" id="mdl-update-account" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="account-name"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <small>Quotation Performance</small>
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="number-pending" name="number-pending" class="form-control" placeholder="Pending" readonly>
            <label for="number-pending">Pending</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-approved" name="number-approved" class="form-control" placeholder="Approved" readonly>
            <label for="number-approved">Approved</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-rejected" name="number-rejected" class="form-control" placeholder="Rejected" readonly>
            <label for="number-rejected">Rejected</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-onhold" name="number-onhold" class="form-control" placeholder="On Hold" readonly>
            <label for="number-onhold">On Hold</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-cancelled" name="number-cancelled" class="form-control" placeholder="Cancelled" readonly>
            <label for="number-cancelled">Cancelled</label>
          </div>

        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger" onclick="commitRemove()">Remove</button>
        <button type="button" class="btn btn-outline-secondary" onclick="commitEnable()">Enable</button>
        <button type="button" class="btn btn-outline-danger" onclick="disableuser()">Disable</button>
        <button type="button" class="btn btn-outline-primary" data-bs-target="#mdl-edit-contact" data-bs-toggle="modal" onclick="loaduserContact()">Edit Contacts</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="user-username">

<!-- Modal Create Staff ACcount -->
<div class="modal fade" id="mdl-create-staff" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5">Create Account</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <!-- For Online User and REM -->
          <input type="hidden" id="staff-branch">
          <div class="form-floating mb-2" id="select-branchassignment">
            <select class="form-select" id="branch-assignment" name="branch-assignment">
            </select>
            <label for="branch-assignment">Branch Assignment</label>
          </div>
          <input type="hidden" name="branch-code" id="branch-code">
          <div class="form-floating mb-2">
            <input type="text" id="staff-fullname" name="staff-fullname" class="form-control" placeholder="Fullname">
            <label for="staff-fullname">Fullname</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="staff-position" name="staff-position" class="form-control" placeholder="Position">
            <label for="staff-position">Position</label>
          </div>
          <div class="form-floating mb-2">
            <input type="email" id="staff-personalemail" name="staff-personalemail" class="form-control" placeholder="Email"  autocomplete="off">
            <label for="staff-personalemail">Email</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="staff-contactnumber" name="staff-contactnumber" class="form-control" placeholder="Contact Number" maxlength="11" autocomplete="off">
            <label for="staff-contactnumber">Contact number</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="staff-username" name="staff-username" class="form-control" placeholder="Username">
            <label for="staff-username">Username</label>
          </div>
          <div class="form-floating mb-2">
            <input type="password" id="staff-password" name="staff-password" class="form-control" placeholder="Password">
            <label for="staff-password">Password</label>
          </div>
          <div class="form-check d-flex justify-content-end mb-3">
            <input class="form-check-input" type="checkbox" id="staff-showpass" onclick="stfshowPass()">
            <label class="form-check-label text-muted ms-2" for="staff-showpass">
              Show Password
            </label>
          </div>
          <input type="hidden" id="usr-branch">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="createStaff()">Create</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  function stfshowPass() {
      const passwordField = document.getElementById('staff-password');
      const checkbox = document.getElementById('staff-showpass');
      passwordField.type = checkbox.checked ? 'text' : 'password';
  }

  $(document).ready(function () {
      function generateHOCredentials() {
          let fullname   = $("#staff-fullname").val().trim();
          let branchCode = $("#branch-code").val();

          if (fullname !== "") {
              let processedName = fullname.toUpperCase().replace(/\s+/g, "");
              $("#staff-username").val(branchCode + "-" + processedName);
              $("#staff-password").val(processedName);
          } else {
              $("#staff-username").val("");
              $("#staff-password").val("");
          }
      }

      $("#staff-fullname").on("input", generateHOCredentials);
      $("#branch-code").on("input", generateHOCredentials);

  });


  $(document).ready(function(){
      const $input = $("#staff-contactnumber");

      // Auto insert 09 when focused
      $input.on("focus", function(){
          if ($(this).val() === "") {
              $(this).val("09");
          }
      });

      // Prevent deleting the first two characters (09)
      $input.on("keydown", function(e){
          if ($(this)[0].selectionStart <= 2 &&
              (e.key === "Backspace" || e.key === "Delete")) {
              e.preventDefault();
          }
      });

      // Allow numbers only and enforce rules
      $input.on("input", function(){
          let value = $(this).val();

          // Remove non-numeric characters
          value = value.replace(/\D/g, "");

          // Ensure it starts with 09
          if (!value.startsWith("09")) {
              value = "09";
          }

          // Limit to 11 digits
          if (value.length > 11) {
              value = value.substring(0, 11);
          }

          $(this).val(value);
      });

  });


</script>

<!-- Modal remove Propmpt -->
<div class="modal fade" id="mdl-remove" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0" style="font-family: sans-serif;">Do you want to remove this user?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-danger fs-6 col-6 py-3 m-0 rounded-0 border-end" onclick="goRemove()">
          Yes
        </button>
        <button type="button" class="btn btn-sm btn-secondary fs-6 col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Update Contact and email -->
<form id="frm-update-contacts">
  <div class="modal fade" id="mdl-edit-contact" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Edit Staff Contact</h1>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input type="text" id="account-mobile" name="account-mobile" class="form-control" placeholder="Mobile number" required>
            <label for="account-mobile">Mobile Number</label>
          </div>
          <div class="form-floating mb-2">
            <input type="email" id="account-email" name="account-email" class="form-control" placeholder="Email" required>
            <label for="account-email">Email</label>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-success" type="submit">Save</button>
          <button class="btn btn-outline-danger" type="button" data-bs-target="#mdl-update-account" data-bs-toggle="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
     $("#frm-update-contacts").submit(function(event){
        event.preventDefault();
      var Username    = $("#user-username").val();
      var Contact     = $("#account-mobile").val();
      var Email       = $("#account-email").val();
    $.post("dirs/accounts/actions/update_contacts.php", {
        Username  : Username,
        Contact   : Contact,
        Email     : Email,
    }, function(data){
        if($.trim(data) == "success"){
            $("#mdl-edit-contact").modal('hide');
            $("#mdl-update-account").modal('hide');
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Update success.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            loadAccounts();
        }else{
            alert("Error: " + data);
        }
    });
});


</script>