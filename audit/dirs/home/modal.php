<!-- Modal findings Propmpt -->
<div class="modal fade" id="mdl-findings" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <input type="hidden" id="q-number">
      <div class="modal-body p-4 text-center">
        <p class="mb-0" style="font-family: sans-serif;">Do you want to save this quotation on findings?</p>
      </div>
      <div class="modal-footer flex-nowrap p-0">
        <button type="button" class="btn btn-sm btn-danger fs-6 col-6 py-3 m-0 rounded-0 border-end" onclick="saveFinginds()">
          Save
        </button>
        <button type="button" class="btn btn-sm btn-secondary fs-6 col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>


<!-- Modal show Attachment -->
<div class="modal fade" id="mdl-attachment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 text-center">
        <img src="" id="show-attachment" class="img-fluid rounded shadow-sm" alt="Attachment Preview">
      </div>
    </div>
  </div>
</div>
