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
        <button type="button" class="btn btn-outline-danger"  onclick="commitRemove()">Remove</button>
        <button type="button" class="btn btn-outline-secondary"  onclick="commitEnable()">Enable</button>
        <button type="button" class="btn btn-outline-danger"   onclick="disableuser()">Disable</button>
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
            <input type="text" id="staff-position" name="staff-position" class="form-control" placeholder="Position" value="CNC Manager" readonly>
            <label for="staff-position">Position</label>
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

  document.getElementById("staff-fullname").addEventListener("input", function () {
    let fullname = this.value.trim();
    let branchCode = "CNC";
    if (fullname !== "") {
        let processedName = fullname.toUpperCase().replace(/\s+/g, "");
        let username = branchCode + "-" + processedName;
        let password = processedName;
        document.getElementById("staff-username").value = username;
        document.getElementById("staff-password").value = password;
    } else {
        document.getElementById("staff-username").value = "";
        document.getElementById("staff-password").value = "";
    }
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

<!-- Modal enable user propmt -->
<!-- <div class="modal fade" id="mdl-access-user" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center">
          <p class="text-muted">Do you want to enable this user?</p>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary" onclick="commitEnable()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
 -->

<!-- Modal remove user propmt -->
<!-- <div class="modal fade" id="mdl-remove-user" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center">
          <p class="text-muted">Do you want to remove this user?</p>
        </div>
        <div class="mt-2 form-floating">
          <select class="form-select" id="remove-reason" name="remove-reason">
            <option selected disabled>Select Reason</option>
            <option value="Resigned">Resigned</option>
            <option value="Terminated">Terminated</option>
            <option value="Transferred">Transferred</option>
            <option value="Retired">Retired</option>
          </select>
          <label for="remove-reason">Reason</label>
        </div>
        <small class="text-muted">Please state your reason (remove).</small>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary" onclick="commitRemove()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
 -->
<!-- Modal disable user propmt -->
<!-- <div class="modal fade" id="mdl-disable-user" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center">
          <p class="text-muted">Do you want to disable this user?</p>
        </div>
        <div class="mt-2 form-floating">
          <textarea class="form-control" id="disable-reason" name="disable-reason" maxlength="50" placeholder="Reason" style="height: 20vh;"></textarea>
          <label for="disable-reason">Reason</label>
        </div>
        <small class="text-muted">Please state your reason (disabled).</small>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary" onclick="disableuser()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
 -->