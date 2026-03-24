<div class="modal fade" id="mdl_createho" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Account</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <p class="text-muted mb-3">Personal Details</p>
          <div class="form-floating mb-2">
            <select class="form-select" id="ho-code">
              <option selected disabled>--Account Type--</option>
              <option value="HO">HEAD OFFICE</option>
              <option value="ICBU">ICBU</option>
              <option value="ONLN">ONLINE</option>
            </select>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="ho-name" name="ho-name" class="form-control" placeholder="Name">
            <label for="ho-name">Name</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="ho-position" name="ho-position" class="form-control" placeholder="Position">
            <label for="ho-position">Position</label>
          </div>
          
          <div class="form-floating mb-2">
            <input type="text" id="ho-landline" name="ho-landline" class="form-control" placeholder="Landline">
            <label for="ho-landline">Landline</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="ho-mobile" name="ho-mobile" class="form-control" placeholder="Mobile">
            <label for="ho-mobile">Mobile</label>
          </div>
          <hr>
          <div class="form-floating mb-2">
            <input type="text" id="ho-username" name="ho-username" class="form-control" placeholder="Username">
            <label for="ho-username">Username</label>
          </div>
          <div class="form-floating mb-2">
            <input type="password" id="ho-password" name="ho-password" class="form-control" placeholder="Password">
            <label for="ho-password">Password</label>
          </div>
          <div class="form-check d-flex justify-content-end mb-3">
            <input class="form-check-input" type="checkbox" id="show-password" onclick="shwPasswrd()">
            <label class="form-check-label text-muted ms-2" for="show-password">
              Show Password
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveAccountHO()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>  
  // Auto-generate username & password
  function generateCredentials() {
    const nameField = document.getElementById("ho-name");
    const codeField = document.getElementById("ho-code");
    const usernameField = document.getElementById("ho-username");
    const passwordField = document.getElementById("ho-password");
    let name = nameField.value.trim();
    let code = codeField.value;
    if (name && code) {
      let username = code + "-" + name.replace(/\s+/g, "").toUpperCase();
      let password = name.replace(/\s+/g, "").toUpperCase();
      usernameField.value = username;
      passwordField.value = password;
    }
  }


  // Trigger when name or account type changes
  document.getElementById("ho-name").addEventListener("input", generateCredentials);
  document.getElementById("ho-code").addEventListener("change", generateCredentials);
  function shwPasswrd() {
      const passwordField = document.getElementById('ho-password');
      const checkbox = document.getElementById('show-password');
      passwordField.type = checkbox.checked ? 'text' : 'password';
  }
</script>


<!-- Modal account recovery -->
<div class="modal fade" id="mdl-account-recovery" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <small>Account Recovery</small>
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="upd-name" name="upd-name" class="form-control" placeholder="Fullname" readonly>
            <label for="upd-name">Fullname</label>
          </div>
          <input type="hidden" id="upd-username">
          <small>Create new pasword.</small>
          <div class="form-floating mb-2">
            <input type="password" id="upd-newpassword" name="upd-newpassword" class="form-control" placeholder="New Password">
            <label for="upd-newpassword">New Password</label>
          </div>
          <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="new-updpassword" onclick="shewPassword()">Show Password
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveAccRecovery()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  function shewPassword() {
      const passwordField = document.getElementById('upd-newpassword');
      const checkbox = document.getElementById('new-updpassword');
      passwordField.type = checkbox.checked ? 'text' : 'password';
  }
</script>



<!-- Modal upload image -->
<div class="modal fade" id="mdl-upload-signature" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h5 class="modal-title text-muted mb-0">Upload Signature</h5>
      </div>
      <input type="hidden" id="sig-username">
      <div class="modal-body text-center">
      <input type="file" accept=".jpg,.jpeg,.png" name="upload-signature" id="upload-signature" class="d-none">
      <div class="text-center mt-3">
        <img src="assets/image/avatar/noimage.avif" id="image-preview" alt="Upload Signature" class="shadow-sm mb-3" style="width: 300px; height: 300px; object-fit: cover;">
      </div>
        <small class="text-muted">Choose an image signature to upload.</small>
        <br>
      <a href="#" onclick="document.getElementById('upload-signature').click(); return false;">
        Upload Image
      </a>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="updateSignature()">Upload</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  var uploadInput = document.getElementById("upload-signature");
  var previewImg  = document.getElementById("image-preview");

  uploadInput.addEventListener("change", function() {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();

      reader.onload = function(e) {
        previewImg.src = e.target.result;
      };

      reader.readAsDataURL(file);
    }
  });
