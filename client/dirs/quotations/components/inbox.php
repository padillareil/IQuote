<input type="hidden" id="qnumber-print"><!-- Contains the Quotation number -->
<div class="mt-1 mb-1">
  <input type="search" name="search-quotation" id="search-quotation" class="form-control form-control-lg" placeholder="Search">
</div>
<div class="card">
  <div class="card-body" style="height: 50vh;" id="quotation-container" >

  
    <div class="list-group list-group-flush border-bottom scrollarea">

      <div id="display-quotation"></div>
     

      <!-- Page Loader -->
      <div class="card-body d-flex justify-content-center align-items-center" style="height: 50vh;" id="quotation-container">
        <div class="text-center" id="page-loader">
          <div class="spinner-border text-danger" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <br>
          <small>Loading Please wait...</small>
        </div>
      </div>



      <!-- No Quotation Available -->
      <a href="#" class="list-group-item d-none list-group-item-action text-center py-4" id="no-quotationavailable">
        <div class="d-flex flex-column align-items-center">
          <i class="bi bi-file-earmark-text text-muted fs-1 mb-2"></i>
          <h5 class="text-muted mb-0">No Quotation Available.</h5>
        </div>
      </a>




    </div>
  </div>
  <div class="card-footer d-flex justify-content-between">
    <button class="btn btn-outline-secondary" type="button" id="btn-preview">Preview</button>
    <button class="btn btn-outline-secondary" type="button" id="btn-next">Next</button>
  </div>

</div>

<script>
  $(document).ready(function() {
    loadQuotations();
      OverlayScrollbars(document.getElementById("quotation-container"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      });
  });

    /*Function format number with comma*/
    function formatwithComma(value) {
        if (value === null || value === undefined || value === '') return '0';
        return Number(value).toLocaleString('en-US');
    }

    /*Function format date */
    function formatDateSetup(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-'); 
        const year  = parts[0];
        const day   = parts[1].padStart(2, '0');
        const month = parts[2].padStart(2, '0');
        return `${month}/${day}/${year}`;
    }

    /*Function convert datetime into correct format*/
  function convertDate(dateStr) {
      if (!dateStr || typeof dateStr !== 'string') return '';
      dateStr = dateStr.trim();
      let day, month, year;
      if (dateStr.includes('/')) {
          const parts = dateStr.split('/');
          if (parts.length !== 3) return '';
          [day, month, year] = parts;
      }
      else if (dateStr.includes('-')) {
          const parts = dateStr.split(' ')[0].split('-');
          if (parts.length !== 3) return '';
          year = parts[0];
          month = parts[1];
          day = parts[2];
      } else {
          return '';
      }
      return `${month.padStart(2, '0')}/${day.padStart(2, '0')}/${year}`;
  }


