
<!-- Modal Apply Manual Discount per Item -->
 <div class="modal fade" id="mdl-approval-dialog" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-sm modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-body p-4 text-center">
         <p class="mb-0">Do you want to approved this Quotation?</p>
       </div>
       <div class="modal-footer justify-content-center">
         <button type="button" class="btn btn-outline-secondary me-2" onclick="commitApproved()">Approve</button>
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
       </div>
     </div>
   </div>
 </div>



<!-- Modal reject dialog -->
<div class="modal fade" id="mdl-reject-permission" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to reject this Quotation?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="commitreject()">Reject</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal reject prompt -->
<div class="modal fade" id="mdl-reject-dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-floating mb-3">
          <textarea class="form-control" id="reject-comment" name="reject-comment" placeholder="Reason for quotation's status." style="height: 20vh;" maxlength="30"></textarea>
          <label for="reject-comment">Reason for quotation's status.</label>
        </div>
        <small class="text-muted">Maximum of 30 characters.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="commitReject()">Commit</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal onhold dialog -->
<div class="modal fade" id="mdl-onhold-dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div  class="form-floating mb-3">
          <select class="form-select" id="onhold-reason">
            <option disabled selected></option>
            <option value="Under Review">Under Review</option>
            <option value="For Final Checking">For Final Checking</option>
            <option value="Awaiting Client Feedback">Awaiting Client Feedback</option>
            <option value="Inventory Verification">Inventory Verification</option>
            <option value="Terms Negotiation Ongoing">Terms Negotiation Ongoing</option>
            <option value="Custom Adjustments Needed">Custom Adjustments Needed</option>
            <option value="Technical Validation">Technical Validation</option>
            <option value="Awaiting Budget Allocation">Awaiting Budget Allocation</option>
          </select>
          <label for="onhold-reason">Reason for On Process</label>
        </div>
<!--         <small class="text-muted">Additional Remarks(Optional)</small> -->
        <div class="form-floating mb-3">
          <textarea class="form-control" id="additional-remarks" name="additional-remarks" placeholder="Remarks" style="height: 20vh;" maxlength="30"></textarea>
          <label for="additional-remarks">Remarks</label>
        </div>
        <small class="text-muted">Maximum of 30 characters.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="commitOnhold()">Commit</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Generate Link-->
 <div class="modal fade" id="mdl-generate-link" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-sm modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-body">
         <input type="text" name="generate-link" id="generate-link" class="form-control text-center" readonly>
         <small>Reference Link.</small>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-outline-secondary me-2" onclick="copyData()">Copy</button>
         <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>

