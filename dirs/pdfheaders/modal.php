<!-- Modal upload image -->
<div class="modal fade" id="mdl-upload-header" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h5 class="modal-title text-muted mb-0">Upload Photo</h5>
      </div>
      <div class="modal-body text-center">
        <div class="form-floating mb-2">
          <select class="form-select" id="pdf-corporation">
            <option selected disabled></option>
            <option value="SOLU TRADING CORPORATION">SOLU TRADING CORPORATION</option>
            <option value="VIC IMPERIAL APPLIANCE CORPORATION">VIC IMPERIAL APPLIANCE CORPORATION</option>
            <option value="NOLU MARKETING CORPORATION">NOLU MARKETING CORPORATION</option>
            <option value="ALPHAMIN COMMERCIAL CORPORATION">ALPHAMIN COMMERCIAL CORPORATION</option>
          </select>
          <label for="pdf-corporation">Corporation</label>
        </div>
      <input type="file" accept="image/*" name="upload-image-pdfheader" id="upload-image-pdfheader" class="d-none">
      <div class="text-center mt-3">
        <img src="#" id="image-preview" alt="PDF Header Image" class="shadow-sm mb-3"  style="width: 500px; height: 500px; object-fit: contain; background-color: #f8f9fa;">
      </div>
        <small class="text-muted">Choose an image to upload.</small>
        <br>
      <a href="#" onclick="document.getElementById('upload-image-pdfheader').click(); return false;">
        Upload Image
      </a>
      </div>
      <input type="hidden" id="image-id">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" id="btn-save" onclick="uploadHeader()">Save</button>
        <button type="button" class="btn btn-outline-secondary me-2 d-none" id="btn-update" onclick="updateHeader()">Save</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  var uploadInput = document.getElementById("upload-image-pdfheader");
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


<!-- Modal delete header -->
<div class="modal fade" id="mdl-delete-header" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to delete this header?</p>
      </div>
      <input type="hidden" id="del-header">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="delHeader()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