</script>



<!-- Modal user update details -->
<div class="modal fade" id="mdl-upd-details" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h5 class="modal-title text-muted mb-0">Update Account Details</h5>
      </div>
      <div class="modal-body">
        <div class="form-floating mb-2">
          <input type="text" id="ua-fullname" name="ua-fullname" class="form-control" placeholder="Fullname">
          <label for="ua-fullname">Fullname</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" id="ua-position" name="ua-position" class="form-control" placeholder="Position">
          <label for="ua-position">Position</label>
        </div>
        <input type="hidden" id="ua-username">
        <div class="form-floating mb-2">
          <input type="text" id="ua-landline" name="ua-landline" class="form-control" placeholder="Landline">
          <label for="ua-landline">Landline</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" id="ua-mobile" name="ua-mobile" class="form-control" placeholder="Mobile">
          <label for="ua-mobile">Mobile</label>
        </div>
        <div class="form-floating mb-2">
          <input type="email" id="ua-email" name="ua-email" class="form-control" placeholder="Email">
          <label for="ua-email">Email</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="updateAccount()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Apply enable user -->
 <div class="modal fade" id="mdl-enable" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-sm modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-body p-4 text-center">
         <p class="mb-0">Do you want to enable access this user?</p>
       </div>
       <input type="hidden" id="en-username">
       <div class="modal-footer justify-content-center">
         <button type="button" class="btn btn-outline-secondary me-2" onclick="enableUser()">Yes</button>
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
       </div>
     </div>
   </div>
 </div>

 <!-- Modal Apply block user -->
 <div class="modal fade" id="mdl-block" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-sm modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-body p-4 text-center">
         <p class="mb-0">Do you want to block access this user?</p>
       </div>
       <input type="hidden" id="blk-username">
       <div class="modal-footer justify-content-center">
         <button type="button" class="btn btn-outline-secondary me-2" onclick="disableUser()">Yes</button>
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
       </div>
     </div>
   </div>
 </div>


 <!-- Modal delete user -->
 <div class="modal fade" id="mdl-delete" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-sm modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-body p-4 text-center">
         <p class="mb-0">Do you want to delete this account?</p>
       </div>
       <input type="hidden" id="del-username">
       <div class="modal-footer justify-content-center">
         <button type="button" class="btn btn-outline-secondary me-2" onclick="deleteuser()">Yes</button>
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
       </div>
     </div>
   </div>
 </div>



 <!-- Modal user create admin -->
 <div class="modal fade" id="mdl-create-admin" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-header bg-secondary-subtle">
         <h5 class="modal-title text-muted mb-0">Create Admin Account</h5>
       </div>
       <div class="modal-body">
        <div class="form-floating mb-2">
          <input type="text" id="admin-name" name="admin-name" class="form-control" placeholder="Fullname">
          <label for="admin-name">Fullname</label>
        </div>
         <div class="form-floating mb-2">
           <input type="text" id="admin-username" name="admin-username" class="form-control" placeholder="Username">
           <label for="admin-username">Username</label>
         </div>
         <input type="hidden" id="ua-username">
         <div class="form-floating mb-2">
           <input type="password" id="admin-password" name="admin-password" class="form-control" placeholder="Password">
           <label for="admin-password">Password</label>
         </div>
         <div class="form-check d-flex justify-content-end mb-3">
           <input class="form-check-input" type="checkbox" id="showpwwrod" onclick="shwpassword()">
           <label class="form-check-label text-muted ms-2" for="showpwwrod">
             Show Password
           </label>
         </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-outline-secondary" onclick="saveAdmin()">Save</button>
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
       </div>
     </div>
   </div>
 </div>


