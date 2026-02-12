<!-- Modal Create Contact -->
<div class="modal fade" id="mdl-create-contact" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Contact</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="create-branch" name="create-branch" class="form-control text-uppercase" placeholder="Banch">
            <label for="create-branch">Banch</label>
          </div>
          <input type="hidden" id="upd-tid">
          <div class="form-floating mb-2">
            <input type="text" id="create-telephone" name="create-telephone" class="form-control" placeholder="Telephone">
            <label for="create-telephone">Telephone</label>
          </div>
          
          <div class="form-floating mb-2">
            <input type="text" id="create-mobile" name="create-mobile" class="form-control" placeholder="Mobile">
            <label for="create-mobile">Mobile</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="create-mobilenetwork" name="create-mobilenetwork" class="form-control" placeholder="Mobile Network">
            <label for="create-mobilenetwork">Mobile Network</label>
          </div>
       
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="btn-save" onclick="saveContactnumber()">Save</button>
        <button type="button" class="btn btn-outline-secondary d-none" id="btn-update" onclick="updatedContact()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal delete contact -->
<div class="modal fade" id="mdl-delete-contact" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this contact number?</p>
      </div>
      <input type="hidden" id="del-contact">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="delContact()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>