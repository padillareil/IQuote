<!-- Modal Create Bank -->
<div class="modal fade" id="mld-create-bank" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Branch Bank</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="create-branch" name="create-branch" class="form-control text-uppercase" placeholder="Branch">
            <label for="create-branch">Branch</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-bank" name="create-bank" class="form-control text-uppercase" placeholder="Bank">
            <label for="create-bank">Bank</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-accountname" name="create-accountname" class="form-control text-uppercase" placeholder="Account name">
            <label for="create-accountname">Account name</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-accountnumber" name="create-accountnumber" class="form-control text-uppercase" placeholder="Account number">
            <label for="create-accountnumber">Account number</label>
          </div>
          <div class="form-floating mb-2">
            <select class="form-select" id="create-corpotype" name="create-corpotype">
              <option selected disabled></option>
              <option value="VIC IMPERIAL APPLIANCE CORPORATION">VIC IMPERIAL APPLIANCE CORPORATION</option>
              <option value="NOLU MARKETING CORPORATION">NOLU MARKETING CORPORATION</option>
              <option value="ALPHAMIN COMMERCIAL CORPORATION">ALPHAMIN COMMERCIAL CORPORATION</option>
              <option value="SOLU TRADING CORPORATION">SOLU TRADING CORPORATION</option>
            </select>
            <label for="create-corpotype">Corporation</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveBranchbank()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Create Bank -->
<div class="modal fade" id="mld-corpo-bank" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Corporate Bank</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="create-branchcorp" name="create-branchcorp" class="form-control text-uppercase" placeholder="Branch">
            <label for="create-branchcorp">Branch</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-bankcorp" name="create-bankcorp" class="form-control text-uppercase" placeholder="Bank">
            <label for="create-bankcorp">Bank</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-accountnamecorp" name="create-accountnamecorp" class="form-control text-uppercase" placeholder="Account name">
            <label for="create-accountnamecorp">Account name</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-accountnumbercorp" name="create-accountnumbercorp" class="form-control text-uppercase" placeholder="Account number">
            <label for="create-accountnumbercorp">Account number</label>
          </div>
          <div class="form-floating mb-2">
            <select class="form-select" id="create-corpotypecorp" name="create-corpotypecorp">
              <option selected disabled></option>
              <option value="VIC IMPERIAL APPLIANCE CORPORATION">VIC IMPERIAL APPLIANCE CORPORATION</option>
              <option value="NOLU MARKETING CORPORATION">NOLU MARKETING CORPORATION</option>
              <option value="ALPHAMIN COMMERCIAL CORPORATION">ALPHAMIN COMMERCIAL CORPORATION</option>
              <option value="SOLU TRADING CORPORATION">SOLU TRADING CORPORATION</option>
            </select>
            <label for="create-corpotypecorp">Corporation</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveCorpbank()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Update Bank -->
<div class="modal fade" id="mld-update-bank" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Bank Details</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="upd-bank" name="upd-bank" class="form-control text-uppercase" placeholder="Bank">
            <label for="upd-bank">Bank</label>
          </div>
          <input type="hidden" id="upd-bakid">
          <div class="form-floating mb-2">
            <input type="text" id="upd-accountname" name="upd-accountname" class="form-control text-uppercase" placeholder="Account name">
            <label for="upd-accountname">Account name</label>
          </div>
          
          <div class="form-floating mb-2">
            <input type="text" id="upd-accountnumber" name="upd-accountnumber" class="form-control" placeholder="Account number">
            <label for="upd-accountnumber">Account number</label>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveUPDBank()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal delete bank -->
<div class="modal fade" id="mld-del-bank" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this bank?</p>
      </div>
      <input type="hidden" id="del-bakid">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="deletebank()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Bank transfer modal -->
<form id="frm-add-banktransfer">
  <div class="modal fade" id="mdl-add-bnktransfer" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5" id="mdl-title">Add Bank Transfer</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <select class="form-select" id="bt-corpotype" name="bt-corpotype" required>
                <option selected disabled></option>
                <option value="VIC IMPERIAL APPLIANCE CORPORATION">VIC IMPERIAL APPLIANCE CORPORATION</option>
                <option value="NOLU MARKETING CORPORATION">NOLU MARKETING CORPORATION</option>
                <option value="ALPHAMIN COMMERCIAL CORPORATION">ALPHAMIN COMMERCIAL CORPORATION</option>
                <option value="SOLU TRADING CORPORATION">SOLU TRADING CORPORATION</option>
              </select>
              <label for="bt-corpotype">Corporation</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="bt-bank" name="bt-bank" class="form-control text-uppercase" placeholder="Branch" required>
              <label for="bt-bank">Bank</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="bt-bankaccountname" name="bt-bankaccountname" class="form-control text-uppercase" placeholder="Bank" required>
              <label for="bt-bankaccountname">Account name</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="bt-accountnumber" name="bt-accountnumber" class="form-control text-uppercase" placeholder="Account name" required>
              <label for="bt-accountnumber">Account number</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-secondary" id="btn-save">Save</button>
          <button type="button" class="btn btn-outline-primary d-none" id="btn-edit" onclick="updateBankTransfer()">Update</button>
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>

<input type="hidden" id="banktransfer-id">

<!-- Modal delete bank -->
<div class="modal fade" id="mld-del-transferbank" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this bank?</p>
      </div>
      <input type="hidden" id="del-bakid">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="delTransferBank()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