<script> 
  function shwpassword() {
    var passwordInput = $("#admin-password");
    var toggleIcon = $("#showpwwrod");
    var isPassword = passwordInput.attr("type") === "password";
    passwordInput.attr("type", isPassword ? "text" : "password");
  }
</script>



 <!-- Modal user create regionals -->
 <div class="modal fade" id="mdl-create-regionalmanager" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-header bg-secondary-subtle">
         <h5 class="modal-title text-muted mb-0">Create Regional Manager Account</h5>
       </div>
       <div class="modal-body">
        <div class="form-floating mb-2">
          <input type="text" id="regional-name" name="regional-name" class="form-control" placeholder="Fullname">
          <label for="regional-name">Fullname</label>
        </div>
         <div class="form-floating mb-2">
           <input type="text" id="regional-position" name="regional-position" class="form-control" placeholder="Position" value="Regional Manager">
           <label for="regional-position">Position</label>
         </div>
         <div class="form-floating mb-2">
           <select class="form-select" id="regional-region">
             <option selected disabled></option>
           </select>
           <label for="regional-region">Region Assigned</label>
         </div>
         <div class="form-floating mb-2">
           <input type="text" id="regional-landline" name="regional-landline" class="form-control" placeholder="Landline">
           <label for="regional-landline">Landline</label>
         </div>
         <div class="form-floating mb-2">
           <input type="text" id="regional-mobile" name="regional-mobile" class="form-control" placeholder="Mobile">
           <label for="regional-mobile">Mobile</label>
         </div>
          <hr>
         <div class="form-floating mb-2">
           <input type="text" id="regional-username" name="regional-username" class="form-control" placeholder="Username">
           <label for="regional-username">Username</label>
         </div>
         <div class="form-floating mb-2">
           <input type="password" id="regional-password" name="regional-password" class="form-control" placeholder="Password">
           <label for="regional-password">Password</label>
         </div>
         <div class="form-check d-flex justify-content-end mb-3">
           <input class="form-check-input" type="checkbox" id="reg" onclick="shwpasswordregionale()">
           <label class="form-check-label text-muted ms-2" for="reg">
             Show Password
           </label>
         </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-outline-secondary" onclick="saveRegionalmanager()">Save</button>
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
       </div>
     </div>
   </div>
 </div>


<script> 
  function shwpasswordregionale() {
    var passwordInput = $("#regional-password");
    var toggleIcon = $("#reg");
    var isPassword = passwordInput.attr("type") === "password";
    passwordInput.attr("type", isPassword ? "text" : "password");
  }
  function generateRegionalCredentials() {
      const regionField = document.getElementById("regional-region");
      const usernameField = document.getElementById("regional-username");
      const passwordField = document.getElementById("regional-password");

      let region = regionField.value.trim();

      if (region) {
          let username = region.toUpperCase();
          let password = region.toUpperCase();

          usernameField.value = username;
          passwordField.value = password;
      }else {
          // Reset when empty
          usernameField.value = "";
          passwordField.value = "";
      }
  }
  document.getElementById("regional-region").addEventListener("change", generateRegionalCredentials);
</script>


