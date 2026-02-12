<!-- Modal Create Staff ACcount -->
<div class="modal fade" id="mdl-create-hostaff" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5">Create Account</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="ho-fullname" name="ho-fullname" class="form-control" placeholder="Fullname" autocomplete="off">
            <label for="ho-fullname">Fullname</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="ho-position" name="ho-position" class="form-control" placeholder="Position" autocomplete="off">
            <label for="ho-position">Position</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="ho-username" name="ho-username" class="form-control" placeholder="Username">
            <label for="ho-username">Username</label>
          </div>
          <div class="form-floating mb-2">
            <input type="password" id="ho-password" name="ho-password" class="form-control" placeholder="Password">
            <label for="ho-password">Password</label>
          </div>
          <div class="form-check d-flex justify-content-end mb-3">
            <input class="form-check-input" type="checkbox" id="ho-showpass" onclick="showPasssHo()">
            <label class="form-check-label text-muted ms-2" for="ho-showpass">
              Show Password
            </label>
          </div>
          <input type="hidden" id="usr-branch">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="createHeadOfficeStaff()">Create</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script>
  function showPasssHo() {
      const passwordField = document.getElementById('ho-password');
      const checkbox = document.getElementById('ho-showpass');
      passwordField.type = checkbox.checked ? 'text' : 'password';
  }

  document.getElementById("ho-fullname").addEventListener("input", function () {
    let fullname = this.value.trim();
    let branchCode = "ICBU";
    if (fullname !== "") {
        let processedName = fullname.toUpperCase().replace(/\s+/g, "");
        let username = branchCode + "-" + processedName;
        let password = processedName;
        document.getElementById("ho-username").value = username;
        document.getElementById("ho-password").value = password;
    } else {
        document.getElementById("ho-username").value = "";
        document.getElementById("ho-password").value = "";
    }
});
</script>


<!-- Modal Update Staff -->
<div class="modal fade" id="mdl-update-accountho" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="account-nameho"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <small>Quotation Performance</small>
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="number-pendingho" name="number-pendingho" class="form-control" placeholder="Pending" readonly>
            <label for="number-pendingho">Pending</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-approvedho" name="number-approvedho" class="form-control" placeholder="Approved" readonly>
            <label for="number-approvedho">Approved</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-rejectedho" name="number-rejectedho" class="form-control" placeholder="Rejected" readonly>
            <label for="number-rejectedho">Rejected</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-onholdho" name="number-onholdho" class="form-control" placeholder="On Hold" readonly>
            <label for="number-onholdho">On Hold</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="number-cancelledho" name="number-cancelledho" class="form-control" placeholder="Cancelled" readonly>
            <label for="number-cancelledho">Cancelled</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger"  onclick="commitRemoveHO()">Remove</button>
        <button type="button" class="btn btn-outline-secondary"  onclick="commitEnableHO()">Enable</button>
        <button type="button" class="btn btn-outline-danger"   onclick="disableuserHO()">Disable</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="user-usernameho">


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
