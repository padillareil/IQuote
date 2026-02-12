<!-- Modal Update account -->
<div class="modal fade" id="mdl_show_account" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h4 class="text-muted">Account Security</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="password" id="setnew-password" name="setnew-password" class="form-control" placeholder="New Password">
            <label for="setnew-password">New Password</label>
          </div>
          <small class="text-muted">Create new password.</small>
          <div class="form-floating mt-3">
            <input type="password" id="setconfirm-password" name="setconfirm-password" class="form-control" placeholder="New Password">
            <label for="setconfirm-password">Confirm Password</label>
          </div>
          <small class="text-muted">Make sure both password matched.</small>
        </div>
        <div class="form-check d-flex justify-content-end mb-3">
          <input class="form-check-input" type="checkbox" id="view-password" onclick="viewPassword()">
          <label class="form-check-label text-muted ms-2" for="view-password">
            Show Password
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="saveNewPassword()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<script>
 function viewPassword() {
   const newPassword = document.getElementById('setnew-password');
   const confirmPassword = document.getElementById('setconfirm-password');
   const checkbox = document.getElementById('view-password');
   const type = checkbox.checked ? 'text' : 'password';
   newPassword.type = type;
   confirmPassword.type = type;
 }
</script>

<!-- Modal upload image -->
<form id="frm-profile">
  <div class="modal fade" id="modal-profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
        <div class="modal-header bg-secondary-subtle">
          <h5 class="modal-title">Update Profile Picture</h5>
        </div>
        <div class="modal-body text-center py-4">
          <input type="file" id="user-profile" name="user-profile" class="d-none" accept="image/png,image/jpeg" onchange="previewProfile(this)">
          <img id="profile-preview" src="../assets/image/avatar/noimage.avif" class="rounded-circle mb-3 border border-3" style="width:130px;height:130px;object-fit:cover;">
          <div>
            <button type="button" class="btn btn-outline-primary px-4" onclick="$('#user-profile').click()">
              <i class="bi bi-camera"></i> Upload Photo
            </button>
          </div>
          <small class="text-muted d-block mt-2">
            JPG or PNG • Max 2MB
          </small>
        </div>
        <div class="modal-footer justify-content-center border-0 pb-4">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check2"></i> Save
          </button>
          <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
  function previewProfile(input) {
      if (!input.files || !input.files[0]) return;

      const file = input.files[0];
      const allowed = ['image/jpeg', 'image/png'];

      if (!allowed.includes(file.type)) {
          Swal.fire('Invalid file', 'Only JPG or PNG allowed.', 'warning');
          input.value = '';
          return;
      }

      if (file.size > 2 * 1024 * 1024) {
          Swal.fire('Too large', 'Max file size is 2MB.', 'warning');
          input.value = '';
          return;
      }

      const reader = new FileReader();
      reader.onload = e => {
          $('#profile-preview').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
  }


  /*Function upload Image*/
  $("#frm-profile").submit(function(event){
      event.preventDefault();
      var formData = new FormData($("#frm-profile")[0]);
      $.ajax({
          url: "dirs/settings/actions/update_profile.php",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false, 
          success: function(data){
              if($.trim(data) === "OK"){
                  $("#modal-profile").modal("hide"); 
                  load_UserSettings(); 
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Profile uploaded successfully.',
                      timer: 2000,
                      showConfirmButton: false
                  });
                  $("#frm-profile")[0].reset();
                  $('#profile-preview').attr('src','../assets/image/avatar/noimage.avif'); 
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: data,
                      timer: 2000,
                      showConfirmButton: false
                  });
              }
          },
          error: function(){
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Network or server error.',
              });
          }
      });
  });
</script>
