<div class="modal fade" id="mdl-review-quotation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex align-items-center">
                <div>
                    <h5 class="modal-title  text-dark" id="inclusion-title">Quotation Summary</h5>
                    <p class="text-muted small mb-0" id="inclusion-info">Review approved quotation details.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           <div class="modal-body p-0"> 
                <div class="p-4 border-top border-bottom">
                    <div class="row align-items-center g-0">
                        <div class="col-md-4 border-end ps-md-4">
                            <h6 class="text-muted small d-block fw-bold">Releasing Branch</h6>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <h6 class="text-dark fw-bold mb-0" id="releasing-branch"></h6>
                            </div>
                        </div>

                        <div class="col-md-4 border-end ps-md-4">
                            <span class="text-muted small d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Quoted By</span>
                            <div class="mt-1">
                                <p class="mb-0 text-dark"><strong id="quoted-by"></strong></p>
                                <p class="mb-1 text-secondary small fw-medium" id="quoted-by-position"></p>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar3 text-primary me-1"></i> <div id="date-created"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 ps-md-4">
                            <span class="text-muted small d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Approved By</span>
                            <div class="mt-1">
                                <p class="mb-0 text-dark"><strong id="approver-name"></strong></p>
                                <p class="mb-1 text-secondary small fw-medium" id="approver-position"></p>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar3 text-primary me-1"></i> <div id="date-approved"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               <div class="p-4 overflow-auto" style="max-height: 65vh;">
                   
                   <div class="mb-5">
                       <h6 class="text-danger text-uppercase small mb-3 fw-bold">I. Customer Details</h6>
                       <div class="row g-3">
                           <div class="col-md-6 border-end">
                               <p class="mb-1 text-muted small">Representative / Company</p>
                               <p class="fs-5 fw-bold mb-0 text-dark" id="customer-name"></p>
                               <p class="text-secondary mb-0" id="customer-company">
                               </p>
                           </div>

                           <div class="col-md-6 ps-md-4">
                               <div class="row">
                                   <div class="col-6 mb-2">
                                       <p class="mb-0 text-muted small">TIN Number</p>
                                       <p class="fw-bold text-dark mb-0" id="tin-number"></p>
                                   </div>
                                   <div class="col-6 mb-2">
                                       <p class="mb-0 text-muted small">Contact Number</p>
                                       <p class="fw-bold text-dark mb-0" id="customer-contactnumber"></p>
                                   </div>
                                   <div class="col-12">
                                       <p class="mb-0 text-muted small">Customer Type</p>
                                       <p class="text-dark mb-0" id="customer-type"></p>
                                   </div>
                               </div>
                           </div>

                           <div class="col-12 mt-3">
                               <div class="p-3 border rounded-3 bg-white shadow-sm">
                                   <div class="d-flex align-items-start gap-2">
                                       <i class="bi bi-geo-alt text-danger mt-1"></i>
                                       <div>
                                           <p class="mb-1 text-muted small text-uppercase fw-bold">Customer Address</p>
                                           <p class="mb-0 text-dark" id="customer-complete-address">
                                               123 Street Name, Brgy. Central, Municipality, Province, 8000
                                           </p>
                                           <p class="mb-0 small">
                                               <span class="text-primary fw-medium">Landmark:</span> 
                                               <span class="text-secondary" id="customer-landmark"></span>
                                           </p>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="mb-5">
                            <div id="display-payment-method"></div>
                   </div>

                   <div class="mb-5">
                       <h6 class="text-danger  text-uppercase small mb-3">III. Item Order</h6>
                       <div class="table-responsive border rounded-3 overflow-hidden">
                           <table class="table table-borderless align-middle mb-0">
                               <thead class="bg-light border-bottom">
                                   <tr class="small text-muted">
                                       <th class="text-center">QTY</th>
                                       <th class="ps-3">BRAND/MODEL</th>
                                       <th class="ps-3">CATEGORY</th>
                                       <th class="text-end">UNIT PRICE</th>
                                       <th class="text-end">DISCOUNT</th>
                                       <th class="text-end pe-3">TOTAL AMOUNT</th>
                                   </tr>
                               </thead>
                               <tbody id="table-order-items">
                                    <!-- Display Order Items -->  
                                </tbody>
                           </table>

                           <div class="border-dark p-2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="pe-3 border-end border-secondary">
                                       <h6 class="text-secondary d-block text-uppercase fw-bold" style="font-size: 0.65rem;">
                                            Delivery Charge
                                        </h6>
                                        <span class="fw-bold">
                                            ₱ <span id="delivery-charge"></span>
                                        </span>
                                    </div>
                                </div>
                                       
                                <div class="text-end">
                                    <h6 class="text-secondary d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                                        Grand Total
                                    </h6>
                                     <span class="fs-4 fw-bold">
                                        ₱ <span id="grand-total"></span>
                                    </span>
                                </div>
                            </div>
                       </div>
                   </div>

                   <div class="mb-5">
                       <div class="row g-4">
                           <div class="col-md-6">
                               <h6 class="text-danger fw-bold text-uppercase small mb-3">IV. Terms & Conditions</h6>
                               <div class="ps-2 border-start border-2">
                                   <ul class="list-unstyled mb-0">

                                    <div id="termsand_conditions"></div>
                                    <!-- Display terms and conditions -->                                       
                                   </ul>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <h6 class="text-danger fw-bold text-uppercase small mb-3">V. Warranty</h6>
                               <div class="ps-2 border-start border-2">
                                   <ul class="list-unstyled mb-0">
                                       <div id="warranty_conditions"></div>
                                       <!-- Display Warranty -->
                                   </ul>
                               </div>
                           </div>
                       </div>
                   </div>

                   
                    <h6 class="text-danger  text-uppercase small mb-3">VI. Remarks</h6>
                    <h6 class="p-3 bg-warning-subtle border border-warning-subtle rounded-3 small text-dark mb-0" id="remarks">
                    </h6>

               </div>
           </div>
        </div>
    </div>
