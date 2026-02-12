<!-- Modal findings Propmpt -->
<form  id="frm-reactivate">
  <div class="modal fade" id="mdl-reactivate" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <input type="hidden" id="q-number">
        <input type="hidden" id="customertype">
        <div class="modal-body">
          <p class="mb-0" style="font-family: sans-serif;">Do you want to re-activate this quotation?</p>
          <div class="mt-3">
            <div class="form-floating">
              <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks" required maxlength="50" style="height: 20vh;"></textarea>
              <label class="form-label" for="remarks">Remarks</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger fs-6 col-6 py-3 m-0 rounded-0 border-end">
            Save
          </button>
          <button type="button" class="btn btn-sm btn-secondary fs-6 col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