<!-- Modal user create regionals -->
<div class="modal fade" id="mdl-create-director" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h5 class="modal-title text-muted mb-0">Create Branch Manager Account</h5>
      </div>
      <div class="modal-body">
       <div class="form-floating mb-2">
         <input type="text" id="director-name" name="director-name" class="form-control" placeholder="Fullname">
         <label for="director-name">Fullname</label>
       </div>
        <div class="form-floating mb-2">
          <input type="text" id="director-position" name="director-position" class="form-control" placeholder="Position" value="Director">
          <label for="director-position">Position</label>
        </div>
        
        <div class="form-floating mb-2">
          <input type="text" id="director-landline" name="director-landline" class="form-control" placeholder="Landline">
          <label for="director-landline">Landline</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" id="director-mobile" name="director-mobile" class="form-control" placeholder="Mobile">
          <label for="director-mobile">Mobile</label>
        </div>
         <hr>
        <div class="form-floating mb-2">
          <input type="text" id="director-username" name="director-username" class="form-control" placeholder="Username">
          <label for="director-username">Username</label>
        </div>
        <div class="form-floating mb-2">
          <input type="password" id="director-password" name="director-password" class="form-control" placeholder="Password">
          <label for="director-password">Password</label>
        </div>
        <div class="form-check d-flex justify-content-end mb-3">
          <input class="form-check-input" type="checkbox" id="directr" onclick="shwpasswordirector()">
          <label class="form-check-label text-muted ms-2" for="directr">
            Show Password
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveDirector()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script> 
  function shwpasswordirector() {
    var passwordInput = $("#director-password");
    var toggleIcon = $("#directr");
    var isPassword = passwordInput.attr("type") === "password";
    passwordInput.attr("type", isPassword ? "text" : "password");
  }
  function crtdirectoruser() {
      const nameField = document.getElementById("director-name");
      const usernameField = document.getElementById("director-username");
      const passwordField = document.getElementById("director-password");

      let fullname = nameField.value.trim();

      if (fullname) {
          let username = fullname.toUpperCase();
          let password = fullname.toUpperCase();

          usernameField.value = username;
          passwordField.value = password;
      } else {
          usernameField.value = "";
          passwordField.value = "";
      }
  }
  document.getElementById("director-name").addEventListener("input", crtdirectoruser);

</script>


