<!-- Create Weblink -->
<form id="frm-add-weblink">
  <div class="modal fade" id="mdl-web-link" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Add Website Link (PDF)</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
             <div class="form-floating mb-2">
               <input type="text" id="web-link" name="web-link" class="form-control" placeholder="Website Link (URL)" required>
               <label for="web-link">Website Link (URL)</label>
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


<!-- Edit Weblink -->
<form id="frm-edit-weblink">
  <div class="modal fade" id="mdl-edit-link" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Edit Website Link (PDF)</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
             <div class="form-floating mb-2">
               <input type="text" id="editweb-link" name="editweb-link" class="form-control" placeholder="Website Link (URL)" required>
               <label for="editweb-link">Website Link (URL)</label>
             </div>
             <input type="hidden" id="web_id">
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
