<!-- Modal Add Branch -->
<div class="modal fade" id="mld-branch-bank" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frm-branch-bank">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Create Branch Bank</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <select class="form-select" id="create-branch" name="create-branch" required>
                <option selected disabled></option>
              </select>
              <label for="create-branch">Branch</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-corpotype" name="create-corpotype" class="form-control text-uppercase" required>
              <label for="create-corpotype">Corporation</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-bank" name="create-bank" class="form-control text-uppercase" placeholder="Bank" required>
              <label for="create-bank">Bank</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-accountname" name="create-accountname" class="form-control text-uppercase" placeholder="Account name" required>
              <label for="create-accountname">Account name</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-accountnumber" name="create-accountnumber" class="form-control text-uppercase" placeholder="Account number" required>
              <label for="create-accountnumber">Account number</label>
            </div>
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
  $("#frm-branch-bank").submit(function(event){
      event.preventDefault();

      var Branch          = $("#create-branch").val();
      var Bank            = $("#create-bank").val();
      var Bankmode        = '1';
      var Bankownership   = 'BRNCH';
      var Accountname     = $("#create-accountname").val();
      var Accountnumber   = $("#create-accountnumber").val();
      var Corporation     = $("#create-corpotype").val();
      let Corpcode     = '';
      if (Corporation === 'VIC IMPERIAL APPLIANCE CORPORATION') {
          Corpcode = 'VIAC';
      } else if (Corporation === 'NOLU MARKETING CORPORATION') {
          Corpcode = 'NOLU';
      } else if (Corporation === 'ALPHAMIN COMMERCIAL CORPORATION') {
          Corpcode = 'ACC';
      } else if (Corporation === 'SOLU TRADING CORPORATION') {
          Corpcode = 'SOLU';
      } else {
          Corpcode = 'VIAC';
      }

      $.post("dirs/bank_accounts/actions/save_branch_bank.php", {
          Branch  : Branch,
          Bank      : Bank,
          Bankmode     : Bankmode,
          Bankownership  : Bankownership,
          Accountname    : Accountname,
          Accountnumber  : Accountnumber,
          Corporation : Corporation,
          Corpcode    : Corpcode,
      }, function(data){
          if($.trim(data) == "OK"){
              $("#frm-branch-bank")[0].reset();
              loadIAPBanks();
              $("#mld-branch-bank").modal("hide");
              Swal.fire({
                  icon: 'success',
                  title: 'Added Succcessfully.',
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

<input type="hidden" id="bank-id-edit">
<!-- Modal edit Branch bank -->
<div class="modal fade" id="mld-editbranch-bank" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frm-editbranch-bank">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Edit Branch Bank</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <input type="text" id="create-editbranch" name="create-editbranch" class="form-control" readonly>
              <label for="create-editbranch">Branch</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-editcorpotype" name="create-editcorpotype" class="form-control text-uppercase">
              <label for="create-editcorpotype">Corporation</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-editbank" name="create-editbank" class="form-control text-uppercase" placeholder="Bank">
              <label for="create-editbank">Bank</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-editaccountname" name="create-editaccountname" class="form-control text-uppercase" placeholder="Account name">
              <label for="create-editaccountname">Account name</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-editaccountnumber" name="create-editaccountnumber" class="form-control text-uppercase" placeholder="Account number">
              <label for="create-editaccountnumber">Account number</label>
            </div>
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
  /*Script To add Branch*/
  $("#frm-editbranch-bank").submit(function(event){
      event.preventDefault();

      var Branch          = $("#create-editbranch").val();
      var Corporation     = $("#create-editcorpotype").val();
      var Bnkid           = $("#bank-id-edit").val();
      var Bank            = $("#create-editbank").val();
      var Accountname     = $("#create-editaccountname").val();
      var Accountnumber   = $("#create-editaccountnumber").val();

      $.post("dirs/bank_accounts/actions/update_bank.php", {

          Branch  : Branch,
          Corporation      : Corporation,
          Bnkid     : Bnkid,
          Bank  : Bank,
          Accountname  : Accountname,
          Accountnumber : Accountnumber
      }, function(data){
          if($.trim(data) == "success"){
              $("#frm-editbranch-bank")[0].reset();
              loadIAPBanks();
              $("#mld-editbranch-bank").modal("hide");
              Swal.fire({
                  icon: 'success',
                  title: 'Update success.',
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
<div class="modal fade" id="mdl-remove-bank" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0" style="font-family: sans-serif;">Do you want to remove this Bank Account?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-danger fs-6 col-6 py-3 m-0 rounded-0 border-end" onclick="removeBank()">
          Yes
        </button>
        <button type="button" class="btn btn-sm btn-secondary fs-6 col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Add Bank Corporate -->
<div class="modal fade" id="mdl-add-corpbank" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frm-corpo-bank">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Add Coporate Bank Account</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <select class="form-select" id="create-ownershipcorpotype" required>
                <option selected value=""></option>
                <option value="HOO">Head Office Account</option>
                <option value="CORP">Corporate Account</option>
              </select>
              <label for="create-ownershipcorpotype">Account Type</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-corpobank" name="create-corpobank" class="form-control text-uppercase" placeholder="Bank" required>
              <label for="create-corpobank">Bank</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-corpoaccountname" name="create-corpoaccountname" class="form-control text-uppercase" placeholder="Account name" required> 
              <label for="create-corpoaccountname">Account name</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-corpoaccountnumber" name="create-corpoaccountnumber" class="form-control text-uppercase" placeholder="Account number" required>
              <label for="create-corpoaccountnumber">Account number</label>
            </div>
            <div class="form-floating mb-2">
              <select class="form-select" id="create-corpocorpotype" required>
                <option selected value=""></option>
                <option value="ALPHAMIN COMMERCIAL CORPORATION">ALPHAMIN COMMERCIAL CORPORATION</option>
                <option value="NOLU MARKETING CORPORATION">NOLU MARKETING CORPORATION</option>
                <option value="SOLU TRADING CORPORATION">SOLU TRADING CORPORATION</option>
                <option value="SOLU TRADING CORPORATION">VIC IMPERIAL APPLIANCE CORPORATION</option>
              </select>
              <label for="create-corpocorpotype">Corporation</label>
            </div>
          
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-secondary">Save</button>
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  /*Script To add Bank Corporate*/
  $("#frm-corpo-bank").submit(function(event){
      event.preventDefault();

      var Bank            = $("#create-corpobank").val();
      var Accountname     = $("#create-corpoaccountname").val();
      var Accountnumber   = $("#create-corpoaccountnumber").val();
      var Corporation     = $("#create-corpocorpotype").val();
      var Bankmode         = '1';
      var BankOwnership   = $("#create-ownershipcorpotype").val();
      var Corpcode        = 'VIAC';

      $.post("dirs/bank_accounts/actions/save_transferbank.php", {

          Bank  : Bank,
          Accountname  : Accountname,
          Accountnumber : Accountnumber,
          Corporation  : Corporation,
          Bankmode  : Bankmode,
          BankOwnership     : BankOwnership,
          Corpcode     : Corpcode,
      }, function(data){
          if($.trim(data) == "OK"){
              $("#frm-corpo-bank")[0].reset();
              loadIAPBanks();
              $("#mdl-add-corpbank").modal("hide");
              Swal.fire({
                  icon: 'success',
                  title: 'Succcessfully added.',
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

<!-- Modal EDIT BANK CORPORATE -->
<div class="modal fade" id="mdl-edit-corpo" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frm-corpo-edit">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Add Bank Transfer</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <input type="text" id="edit-bnkcorpo" name="edit-bnkcorpo" class="form-control text-uppercase" placeholder="Bank">
              <label for="edit-bnkcorpo">Bank</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="edit-corporate" name="edit-corporate" class="form-control text-uppercase" placeholder="Coporation">
              <label for="edit-corporate">Coporation</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="edit-corpoacc" name="edit-corpoacc" class="form-control text-uppercase" placeholder="Account name"> 
              <label for="edit-corpoacc">Account name</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="edit-corpoaccnum" name="edit-corpoaccnum" class="form-control text-uppercase" placeholder="Account number">
              <label for="edit-corpoaccnum">Account number</label>
            </div>
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
  /*Script To add Branch*/
  $("#frm-corpo-edit").submit(function(event){
      event.preventDefault();
      var Branch          = '';
      var Corporation     = $("#edit-corporate").val();
      var Bnkid           = $("#bank-id-edit").val();
      var Bank            = $("#edit-bnkcorpo").val();
      var Accountname     = $("#edit-corpoacc").val();
      var Accountnumber   = $("#edit-corpoaccnum").val();

      $.post("dirs/bank_accounts/actions/update_corpobank.php", {

          Branch  : Branch,
          Corporation      : Corporation,
          Bnkid     : Bnkid,
          Bank  : Bank,
          Accountname  : Accountname,
          Accountnumber : Accountnumber
      }, function(data){
          if($.trim(data) == "success"){
              $("#frm-corpo-edit")[0].reset();
              loadIAPBanks();
              $("#mdl-edit-corpo").modal("hide");
              Swal.fire({
                  icon: 'success',
                  title: 'Update success.',
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





<!-- Modal Add Bank Transfer -->
<div class="modal fade" id="mdl-add-transfer" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frm-tra-bank">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Add Bank Transfer</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <input type="text" id="create-trabank" name="create-trabank" class="form-control text-uppercase" placeholder="Bank" required>
              <label for="create-trabank">Bank</label>
            </div>
            <div class="form-floating mb-2">
              <select class="form-select" id="create-tracorpotype" required>
                <option selected value=""></option>
                <option value="VIC IMPERIAL APPLIANCE CORP.">VIC IMPERIAL APPLIANCE CORP</option>
                <option value="IMPERIAL APPLIANCE PLAZA">IMPERIAL APPLIANCE PLAZA</option>
              </select>
              <label for="create-tracorpotype">Corporation</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-traaccountname" name="create-traaccountname" class="form-control text-uppercase" placeholder="Account name" required> 
              <label for="create-traaccountname">Account name</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="create-traaccountnumber" name="create-traaccountnumber" class="form-control text-uppercase" placeholder="Account number" required>
              <label for="create-traaccountnumber">Account number</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-secondary">Save</button>
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  /*Script To add Branch*/
  $("#frm-tra-bank").submit(function(event){
      event.preventDefault();

      var Bank            = $("#create-trabank").val();
      var Accountname     = $("#create-traaccountname").val();
      var Accountnumber   = $("#create-traaccountnumber").val();
      var Corporation     = $("#create-tracorpotype").val();
      var Bankmode         = '1';
      var BankOwnership   = 'Personal';
      var Corpcode        = 'VIAC';

      $.post("dirs/bank_accounts/actions/save_transferbank.php", {

          Bank  : Bank,
          Accountname  : Accountname,
          Accountnumber : Accountnumber,
          Corporation  : Corporation,
          Bankmode  : Bankmode,
          BankOwnership     : BankOwnership,
          Corpcode     : Corpcode,
      }, function(data){
          if($.trim(data) == "OK"){
              $("#frm-tra-bank")[0].reset();
              loadIAPBanks();
              $("#mdl-add-transfer").modal("hide");
              Swal.fire({
                  icon: 'success',
                  title: 'Succcessfully added.',
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

<!-- Modal Add Bank Transfer -->
<div class="modal fade" id="mdl-edit-transfer" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="frm-tra-edit">
        <div class="modal-header bg-secondary-subtle">
          <h1 class="modal-title fs-5">Add Bank Transfer</h1>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <div class="form-floating mb-2">
              <input type="text" id="edit-trabank" name="edit-trabank" class="form-control text-uppercase" placeholder="Bank">
              <label for="edit-trabank">Bank</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="edit-tracorpotype" name="edit-tracorpotype" class="form-control text-uppercase" placeholder="Coporation">
              <label for="edit-tracorpotype">Coporation</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="edit-traaccountname" name="edit-traaccountname" class="form-control text-uppercase" placeholder="Account name"> 
              <label for="edit-traaccountname">Account name</label>
            </div>
            <div class="form-floating mb-2">
              <input type="text" id="edit-traaccountnumber" name="edit-traaccountnumber" class="form-control text-uppercase" placeholder="Account number">
              <label for="edit-traaccountnumber">Account number</label>
            </div>
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
  /*Script To add Branch*/
  $("#frm-tra-edit").submit(function(event){
      event.preventDefault();
      var Branch          = '';
      var Bank            = $("#edit-trabank").val();
      var Corporation     = $("#edit-tracorpotype").val();
      var Bnkid           = $("#bank-id-edit").val();
      var Accountname     = $("#edit-traaccountname").val();
      var Accountnumber   = $("#edit-traaccountnumber").val();

      $.post("dirs/bank_accounts/actions/update_bank.php", {

          Branch  : Branch,
          Corporation      : Corporation,
          Bnkid     : Bnkid,
          Bank  : Bank,
          Accountname  : Accountname,
          Accountnumber : Accountnumber
      }, function(data){
          if($.trim(data) == "success"){
              $("#frm-tra-edit")[0].reset();
              loadIAPBanks();
              $("#mdl-edit-transfer").modal("hide");
              Swal.fire({
                  icon: 'success',
                  title: 'Update success.',
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