</div>





<!-- Bank Transfer, Check Design  -->
<!-- <div class="mb-5">
    <h6 class="text-danger  text-uppercase small mb-3">II. Mode of Payment</h6>
    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-4">
        <div class="display-6 text-muted"><i class="bi bi-bank"></i></div>
        <div>
            <span class="badge bg-danger mb-2">BANK TRANSFER</span>
            <p class="mb-0 text-dark ">BDO Unibank</p>
            <p class="mb-0 small text-muted">Acc Name: Retail Corp Sales | Acc No: 1234-5678-90</p>
        </div>
    </div>
</div>
 -->

 <!-- Cash  of Mode of Payment -->
<!--   <div class="mb-5">
                       <h6 class="text-danger text-uppercase small mb-3 fw-bold">II. Mode of Payment</h6>
                       <div class="p-3 border rounded-3 bg-white shadow-sm">
                           <div class="d-flex align-items-center gap-4">
                               <div class="display-6 text-primary">
                                   <i class="bi bi-cash-stack"></i>
                               </div>
                               
                               <div class="flex-grow-1">
                                   <div class="row">
                                       <div class="col-md-5 border-end">
                                           <p class="mb-0 text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Payment Method</p>
                                       </div>
                                   </div>
                                   <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-3 text-uppercase">Cash</span>
                               </div>
                           </div>
                       </div>
                   </div> -->

<!-- Debit deigndd -->
<!--  <div class="mb-5">
     <h6 class="text-danger text-uppercase small mb-3 fw-bold">II. Mode of Payment</h6>
     <div class="p-3 border rounded-3 bg-white shadow-sm">
         <div class="d-flex align-items-center gap-4">
             <div class="display-6 text-primary">
                 <i class="bi bi-credit-card"></i>
             </div>
             
             <div class="flex-grow-1">
                 <div class="row">
                     <div class="col-md-5 border-end">
                         <p class="mb-0 text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Payment Method</p>
                     </div>
                 </div>
                 <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-3 text-uppercase">Debit / Credit Card</span>
             </div>
         </div>
     </div>
 </div>
 -->
 <!-- Installment desing -->
<!--  <div class="mb-5">
     <h6 class="text-danger text-uppercase small mb-3 fw-bold">II. Mode of Payment</h6>
     <div class="p-3 border rounded-3 bg-white shadow-sm">
         <div class="d-flex align-items-center gap-4">
             <div class="display-6 text-primary">
                 <i class="bi bi-calendar-check"></i>
             </div>
             
             <div class="flex-grow-1">
                 <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-3">INSTALLMENT</span>
                 
                 <div class="row">
                     <div class="col-md-6 border-end">
                         <p class="mb-0 text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Downpayment</p>
                         <p class="mb-0 text-dark fw-bold fs-4">₱25,000.00</p>
                         <span class="text-secondary small italic">Payable upon approval</span>
                     </div>
                     
                     <div class="col-md-6 ps-md-4">
                         <p class="mb-0 text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Payment Period</p>
                         <p class="mb-0 text-dark fw-bold fs-4">2 - Months</p>
                         <span class="text-secondary small italic">Total installment period</span>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div> -->