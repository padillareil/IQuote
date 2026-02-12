<!-- Modal Add Branch -->
<div class="modal fade" id="mdl-add-branch" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frm-add-branch">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Add Branch</h1>
        </div>

        <div class="modal-body">
          <div class="form-floating mb-2">
            <input type="text" id="branch-coder" name="branch-coder" class="form-control text-uppercase" maxlength="4" placeholder="Branch Code" required autocomplete="off">
            <label for="branch-coder">Branch Code</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" id="branch" name="branch" class="form-control text-uppercase" placeholder="Branch" required autocomplete="off">
            <label for="branch">Branch</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" id="address" name="address" class="form-control" placeholder="Address" required autocomplete="off">
            <label for="address">Address</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" id="area" name="area" class="form-control text-uppercase" placeholder="Area" required autocomplete="off">
            <label for="area">Area</label>
          </div>

          <div class="form-floating mb-2">
            <select class="form-select" id="company-corpo" name="company-corpo" required>
              <option selected disabled></option>
              <option value="Vic Imperial Appliance Corporation">VIC IMPERIAL APPLIANCE CORPORATION</option>
              <option value="Nolu Marketing Corporation">NOLU MARKETING CORPORATION</option>
              <option value="Alphamin Commercial Corporation">ALPHAMIN COMMERCIAL CORPORATION</option>
              <option value="Solu Trading Corporation">SOLU TRADING CORPORATION</option>
            </select>
            <label for="company-corpo">Corporation</label>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-secondary">Save</button>
          <button type="reset" class="btn btn-outline-primary">Clear</button>
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
  /*Script To add Branch*/
  $("#frm-add-branch").submit(function(event){
      event.preventDefault();

      var Branchcode   = $("#branch-coder").val();
      var Branch       = $("#branch").val();
      var Address      = $("#address").val();
      var Area         = $("#area").val();
      var Corporation  = $("#company-corpo").val();
      let Corpcode     = '';
      if (Corporation === 'Vic Imperial Appliance Corporation') {
          Corpcode = 'VIAC';
      } else if (Corporation === 'Nolu Marketing Corporation') {
          Corpcode = 'NOLU';
      } else if (Corporation === 'Alphamin Commercial Corporation') {
          Corpcode = 'ACC';
      } else if (Corporation === 'Solu Trading Corporation') {
          Corpcode = 'SOLU';
      } else {
          Corpcode = 'VIAC';
      }

      $.post("dirs/branch/actions/save_branch.php", {
          Branchcode  : Branchcode,
          Branch      : Branch,
          Address     : Address,
          Area        : Area,
          Corporation : Corporation,
          Corpcode    : Corpcode,
      }, function(data){
          if($.trim(data) == "OK"){
              $("#frm-add-branch")[0].reset();
              mdladdBranch();
              $("#mdl-add-branch").modal("hide");

              Swal.fire({
                  icon: 'success',
                  title: 'New Branch Added',
                  text: 'Success.',
                  timer: 3000,
                  showConfirmButton: false
              });
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Oops!',
                  text: data
              });
          }
      });
  });

</script>


<!-- Modal Edit Branch -->
  <div class="modal fade" id="mdl-edit-branch" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="frm-edit-branch">
          <div class="modal-header bg-secondary-subtle">
            <h1 class="modal-title fs-5">Edit Branch</h1>
          </div>
          <div class="modal-body">
            <div class="form-floating mb-2">
              <input type="text" id="edit-branch-coder" class="form-control text-uppercase">
              <label>Branch Code</label>
            </div>

            <div class="form-floating mb-2">
              <input type="text" id="edit-branch" class="form-control text-uppercase">
              <label>Branch</label>
            </div>

            <div class="form-floating mb-2">
              <input type="text" id="edit-address" class="form-control">
              <label>Address</label>
            </div>

            <div class="form-floating mb-2">
              <input type="text" id="edit-area" class="form-control text-uppercase">
              <label>Area</label>
            </div>

            <div class="form-floating mb-2">
              <select class="form-select" id="edit-company-corpo">
                <option selected disabled></option>
                <option value="Vic Imperial Appliance Corporation">VIC IMPERIAL APPLIANCE CORPORATION</option>
                <option value="Nolu Marketing Corporation">NOLU MARKETING CORPORATION</option>
                <option value="Alphamin Commercial Corporation">ALPHAMIN COMMERCIAL CORPORATION</option>
                <option value="Solu Trading Corporation">SOLU TRADING CORPORATION</option>
              </select>
              <label>Corporation</label>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-secondary">Update</button>
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
  /*Script To update Branch*/
  $("#frm-edit-branch").submit(function(event){
      event.preventDefault();

      var Branchcode   = $("#edit-branch-coder").val();
      var Branchid     = $("#branch-id").val();
      var Branch       = $("#edit-branch").val();
      var Address      = $("#edit-address").val();
      var Area         = $("#edit-area").val();
      var Corporation  = $("#edit-company-corpo").val();
      let Corpcode     = '';
      if (Corporation === 'Vic Imperial Appliance Corporation') {
          Corpcode = 'VIAC';
      } else if (Corporation === 'Nolu Marketing Corporation') {
          Corpcode = 'NOLU';
      } else if (Corporation === 'Alphamin Commercial Corporation') {
          Corpcode = 'ACC';
      } else if (Corporation === 'Solu Trading Corporation') {
          Corpcode = 'SOLU';
      } else {
          Corpcode = 'VIAC';
      }

      $.post("dirs/branch/actions/update_branch.php", {
          Branchcode  : Branchcode,
          Branchid    : Branchid,
          Branch      : Branch,
          Address     : Address,
          Area        : Area,
          Corporation : Corporation,
          Corpcode    : Corpcode,
      }, function(data){
          if($.trim(data) == "success"){
              $("#frm-edit-branch")[0].reset();
              loadIAPBranches();
              $("#mdl-edit-branch").modal("hide");

              Swal.fire({
                  icon: 'success',
                  title: 'Update saved.',
                  text: 'Success.',
                  timer: 3000,
                  showConfirmButton: false
              });
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Oops!',
                  text: data
              });
          }
      });
  });

</script>




<!-- Modal remove Propmpt -->
<div class="modal fade" id="mdl-remove-branch" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0" style="font-family: sans-serif;">Do you want to remove this branch?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-danger fs-6 col-6 py-3 m-0 rounded-0 border-end" onclick="removeBranch()">
          Yes
        </button>
        <button type="button" class="btn btn-sm btn-secondary fs-6 col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>
