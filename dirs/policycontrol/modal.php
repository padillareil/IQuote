<!-- Modal Create Policy -->
<div class="modal fade" id="mdl-create-policy" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Terms and Condition</h1>
      </div>
      <div class="modal-body">
          <div class="form-floating mb-2">
            <textarea class="form-control" id="create-policy" name="create-policy" placeholder="Terms and Condition" style="height: 30vh;"></textarea>
            <label for="create-policy">Terms and Condition</label>
          </div>
          <small>Update General Terms and Condition.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveCreateTerms()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal Update Policy -->
<div class="modal fade" id="mdl-upd-policy" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Terms and Condition</h1>
      </div>
      <div class="modal-body">
        <input type="hidden" id="terms-id">
          <div class="form-floating mb-2">
            <textarea class="form-control" id="upd-policy" name="upd-policy" placeholder="Terms and Condition" style="height: 30vh;"></textarea>
            <label for="upd-policy">Terms and Condition</label>
          </div>
          <small>Update General Terms and Condition.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="updateTerms()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal delete branch -->
<div class="modal fade" id="mdl-del-terms" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this terms and condition?</p>
      </div>
      <input type="hidden" id="del-termsid">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="delTerms()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
