<!-- Modal Create Payment Term -->
<div class="modal fade" id="mld-create-payterm" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="label-payterms">Create Payment Term</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="number" id="create-payterm" name="create-payterm" class="form-control text-uppercase" placeholder="Payment Term">
            <label for="create-payterm">Payment Term</label>
          </div>
          <div class="form-floating mb-2">
            <select class="form-select" id="create-payperiod">
              <option selected disabled></option>
              <option value="days">Days</option>
              <option value="months">Months</option>
              <option value="year">Year</option>
              <option value="years">Year's</option>
            </select>
            <label for="create-payperiod">Payment Period</label>
          </div>
          <input type="hidden" id="pay-id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="btn-save" onclick="savePaymentPeriod()">Save</button>
        <button type="button" class="btn btn-outline-secondary d-none" id="btn-update" onclick="updatePaymentPeriod()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Create Downpyament Term -->
<div class="modal fade" id="mld-create-downpayment" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="label-downpayment">Create Downpayment</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="number" id="create-downpayment" name="create-downpayment" class="form-control" placeholder="Downpayment">
            <label for="create-downpayment">Downpayment</label>
          </div>
          
          <input type="hidden" id="dp-id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="btn-savedp" onclick="saveDownpayment()">Save</button>
        <button type="button" class="btn btn-outline-secondary d-none" id="btn-updatedp" onclick="updatedDownpayment()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal delete payment terms -->
<div class="modal fade" id="mdl-delete-payterm" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this payment term?</p>
      </div>
      <input type="hidden" id="del-payterm">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="delBranch()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal delete downpayment -->
<div class="modal fade" id="mdl-delete-downpayment" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this downpayment term?</p>
      </div>
      <input type="hidden" id="del-dpid">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="delDwnpayment()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>