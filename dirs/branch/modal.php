<!-- Modal Update Branch -->
<div class="modal fade" id="mdl-updatebranch" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Branch Details</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="upd-branchcode" name="upd-branchcode" class="form-control text-uppercase" placeholder="Branch code" maxlength="4">
            <label for="upd-branchcode">Branch code</label>
          </div>
          <input type="hidden" id="upd-brancid">
          <div class="form-floating mb-2">
            <input type="text" id="upd-branch" name="upd-branch" class="form-control text-uppercase" placeholder="Branch">
            <label for="upd-branch">Branch</label>
          </div>
          
          <div class="form-floating mb-2">
            <input type="text" id="upd-area" name="upd-area" class="form-control text-uppercase" placeholder="Region">
            <label for="upd-area">Region</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="upd-address" name="upd-address" class="form-control" placeholder="Address">
            <label for="upd-address">Address</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="update_branch()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal delete branch -->
<div class="modal fade" id="mdl-delete-branch" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this branch?</p>
      </div>
      <input type="hidden" id="del-branch">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="delBranch()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Create Branch -->
<div class="modal fade" id="mdl-create-branch" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Branch</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="create-branch" name="create-branch" class="form-control text-uppercase" placeholder="Branch">
            <label for="create-branch">Branch</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-branchcode" name="create-branchcode" class="form-control text-uppercase" placeholder="Branch code">
            <label for="upd-branch code">Branch code</label>
          </div>
          
          <div class="form-floating mb-2">
            <input type="text" id="create-area" name="create-area" class="form-control text-uppercase" placeholder="Region">
            <label for="create-area">Region</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-address" name="create-address" class="form-control" placeholder="Address">
            <label for="create-address">Address</label>
          </div>
          <div class="form-floating mb-2">
            <select class="form-select" id="create-company">
              <option selected disabled></option>
              <option value="Alphamin Commercial Corporation">Alphamin Commercial Corporation</option>
              <option value="Nolu Marketing Corporation">Nolu Marketing Corporation</option>
              <option value="Solu Trading Corporation">Solu Trading Corporation</option>
              <option value="Vic Imperial Appliance Corporation">Vic Imperial Appliance Corporation</option>
            </select>
            <label for="create-company">Corporation</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveCreateBRanch()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