/*Function fetch data using pagination*/
  var currentPage = 1;
  var pageSize = 100; 
  var isLoading = false;
  $("#btn-preview").prop("disabled", true);
  function loadQuotations(page = 1) {
      if (isLoading) return;
      isLoading = true;
      $("#page-loader").show();
      $.post("dirs/quotations/actions/get_quotation.php", {
          CurrentPage: page,
          PageSize: pageSize
      }, function(data) {
          let response = JSON.parse(data);
          if ($.trim(response.isSuccess) === "success") {
              renderPage(response.Data);
              currentPage = page;
              $("#btn-preview").prop("disabled", currentPage === 1);
              $("#btn-next").prop("disabled", response.Data.length < pageSize);
          } else {
              alert($.trim(response.Data));
          }
      }).always(function () {
          isLoading = false;
          $("#page-loader").hide();
      });
  }
  function renderPage(pageData) {
      let $list = $("#display-quotation");
      $list.empty();

      if (!pageData || pageData.length === 0) {
          $list.append(`
              <a href="#" class="list-group-item list-group-item-action text-center py-4">
                  <i class="bi bi-file-earmark text-muted fs-1 mb-2"></i>
                  <h5 class="text-muted mb-0">No Quotation Available</h5>
              </a>
          `);
          return;
      }
      // onclick="loadInformationStatus('${item.QNUMBER}')"
      pageData.forEach(item => {
          $list.append(`
              <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between align-items-start">
                      <div>
                          <small class="text-muted">Reference No. :</small>
                          <strong class=" mb-2">${item.QNumber}</strong>
                          <br>
                          <small class="text-muted">Customer:</small>
                          <strong class=" mb-2">${item.Customer}</strong>
                          <br

                          <small class="text-muted">Status:</small>
                          <span class="badge bg-${
                              item.Status === "PENDING" ? "primary" : 
                              item.Status === "APPROVED" ? "success" : 
                              item.Status === "REJECTED" ? "danger" : 
                              item.Status === "ON HOLD" ? "primary" : 
                              item.Status === "CLOSED" ? "success" : 
                              item.Status === "CANCELLED" ? "secondary" : "dark"
                          } mb-2">${item.Status}</span>


                          <div class="mb-2">
                              <small class="text-muted d-block">Reviewed by:</small>
                              <strong>${item.Approver || ""}</strong>
                          </div>
                          <div class="mb-2">
                              <small class="text-muted d-block">Reviewed Date:</small>
                              <small>
                                  ${formatDateSetup(item.ApprovedDate || "")}
                              </small>
                          </div>  

                      </div>
                      <div class="text-end">
                          <div class="mb-2">
                              <small class="text-muted d-block">Grand Total:</small>
                              <small class="fw-bold d-block">
                                  ${formatwithComma(item.GTOTAL)}
                              </small>
                          </div>
                          <small class="text-muted d-block">${item.Day || ""}</small>
                          <small class="text-muted d-block">${item.Date || ""}</small>
                          <small class="text-muted d-block">${item.Time || ""}</small>
                          <small class="text-primary fw-bold d-block">${item.Interval || ""}</small>
                          
                      </div>
                  </div>
                  <div class="mt-3 d-flex justify-content-end gap-2">
                      <button class="btn btn-sm btn-outline-primary btn-print" name="btn-print[]" onclick="loadPrint('${item.QNumber}')" ${item.Status === "APPROVED" ? "" : "disabled"}>
                          <i class="bi bi-printer"></i> Print
                      </button>
                      <button 
                          class="btn btn-sm btn-outline-secondary ${ (item.Status === 'ON HOLD' || item.Status === 'REJECTED') ? '' : 'd-none' }" 
                          onclick="loadSeeDetails('${item.QNumber}')"
                      >
                          <i class="bi bi-chat-left-text"></i> View Details
                      </button>
                      <button class="btn btn-sm btn-outline-secondary " onclick="loadOpenQuotation('${item.QNumber}')">Open</button>

                  </div>
              </a>
          `);
      });
  }

