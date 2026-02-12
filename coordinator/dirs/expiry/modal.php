<!-- Create Expiry -->
<form id="frm-expiry">
  <div class="modal fade" id="mdl-create-expiry" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Create Expiry</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <select class="form-select" id="customer-type" required>
                <option selected disabled></option>
                <option value="Corporate Private">Corporate Private</option>
                <option value="Corporate Government">Corporate Government</option>
                <option value="Private">Private</option>
                <option value="Personal">Personal</option>
              </select>
              <label for="customer-type">Customer Type</label>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-2">
                  <input type="number" id="expiration" name="expiration" class="form-control" placeholder="Set Expiration" required>
                  <label for="expiration">Set Expiration</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-2">
                  <select class="form-select" id="expiry-type" required>
                    <option selected disabled></option>
                    <option value="Day">Day</option>
                    <option value="Days">Days</option>
                    <!-- <option value="Month">Month</option>
                    <option value="Months">Months</option>
                    <option value="Year">Year</option>
                    <option value="Years">Years</option> -->
                  </select>
                  <label for="expiry-type">Expiration Type</label>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-secondary">Save</button>
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>


<!-- Edit Expiration -->
<form id="frm-edit-expiry">
  <div class="modal fade" id="mdl-edit-expiry" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Edit Expiry</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <input type="text" id="edit-csutomertype" name="edit-csutomertype" class="form-control" readonly placeholder="Set Expiration">
              <label for="customer-type">Customer Type</label>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-2">
                  <input type="number" id="edit-expiration" name="edit-expiration" class="form-control" placeholder="Edit Set Expiration" required>
                  <label for="edit-expiration">Edit Set Expiration</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-2">
                  <select class="form-select" id="edit-expiry-type" required>
                    <option selected disabled></option>
                    <option value="Day">Day</option>
                    <option value="Days">Days</option>
                   <!--  <option value="Month">Month</option>
                    <option value="Months">Months</option>
                    <option value="Year">Year</option>
                    <option value="Years">Years</option> -->
                  </select>
                  <label for="edit-expiry-type">Edit Expiration Type</label>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-secondary">Save</button>
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>