<div class="modal fade" id="mdl-create-banchmanager" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h5 class="modal-title text-muted mb-0">Create Branch Manager Account</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" id="branch-code">
        <div class="form-floating mb-2">
          <select class="form-select" id="branch-asigned">
            <option selected disabled></option>
          </select>
          <label for="branch-asigned">Branch</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" id="branch-name" name="branch-name" class="form-control" placeholder="Fullname">
          <label for="branch-name">Fullname</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" id="branch-position" name="branch-position" class="form-control" placeholder="Position" value="Branch Manager">
          <label for="branch-position">Position</label>
        </div>
        <hr>
        <div class="form-floating mb-2">
          <input type="text" id="branch-username" name="branch-username" class="form-control" placeholder="Username">
          <label for="branch-username">Username</label>
        </div>
        <div class="form-floating mb-2">
          <input type="password" id="branch-password" name="branch-password" class="form-control" placeholder="Password">
          <label for="branch-password">Password</label>
        </div>
        <div class="form-check d-flex justify-content-end mb-3">
          <input class="form-check-input" type="checkbox" id="showpass" onclick="shwpassworbranch()">
          <label class="form-check-label text-muted ms-2" for="showpass">
            Show Password
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveBranchaccount()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  function shwpassworbranch() {
    const passwordInput = document.getElementById("branch-password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  }
  function crtbranchuser() {
    const nameField = document.getElementById("branch-name");
    const codeField = document.getElementById("branch-code");
    const usernameField = document.getElementById("branch-username");
    const passwordField = document.getElementById("branch-password");

    let fullname = nameField.value.trim();
    let branchCode = codeField.value.trim();

    if (fullname && branchCode) {
      let username = branchCode + "-" + fullname.replace(/\s+/g, "").toUpperCase();
      let password = fullname.replace(/\s+/g, "").toUpperCase();
      usernameField.value = username;
      passwordField.value = password;
    } else {
      usernameField.value = "";
      passwordField.value = "";
    }
  }
  document.getElementById("branch-name").addEventListener("input", crtbranchuser);
  document.getElementById("branch-code").addEventListener("input", crtbranchuser);
  function loadBranchcode(BranchName) {
    $.post("dirs/accounts/actions/get_branchcode.php", { Branch: BranchName }, function(data) {
      let response = JSON.parse(data);
      if ($.trim(response.isSuccess) === "success") {
        $("#branch-code").val(response.Data.BranchCode).trigger("input"); // triggers crtbranchuser
      } else {
        alert($.trim(response.Data));
      }
    });
  }
  $("#branch-asigned").on("change", function() {
    let branchName = $(this).val();
    loadBranchcode(branchName);
  });
</script>


<div class="modal fade" id="mdl-create-audit" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h5 class="modal-title text-muted mb-0">Create iQuote Audit</h5>
      </div>
      <div class="modal-body">
        <div class="form-floating mb-2">
          <input type="text" id="audit-fullname" name="audit-fullname" class="form-control" placeholder="Fullname">
          <label for="audit-fullname">Fullname</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" id="audit-position" name="audit-position" class="form-control" placeholder="Position">
          <label for="audit-position">Position</label>
        </div>
        <hr>
        <div class="form-floating mb-2">
          <input type="text" id="audit-username" name="audit-username" class="form-control" placeholder="Username">
          <label for="audit-username">Username</label>
        </div>
        <div class="form-floating mb-2">
          <input type="password" id="audit-password" name="c-password" class="form-control" placeholder="Password">
          <label for="audit-password">Password</label>
        </div>
        <div class="form-check d-flex justify-content-end mb-3">
          <input class="form-check-input" type="checkbox" id="showpass" onclick="shwpassworaudit()">
          <label class="form-check-label text-muted ms-2" for="showpass">
            Show Password
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveAudit()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>  
  function shwpassworaudit() {
    const passwordInput = document.getElementById("audit-password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  }
</script>


<!-- iQUote Coordinator -->
<div class="modal fade" id="mdl-create-coordinator" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h5 class="modal-title text-muted mb-0">Create iQuote Coordinator</h5>
      </div>
      <div class="modal-body">
        <div class="form-floating mb-2">
          <input type="text" id="cordinator-fullname" name="cordinator-fullname" class="form-control" placeholder="Fullname">
          <label for="cordinator-fullname">Fullname</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" id="cordinator-position" name="cordinator-position" class="form-control" placeholder="Position">
          <label for="cordinator-position">Position</label>
        </div>
        <hr>
        <div class="form-floating mb-2">
          <input type="text" id="cordinator-username" name="cordinator-username" class="form-control" placeholder="Username" value="CO-">
          <label for="cordinator-username">Username</label>
        </div>
        <div class="form-floating mb-2">
          <input type="password" id="cordinator-password" name="cordinator-password" class="form-control" placeholder="Password">
          <label for="cordinator-password">Password</label>
        </div>
        <div class="form-check d-flex justify-content-end mb-3">
          <input class="form-check-input" type="checkbox" id="showpass" onclick="shwpassworcordinator()">
          <label class="form-check-label text-muted ms-2" for="showpass">
            Show Password
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveCoordinator()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>  
  function shwpassworcordinator() {
    const passwordInput = document.getElementById("cordinator-password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  }
</script>



<!-- iQUote Coordinator -->
<form id="frm-add-encoder">
  <div class="modal fade" id="mdl-add-encoder" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-secondary-subtle">
          <h5 class="modal-title text-muted mb-0">Add iQuote Encoder</h5>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-2">
            <input type="text" id="encoder-fullname" name="encoder-fullname" class="form-control" placeholder="Fullname" required>
            <label for="encoder-fullname">Fullname</label>
          </div>
          <div class="form-floating mb-2">
            <input type="text" id="encoder-position" name="encoder-position" class="form-control" placeholder="Position" required>
            <label for="encoder-position">Position</label>
          </div>
          <div class="form-floating mb-2">
            <select class="form-select" id="encoder-role" required>
              <option selected value=""></option>
              <option value="EN">Supplies</option>
              <option value="TR">Treasury</option>
            </select>
            <label for="encoder-role">Encoder Type</label>
          </div>
          <hr>
          <div class="form-floating mb-2">
            <input type="text" id="encoder-username" name="encoder-username" class="form-control" placeholder="Username" value="EN-" required>
            <label for="encoder-username">Username</label>
          </div>
          <div class="form-floating mb-2">
            <input type="password" id="encoder-password" name="encoder-password" class="form-control" placeholder="Password" required>
            <label for="encoder-password">Password</label>
          </div>
          <div class="form-check d-flex justify-content-end mb-3">
            <input class="form-check-input" type="checkbox" id="showpass" onclick="pssswrdEncoder()">
            <label class="form-check-label text-muted ms-2" for="showpass">
              Show Password
            </label>
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


<script>  
  function pssswrdEncoder() {
    const passwordInput = document.getElementById("encoder-password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  }
</script>