/*Pagination button*/
  $("#btn-preview").on("click", function () {
      if (currentPage > 1) loadQuotations(currentPage - 1);
  });

  $("#btn-next").on("click", function () {
      loadQuotations(currentPage + 1);
  });

  /*Script for search*/
  $(document).ready(function () {
    $('#search-quotation').on('input', function () {
      const search = $(this).val().toLowerCase();
      $('#display-quotation a.list-group-item').each(function () {
        const status = $(this).find('[id="quote-status"]').text().toLowerCase(); // if you have a span for status
        const rowText = $(this).text().toLowerCase();

        if (status.includes(search) || rowText.includes(search)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  });


/*
  function loadOpenQuotation(QNUMBER) {
      $.post("dirs/editquotation/editquotation.php", { QNUMBER: QNUMBER }, function (data) {
          $("#load_quotations").html(data);
          loadProposedQuotation(QNUMBER);
      });
  }*/
  function loadOpenQuotation(QNumber) {
      $.post("dirs/quotations/actions/get_editquotations.php", {
          QNumber: QNumber
      }, function (data) {

          let response = JSON.parse(data);

          if ($.trim(response.isSuccess) === "success") {

              loadEditQuotation(function () {
                  $("#edit-customer").val(response.Data.Customer);
                  $("#edit-contactnumber").val(response.Data.Customernumber);
                  $("#edit-customertype").val(response.Data.CustomerType);
                  $("#edit-tinumber").val(response.Data.Tin);
                  $("#edit-qnumber").val(response.Data.QNumber);
                  $("#edit-companyname").val(response.Data.Company);
                  $("#edit-province").val(response.Data.Province);
                  $("#edit-municipality").val(response.Data.Municipality);
                  $("#edit-barangay").val(response.Data.Barangay);
                  $("#edit-street").val(response.Data.Street);
                  $("#edit-zipcode").val(response.Data.ZipCode);
                  $("#edit-landmark").val(response.Data.Landmark);
                  $("#edit-branch").val(response.Data.Branch);
                  $("#editmode-payment").val(response.Data.PaymentTerm);
                  $("#installment-period-edit").val(response.Data.TERMS);
                  $("#downpayment-edit").val(response.Data.Downpayment);
                  $("#edit-transferbank").val(response.Data.BnkTrasnfer);
                  $("#transfer-edit-accountname").val(response.Data.BnkTraAccnname);
                  $("#transfer-edit-accountnumber").val(response.Data.BnkTraAccnum);
                  $("#edit-checkbank").val(response.Data.BnkTrasnfer);
                  $("#bank-accountnamecheck").val(response.Data.BnkTraAccnname);
                  $("#bank-accountnumbercheck").val(response.Data.BnkTraAccnum);
                  $("#edit-remarks").val(response.Data.Remarks);
                  $("#preparedby").val(response.Data.Preparedby);
                  $("#datecreated").val(convertDate(response.Data.DocDate));
                  $("#edit-deliverycharge").val(formatwithComma(response.Data.Deliverycharge));
                  $("#edit-grandtotal").val(formatwithComma(response.Data.GrandTotal));

                  //Button actions condition
                  var btnAction = response.Data.QSTATUS;
                  if (["APPROVED", "REJECTED", "CANCELLED", "EXPIRED", "CLOSED"].includes(btnAction)) {
                      $("#btn-approved, #btn-onhold, #btn-reject").addClass("d-none");
                  } else if (btnAction === "ON HOLD") {
                      $("#btn-onhold").addClass("d-none");
                  }


                  // Payment Method Condition
                  var paymentTerm = response.Data.PaymentTerm;
                  $("#installment-field").addClass('d-none');
                  $("#checkbank-edit").addClass('d-none');
                  $("#banktransfer-edit").addClass('d-none');

                  switch (paymentTerm) {
                      case 'Cash':
                      case 'Debit/Credit Card':
                          break;
                      case 'Installment':
                          $("#installment-field").removeClass('d-none');
                          break;
                      case 'Check':
                          $("#checkbank-edit").removeClass('d-none');
                          break;
                      case 'Bank Transfer':
                          $("#banktransfer-edit").removeClass('d-none');
                          break;

                      default:
                          console.warn("Unknown payment term:", paymentTerm);
                          break;
                  }
                  /*Customer Type Condition*/
                  var customerType = response.Data.CustomerType;
                  if (customerType === 'PERSONAL') {
                      $("#customer-company").addClass('d-none');
                  } else {
                      $("#customer-company").removeClass('d-none');
                  }

                  var d = {Orders: response.Orders};

                  $("#item-orders").html("");
                  d.Orders.forEach(function (item) {
                      let orderHtml = `
                          <div class="row mb-3 border-bottom pb-2 edit-item-order" data-itemid="${item.ORDR_ID}">
                              <input type="hidden" name="order-id[]" class="order-id" value="${item.ORDR_ID}">
                              <input type="hidden" name="price-limit[]" class="price-limit" value="${item.PriceLimit}">
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="text" name="edit-brand[]" class="form-control" readonly value="${item.Brand}">
                                      <label>Brand</label>
                                  </div>
                              </div>
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="text" name="edit-model[]" class="form-control" readonly value="${item.Model}">
                                      <label>Model</label>
                                  </div>
                              </div>
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="text" name="edit-category[]" class="form-control" readonly value="${item.CATEGORY}">
                                      <label>Category</label>
                                  </div>
                              </div>
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="text" name="edit-sellingprice[]" class="form-control edit-sellingprice" readonly value="${formatwithComma(item.SellingPrice)}">
                                      <label>SRP/ Unit Price</label>
                                  </div>
                              </div>
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="number" name="edit-quantity[]" class="form-control edit-quantity" readonly value="${item.Quantity}">
                                      <label>Quantity</label>
                                  </div>
                              </div>
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="number" name="edit-discountperunit[]" class="form-control edit-discountperunit" readonly value="${item.Discount}">
                                      <label>Discount Per Unit</label>
                                  </div>
                              </div>
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="text" name="edit-discountedamountperunit[]" class="form-control edit-discountedamountperunit" readonly value="${formatwithComma(item.DiscountedAmount)}">
                                      <label>Discounted Amount Per Unit</label>
                                  </div>
                              </div>
                              <input type="hidden" name="pricelimit-sum[]" class="pricelimit-sum pricelimit-sum" value="${item.PriceLimitSum}">
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="text" name="edit-grosstotal[]" class="form-control edit-grosstotal" readonly value="${formatwithComma(item.TotalAmount)}">
                                      <label>Gross Total</label>
                                  </div>
                              </div>
                              <div class="col-md-6 mb-2">
                                  <div class="form-floating mb-2">
                                      <input type="text" name="edit-manualdiscount[]" class="form-control bg-white edit-manualdiscount" readonly value="${formatwithComma(item.ManualDiscount)}">
                                      <label>Discount Amount</label>
                                  </div>
                              </div>

                             <input type="hidden" class="original-totalamount" value="${item.TotalAmount}">
                             <input type="hidden" class="original-discount" value="${item.Discount}">
                             <input type="hidden" class="original-discountedamount" value="${item.DiscountedAmount}">



                          </div>
                      `;
                      $("#item-orders").append(orderHtml);
                  });
                              // <div class="justify-content-end d-flex">
                              //     <button class="btn btn-outline-secondary me-2" type="button" onclick="reapplyManualDiscount(this)">Apply Manual Discount</button>
                              // </div>

                     // TERMS & CONDITIONS
                  $("#termscondition-container").empty();
                  if (response.Terms && response.Terms.length > 0) {
                      $.each(response.Terms, function (index, term) {
                          $("#termscondition-container").append(`
                              <div class="col-md-12 mb-2 termscondition">
                                  <div class="input-group">
                                      <textarea
                                          class="form-control bg-white edit-termscondition" readonly
                                          name="edit-termscondition"
                                          style="height: 10vh;"
                                      >${term.TermsCondition}</textarea>
                                  </div>

                                  <input
                                      type="hidden"
                                      name="terms-id[]"
                                      class="terms-id"
                                      value="${term.TRMS_ID}"
                                  >
                              </div>
                          `);

                      });
                  }

                     // WARRANTY & CONDITIONS
                  $("#warranty-container").empty();
                  if (response.Warranty && response.Warranty.length > 0) {
                      $.each(response.Warranty, function (index, warranty) {

                          $("#warranty-container").append(`
                              <div class="col-md-12 mb-2 warranty">
                                  <div class="input-group">
                                      <textarea
                                          class="form-control bg-white edit-warranty" readonly
                                          name="edit-warranty"
                                          style="height: 10vh;"
                                      >${warranty.Warranty}</textarea>
                                  </div>

                                  <input
                                      type="hidden"
                                      name="warranty-id[]"
                                      class="warranty-id"
                                      value="${warranty.WRRNTY_ID}"
                                  >
                              </div>
                          `);

                      });
                  }




                  
              });

          } else {
              alert($.trim(response.Data));
          }
      });
  }



  /*Function to verify quotation*/
       function verifyLoadNumber() {
         $("#mdl-verify").modal("hide");
           QNumber =  $("#very-quote-serial").val();
           $.post("dirs/quotations/actions/get_editquotations.php", {
               QNumber: QNumber
           }, function (data) {

               let response = JSON.parse(data);

               if ($.trim(response.isSuccess) === "success") {

                   loadEditQuotation(function () {
                       $("#edit-customer").val(response.Data.Customer);
                       $("#edit-contactnumber").val(response.Data.Customernumber);
                       $("#edit-customertype").val(response.Data.CustomerType);
                       $("#edit-tinumber").val(response.Data.Tin);
                       $("#edit-qnumber").val(response.Data.QNumber);
                       $("#edit-companyname").val(response.Data.Company);
                       $("#edit-province").val(response.Data.Province);
                       $("#edit-municipality").val(response.Data.Municipality);
                       $("#edit-barangay").val(response.Data.Barangay);
                       $("#edit-street").val(response.Data.Street);
                       $("#edit-zipcode").val(response.Data.ZipCode);
                       $("#edit-landmark").val(response.Data.Landmark);
                       $("#edit-branch").val(response.Data.Branch);
                       $("#editmode-payment").val(response.Data.PaymentTerm);
                       $("#installment-period-edit").val(response.Data.TERMS);
                       $("#downpayment-edit").val(response.Data.Downpayment);
                       $("#edit-transferbank").val(response.Data.BnkTrasnfer);
                       $("#transfer-edit-accountname").val(response.Data.BnkTraAccnname);
                       $("#transfer-edit-accountnumber").val(response.Data.BnkTraAccnum);
                       $("#edit-checkbank").val(response.Data.BnkTrasnfer);
                       $("#bank-accountnamecheck").val(response.Data.BnkTraAccnname);
                       $("#bank-accountnumbercheck").val(response.Data.BnkTraAccnum);
                       $("#edit-remarks").val(response.Data.Remarks);
                       $("#preparedby").val(response.Data.Preparedby);
                       $("#datecreated").val(convertDate(response.Data.DocDate));
                       $("#edit-deliverycharge").val(formatwithComma(response.Data.Deliverycharge));
                       $("#edit-grandtotal").val(formatwithComma(response.Data.GrandTotal));

                       //Button actions condition
                       var btnAction = response.Data.QSTATUS;
                       if (["APPROVED", "REJECTED", "CANCELLED", "EXPIRED", "CLOSED"].includes(btnAction)) {
                           $("#btn-approved, #btn-onhold, #btn-reject").addClass("d-none");
                       } else if (btnAction === "ON HOLD") {
                           $("#btn-onhold").addClass("d-none");
                       }


                       // Payment Method Condition
                       var paymentTerm = response.Data.PaymentTerm;
                       $("#installment-field").addClass('d-none');
                       $("#checkbank-edit").addClass('d-none');
                       $("#banktransfer-edit").addClass('d-none');

                       switch (paymentTerm) {
                           case 'Cash':
                           case 'Debit/Credit Card':
                               break;
                           case 'Installment':
                               $("#installment-field").removeClass('d-none');
                               break;
                           case 'Check':
                               $("#checkbank-edit").removeClass('d-none');
                               break;
                           case 'Bank Transfer':
                               $("#banktransfer-edit").removeClass('d-none');
                               break;

                           default:
                               console.warn("Unknown payment term:", paymentTerm);
                               break;
                       }
                       /*Customer Type Condition*/
                       var customerType = response.Data.CustomerType;
                       if (customerType === 'PERSONAL') {
                           $("#customer-company").addClass('d-none');
                       } else {
                           $("#customer-company").removeClass('d-none');
                       }

                       var d = {Orders: response.Orders};

                       $("#item-orders").html("");
                       d.Orders.forEach(function (item) {
                           let orderHtml = `
                               <div class="row mb-3 border-bottom pb-2 edit-item-order" data-itemid="${item.ORDR_ID}">
                                   <input type="hidden" name="order-id[]" class="order-id" value="${item.ORDR_ID}">
                                   <input type="hidden" name="price-limit[]" class="price-limit" value="${item.PriceLimit}">
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="text" name="edit-brand[]" class="form-control" readonly value="${item.Brand}">
                                           <label>Brand</label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="text" name="edit-model[]" class="form-control" readonly value="${item.Model}">
                                           <label>Model</label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="text" name="edit-category[]" class="form-control" readonly value="${item.CATEGORY}">
                                           <label>Category</label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="text" name="edit-sellingprice[]" class="form-control edit-sellingprice" readonly value="${formatwithComma(item.SellingPrice)}">
                                           <label>SRP/ Unit Price</label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="number" name="edit-quantity[]" class="form-control edit-quantity" readonly value="${item.Quantity}">
                                           <label>Quantity</label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="number" name="edit-discountperunit[]" class="form-control edit-discountperunit" readonly value="${formatwithComma(item.Discount)}">
                                           <label>Discount Per Unit</label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="text" name="edit-discountedamountperunit[]" class="form-control edit-discountedamountperunit" readonly value="${formatwithComma(item.DiscountedAmount)}">
                                           <label>Discounted Amount Per Unit</label>
                                       </div>
                                   </div>
                                   <input type="hidden" name="pricelimit-sum[]" class="pricelimit-sum pricelimit-sum" value="${item.PriceLimitSum}">
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="text" name="edit-grosstotal[]" class="form-control edit-grosstotal" readonly value="${formatwithComma(item.TotalAmount)}">
                                           <label>Gross Total</label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-2">
                                       <div class="form-floating mb-2">
                                           <input type="text" name="edit-manualdiscount[]" class="form-control border border-warning edit-manualdiscount" value="${formatwithComma(item.ManualDiscount)}">
                                           <label>Manual Discount</label>
                                       </div>
                                   </div>

                                  <input type="hidden" class="original-totalamount" value="${item.TotalAmount}">
                                  <input type="hidden" class="original-discount" value="${item.Discount}">
                                  <input type="hidden" class="original-discountedamount" value="${item.DiscountedAmount}">



                                   <div class="justify-content-end d-flex">
                                       <button class="btn btn-outline-secondary me-2" type="button" onclick="reapplyManualDiscount(this)">Apply Manual Discount</button>
                                   </div>
                               </div>
                           `;
                           $("#item-orders").append(orderHtml);
                       });

                          // TERMS & CONDITIONS
                       $("#termscondition-container").empty();
                       if (response.Terms && response.Terms.length > 0) {
                           $.each(response.Terms, function (index, term) {
                               $("#termscondition-container").append(`
                                   <div class="col-md-12 mb-2 termscondition">
                                       <div class="input-group">
                                           <textarea
                                               class="form-control border border-warning edit-termscondition"
                                               name="edit-termscondition"
                                               style="height: 10vh;"
                                           >${term.TermsCondition}</textarea>
                                       </div>

                                       <input
                                           type="hidden"
                                           name="terms-id[]"
                                           class="terms-id"
                                           value="${term.TRMS_ID}"
                                       >
                                   </div>
                               `);

                           });
                       }

                          // WARRANTY & CONDITIONS
                       $("#warranty-container").empty();
                       if (response.Warranty && response.Warranty.length > 0) {
                           $.each(response.Warranty, function (index, warranty) {

                               $("#warranty-container").append(`
                                   <div class="col-md-12 mb-2 warranty">
                                       <div class="input-group">
                                           <textarea
                                               class="form-control border border-warning edit-warranty"
                                               name="edit-warranty"
                                               style="height: 10vh;"
                                           >${warranty.Warranty}</textarea>
                                       </div>

                                       <input
                                           type="hidden"
                                           name="warranty-id[]"
                                           class="warranty-id"
                                           value="${warranty.WRRNTY_ID}"
                                       >
                                   </div>
                               `);

                           });
                       }
                   });

               } else {
                   alert($.trim(response.Data));
               }
           });
       }


  /*Function display next page*/
    function loadEditQuotation(callback) {
        $.post("dirs/quotations/edit/main.php", function (data) {
            $("#load_quotations").html(data);
            if (typeof callback === "function") {
                callback();
            }
        });
    }



/*Input Manual Discount Format with comma and only number allowed*/
 $(document).ready(function () {
     $(document).on("input", ".edit-manualdiscount", function () {
         let val = $(this).val();
         val = val.replace(/\D/g, "");
         if (val === "" || parseInt(val) < 0) {
             $(this).val('');
         } else {
             val = parseInt(val, 10).toLocaleString();
             $(this).val(val);
         }
     });
 });


 /*Function to show quotation number for printing preference*/
  function loadPrint(QNumber){
     $("#mdl-printing-preference").modal('show');
      $.post("dirs/quotations/actions/get_quotenumber.php",{
          QNUMBER : QNumber
      },function(data){
          response = JSON.parse(data);
          if(jQuery.trim(response.isSuccess) == "success"){
              $("#qnumber-print").val(response.Data.QNumber);
          }else{
              alert(jQuery.trim(response.Data));
          }
      });
  }

 /*Function for single pager pdf*/
  function pdfSinglePage(){
     var QNumber = $("#qnumber-print").val();
      $.post("dirs/quotations/actions/get_refnumber.php", {
          QNumber : QNumber
      }, function(data){
          let response = JSON.parse(data);
          if($.trim(response.isSuccess) === "success"){
              if (response.Data.QStatus === 'APPROVED') {
                  
                  // Create hidden form to send QNumber via POST
                  let form = document.createElement("form");
                  form.method = "POST";
                  form.action = "../pdf/format_1/iQuote.php";
                  form.target = "_blank"; // open in new tab
                  let input = document.createElement("input");
                  input.type = "hidden";
                  input.name = "QNumber";
                  input.value = response.Data.QNumber;
                  form.appendChild(input);
                  
                  document.body.appendChild(form);
                  form.submit();
                  document.body.removeChild(form);
              } 
          } else {
              alert($.trim(response.Data));
          }
      });
  }

  /*Function for multiple pager pdf*/
   function pdfMultiplePage(){
      var QNumber = $("#qnumber-print").val();
       $.post("dirs/quotations/actions/get_refnumber.php", {
           QNumber : QNumber
       }, function(data){
           let response = JSON.parse(data);
           if($.trim(response.isSuccess) === "success"){
               if (response.Data.QStatus === 'APPROVED') {
                   
                   // Create hidden form to send QNumber via POST
                   let form = document.createElement("form");
                   form.method = "POST";
                   form.action = "../pdf/format_2/iQuote.php";
                   form.target = "_blank"; // open in new tab
                   let input = document.createElement("input");
                   input.type = "hidden";
                   input.name = "QNumber";
                   input.value = response.Data.QNumber;
                   form.appendChild(input);
                   
                   document.body.appendChild(form);
                   form.submit();
                   document.body.removeChild(form);
               } 
           } else {
               alert($.trim(response.Data));
           }
       });
   }
 
</script>

