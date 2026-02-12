<!-- Modal Apply Manual Discount per Item -->
<div class="modal fade" id="mdl-" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Manual Discount</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="apply-manualdisc" name="apply-manualdisc" class="form-control" placeholder="Discount">
            <label for="apply-manualdisc">Discount</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary">Apply</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Verify Quotation using its serial number -->
<div class="modal fade" id="mdl-verify" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary-subtle">
        <h1 class="modal-title text-muted fs-5" id="staticBackdropLabel">Verify Quotation</h1>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <div class="form-floating mb-2">
            <input type="text" id="very-quote-serial" name="very-quote-serial" class="form-control text-uppercase" placeholder="Serial">
            <label for="very-quote-serial">Serial</label>
            <small class="text-muted mb-0">Please enter a valid serial number.</small>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary">Verify</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Set Filter Date Range -->
<div class="modal fade" id="mdl-set-daterange" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <small class="text-muted mb-4">Filter quotations by branch and date range.</small>
        <div class="form-floating mb-2">
          <select class="form-select" id="filter-branch" name="filter-branch">
          <option selected disabled></option>
          </select>
          <label for="filter-branch">Store Branch</label>
        </div>

        <div class="form-floating mb-3">
          <input type="date" name="date-from" id="date-from" class="form-control" placeholder="Date From">
          <label for="date-from">Date From</label>
        </div>
        <div class="form-floating mb-3">
          <input type="date" name="date-to" id="date-to" class="form-control" placeholder="Date To">
          <label for="date-to">Date To</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary">Load</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Set Filter Date Range -->
<div class="modal fade" id="mdl-select-branch" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <small class="text-muted mb-4">Filter branch.</small>
        <div class="form-floating mb-2">
          <select class="form-select" id="filter-storebranch" name="filter-storebranch">
          <option selected disabled></option>
          </select>
          <label for="filter-storebranch">Store Branch</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary">Load</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal quotation feedback -->
<div class="modal fade" id="mdl-quote-status" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Quotation Reason</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-floating mb-3">
          <textarea class="form-control" id="qutation-info" name="qutation-info" placeholder="Reason" style="height: 20vh;" readonly></textarea>
          <label for="qutation-info">Reason</label>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal status  -->
 <div class="modal fade" id="mdl-quotestatus-dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-body">
         <small class="text-muted">Reason for quotation’s status.</small>
         <div  class="form-floating mb-3" id="onhold-reasonfield">
          <input type="text" name="onhold-reasonstatus" id="onhold-reasonstatus" class="form-control" placeholder="Reason" readonly>
          <label for="onhold-reasonstatus">Reason</label>
         </div>
         <!-- <small class="text-muted">Additional Remarks(Optional)</small> -->
         <div class="form-floating mb-3">
           <textarea class="form-control" id="additional-remarksstatus" name="additional-remarksstatus" placeholder="Remarks" style="height: 20vh;" readonly></textarea>
           <label for="additional-remarksstatus">Remarks</label>
         </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>

 <!-- Toast for Network Error -->
  <div class="position-fixed top-50 start-50 translate-middle p-3" style="z-index: 1050;">
    <div id="toast-network-error" class="toast align-items-center border-0 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-body bg-light border border-danger rounded d-flex align-items-center">
        <i class="bi bi-wifi-off text-secondary fs-3 me-3"></i>
        <div>
          <div class="fw-bold text-dark mb-1">Network Failed</div>
          <small class="text-muted">Please try again. <span id="quotation-id"></span></small>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast for Loading Information -->
  <div class="position-fixed top-50 start-50 translate-middle p-3" style="z-index: 1050;">
    <div id="toast-loading-information" class="toast align-items-center border-0 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-body bg-light border border-danger rounded d-flex align-items-center">
       <div class="spinner-border  me-3 text-danger" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <div>
          <div class="fw-bold text-dark mb-1">Please wait...</div>
          <small class="text-muted">Loading data. This may take a moment.<span id="quotation-id"></span></small>
        </div>
      </div>
    </div>
  </div>


  <!-- Toast block click background -->
  <div id="toast-overlay" 
       style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
              background:rgba(0,0,0,0.1); z-index:1049; cursor:not-allowed;">
  </div>

  <!-- Modal printing form prefrence -->
  <div class="modal fade" id="mdl-printing-preference" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center px-4 pt-3 pb-4">
          <div class="mb-3">
            <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
          </div>

          <h6 class="fw-semibold mb-1">Choose a PDF layout</h6>
          <p class="text-muted small mb-0">
            Select how the quotation will be formatted.
          </p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-primary me-2" title="Quotation PDF with multiple items displayed on a single page" onclick="pdfSinglePage()">PDF 1</button>
          <button type="button" class="btn btn-outline-primary" title="Quotation PDF with multiple items split across multiple pages" onclick="pdfMultiplePage()">PDF 2</button>
        </div>
      </div>
    </div>
  </div>