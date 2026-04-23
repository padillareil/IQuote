$(document).ready(function(){
    loadAllQuoation();
});


function loadAllQuoation() {
    $.post("dirs/quotation_list/components/main.php", {
    }, function (data){
        $("#load_AllQuotations").html(data);
        loadIAPBranch();
        loadApprovedQuotation();
    });
}


/*Load Imperial branches*/
function loadIAPBranch() {
  $.post("dirs/quotation_list/actions/get_branch.php", {}, function (data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
      const branches = response.Data;
      $("#select-branch").html('<option selected value="">----</option>');
      branches.forEach((branch) => {
        $("#select-branch").append(
          $("<option>", {
            value: branch.Branch,
            text: branch.Branch,
          })
        );
      });

    } else {
      alert($.trim(response.Data));
    }
  });
}


/*Function to review Quotation Content*/
/*function viewQuotation() {
  $("#mdl-review-quotation").modal('show');
}*/

function viewQuotation(QNumber){
  $("#mdl-review-quotation").modal('show');
    $.post("dirs/quotation_list/actions/get_reviewquotation.php",{
        QNumber : QNumber
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#releasing-branch").text(response.Header.Branch);
            $("#quoted-by").text(response.Header.Fullname);
            $("#quoted-by-position").text(response.Header.QuoteCreatorPosition);
            $("#date-created").text(formatDate(response.Header.CREATED_DATE));
            $("#approver-name").text(response.Header.ApproverName);
            $("#approver-position").text(response.Header.ApproverPosition);
            $("#date-approved").text(formatDate(response.Header.ApprovedDate));
            $("#customer-name").text(response.Header.Customer);

            $("#customer-company").text(
              response.Header.Company === "Personal"
                ? ''
                : (response.Header.Company ?? '')
            );

            $("#tin-number").text(
              response.Header?.TIN && response.Header.TIN.trim() !== ''
                ? response.Header.TIN
                : '---'
            );
            $("#customer-contactnumber").text(response.Header.Contact);
            $("#customer-type").text(response.Header.CustomerType);
            const h = response.Header;
            const addressParts = [];
            if (h.Street?.trim()) addressParts.push(h.Street);
            if (h.Barangay?.trim()) addressParts.push(`BRGY. ${h.Barangay}`);
            if (h.Municipality?.trim()) addressParts.push(h.Municipality);
            if (h.Province?.trim()) addressParts.push(h.Province);
            if (h.ZipCode && h.ZipCode !== "0" && h.ZipCode !== 0) {
                addressParts.push(h.ZipCode);
            }

            $("#customer-complete-address").text(addressParts.join(', '));
            $("#customer-landmark").text(
              response.Header?.Landmark && response.Header.Landmark.trim() !== ''
                ? response.Header.Landmark
                : 'N/A'
            );

            const pterms = response.Header?.PTERMS;

            let html = '';

            switch (pterms) {

              case 'Cash':
                html = `
                  <div class="mb-5">
                    <h6 class="text-danger text-uppercase small mb-3 fw-bold">II. Mode of Payment</h6>
                    <div class="p-3 border rounded-3 bg-white shadow-sm">
                      <div class="d-flex align-items-center gap-4">
                        <div class="display-6">
                          <i class="bi bi-cash-stack"></i>
                        </div>

                        <div class="flex-grow-1">
                          <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase">
                            Cash
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                `;
                break;

              case 'Debit/Credit Card':
                html = `
                  <div class="mb-5">
                    <h6 class="text-danger text-uppercase small mb-3 fw-bold">II. Mode of Payment</h6>
                    <div class="p-3 border rounded-3 bg-white shadow-sm">
                      <div class="d-flex align-items-center gap-4">
                        <div class="display-6">
                          <i class="bi bi-credit-card"></i>
                        </div>

                        <div class="flex-grow-1">
                          <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase">
                            Debit / Credit Card
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                `;
                break;

              case 'Bank Transfer':
                html = `
                  <div class="mb-5">
                    <h6 class="text-danger text-uppercase small mb-3 fw-bold">II. Mode of Payment</h6>
                    <div class="p-3 border rounded-3 bg-white shadow-sm d-flex align-items-center gap-4">
                      <div class="display-6 text-muted">
                        <i class="bi bi-bank"></i>
                      </div>

                      <div>
                        <span class="badge bg-danger mb-2 text-uppercase">Bank Transfer</span>
                        <p class="mb-0 text-dark">${response.Header.BANK ?? ''}</p>
                        <p class="mb-0 small text-muted">
                          Account Name: ${response.Header.ACCOUNTNAME ?? ''} |
                          Account No: ${response.Header.ACCNUM ?? ''}
                        </p>
                      </div>
                    </div>
                  </div>
                `;
                break;
              case 'Check':
                html = `
                  <div class="mb-5">
                    <h6 class="text-danger text-uppercase small mb-3 fw-bold">II. Mode of Payment</h6>
                    <div class="p-3 border rounded-3 bg-white shadow-sm d-flex align-items-center gap-4">
                      <div class="display-6 text-muted">
                        <i class="bi bi-bank"></i>
                      </div>

                      <div>
                        <span class="badge bg-danger mb-2 text-uppercase">Bank Transfer</span>
                        <p class="mb-0 text-dark">${response.Header.CorpBank ?? ''}</p>
                        <p class="mb-0 small text-muted">
                          Account Name: ${response.Header.CorpAccountName ?? ''} |
                          Account No: ${response.Header.CorpAccountNumber ?? ''}
                        </p>
                      </div>
                    </div>
                  </div>
                `;
                break;

                case 'Installment':
                  html = `
                    <div class="mb-5">
                      <h6 class="text-danger text-uppercase small mb-3 fw-bold">
                        II. Mode of Payment
                      </h6>
                      <div class="p-3 border rounded-3 bg-white shadow-sm">
                        <div class="d-flex align-items-start gap-4">
                          <div class="display-6">
                            <i class="bi bi-percent"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase mb-3">
                              Installment
                            </span>
                            <div class="row">
                              <div class="col-md-6 border-end">
                                <p class="mb-0 text-muted small text-uppercase fw-bold">
                                  Downpayment
                                </p>
                                <p class="mb-0 text-dark fw-bold fs-4">
                                  ${response.Header.DownPayment ?? '---'}
                                </p>
                                <span class="text-muted small">Payable upon approval</span>
                              </div>
                              <div class="col-md-6 ps-md-4">
                                <p class="mb-0 text-muted small text-uppercase fw-bold">
                                  Payment Period
                                </p>
                                <p class="mb-0 text-dark fw-bold fs-4">
                                  ${response.Header.TERMS ?? '---'}
                                </p>
                                <span class="text-muted small">Total installment duration</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  `;
                  break;
              

              default:
                html = '';
            }

            $("#display-payment-method").html(html);


            $("#delivery-charge").text(formatComma(response.Header.DeliveryCharge));
            $("#grand-total").text(formatComma(response.Header.GrandTotal));





        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}