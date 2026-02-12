<!-- Modal Apply Manual Discount per Item -->
<div class="modal fade" id="mdl-manual-discount" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Manual Discount</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="apply-manualdisc" name="apply-manualdisc" class="form-control" placeholder="Amount Discount">
            <label for="apply-manualdisc">Amount Discount</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary">Apply</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Submit Propmpt -->
<div class="modal fade" id="mdl-submit" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0" style="font-family: sans-serif;">Make sure all information is accurate before you commit.</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-danger fs-6 col-6 py-3 m-0 rounded-0 border-end" id="btn-submit" onclick="save_quotaion()">
          <span id="btn-text">Commit</span>
          <span id="btn-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
        </button>
        <button type="button" class="btn btn-sm btn-secondary fs-6 col-6 py-3 m-0 rounded-0" id="btn-cancel" data-bs-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Search customer modal -->
<div class="modal fade" id="mdl-search-customer" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5">Search Customer</h1>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <input type="search" name="find-customerzs" id="find-customerzs" class="form-control" placeholder="Search Customer">
          <button class="btn btn-outline-secondary" type="button" title="Search Customer" onclick="loadCustomersRecords()">Find</button>
        </div>
        <div class="table-responsive">
          <table class="table table-sm table-hover table-bordered">
            <thead class="table-secondary text-center">
              <tr>
                <th>Customer</th>
                <th>Company</th>
                <th>Contact</th>
              </tr>
            </thead>
            <tbody id="load_customers">
              <tr>
                <td colspan="3" class="p-5 text-center text-muted">
                    <i class="bi bi-people fs-3"></i> 
                    <br>
                    Find Customer!
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" onclick="loadHome()">Close</button>
      </div>
    </div>
  </div>
</div>

