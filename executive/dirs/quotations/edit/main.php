<!-- Nav Pills -->
<ul class="nav nav-pills nav-fill justify-content-center d-none">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#editcustomer">Customer</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#editpayment">Payment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#editorder">Order</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#edittermscondition">Terms & Condition</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#editwarranty">Warranty</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#editremarks">Finish</a>
  </li>
</ul>
<div class="mb-2 mt-2">
  <div class="card shadow-sm border-0 bg-light">
    <div class="card-body d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <div class="me-3">
          <img src="../assets/image/icon/logo.png" alt="iQuote Logo" style="width: 8vh; height: 8vh; border-radius: 8px;">
        </div>
        <div>
          <h4 class="mb-1 fw-bold text-danger">Review Quotation</h4>
         <p class="mb-0 text-muted small">
             Review the details before proceeding with approval.
          </p>
        </div>
      </div>

      <!-- Dropdown Button -->
      <div class="dropdown">
        <button class="btn bi bi-list btn-outline-secondary" type="button" id="action-menu" data-bs-toggle="dropdown" aria-expanded="false">
        </button>
        <ul class="dropdown-menu" aria-labelledby="action-menu">
          <li><a class="dropdown-item" href="#" onclick="loadInbox()"><i class="bi bi-arrow-return-left me-2"></i>Back</a></li>
          <li><a class="dropdown-item" id="btn-approved" href="#" onclick="mdlApproval()"><i class="bi bi-check2 me-2"></i>Approve</a></li>
          <li><a class="dropdown-item" id="btn-onhold" href="#" onclick="mdlOnhold()"><i class="bi bi-check2 me-2"></i>Onhold</a></li>
          <li><a class="dropdown-item" id="btn-reject" href="#" onclick="mdlReject()"><i class="bi bi-x-lg me-2"></i>Reject</a></li>
          <li><a class="dropdown-item" id="btn-generate" href="#" onclick="mdllink()"><i class="bi bi-link me-2"></i>Generate Link</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


<!-- Card Content -->
<div class="card mt-2 shadow">
  <div class="card-body">
    <div class="tab-content mt-3">
      <div class="tab-pane fade show active" id="editcustomer">
        <?php include 'customer.php'; ?>
      </div>
      <div class="tab-pane fade" id="editpayment">
        <?php include 'payment.php'; ?>
      </div>
      <div class="tab-pane fade" id="editorder">
        <?php include 'order.php'; ?>
      </div>
      <div class="tab-pane fade" id="edittermscondition">
        <?php include 'termscondition.php'; ?>
      </div>
      <div class="tab-pane fade" id="editwarranty">
        <?php include 'warranty.php'; ?>
      </div>
      <div class="tab-pane fade" id="editremarks">
        <?php include 'remarks.php'; ?>
      </div>
    </div>
  </div>
</div>
<div class="card shadow mt-2">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 mb-2">
        <div class="form-floating">
          <input type="text" id="preparedby" name="preparedby" class="form-control" placeholder="Prepared by" readonly>
          <label for="preparedby">Prepared by</label>
        </div>
      </div>
      <div class="col-md-6 mb-2">
        <div class="form-floating">
          <input type="text" id="datecreated" name="datecreated" class="form-control" placeholder="Date Created" readonly>
          <label for="datecreated">Date Created</label>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="edit-qnumber">




<?php include 'modal.php';  ?>

<script>
  function loadInbox() {
      $.post("dirs/quotations/quotations.php", {
      }, function (data){
          $("#main-content").html(data);
      });
  }


  /*Function for next form*/
  function EditloadForm2() {
      $('a[href="#editpayment"]').tab('show');
  }

  /*Function return form 1*/
  function EditreturnForm1() {
      $('a[href="#editcustomer"]').tab('show');
  }


  /*Function for next form*/
  function EditloadForm3() {
      $('a[href="#editorder"]').tab('show');
  }


  /*Function return form 1*/
  function EditreturnForm2() {
      $('a[href="#editpayment"]').tab('show');
  }


  /*Function for next form*/
  function EditloadForm4() {
      $('a[href="#edittermscondition"]').tab('show');
  }


  /*Function return form 1*/
  function EditreturnForm3() {
      $('a[href="#editpayment"]').tab('show');
  }


  /*Function for next form*/
  function EditloadForm4() {
      $('a[href="#edittermscondition"]').tab('show');
  }


  /*Function return form 1*/
  function EditreturnForm5() {
      $('a[href="#editorder"]').tab('show');
  }


  /*Function for next form*/
  function EditloadForm5() {
      $('a[href="#editwarranty"]').tab('show');
  }


  /*Function return form 1*/
  function EditreturnForm6() {
      $('a[href="#edittermscondition"]').tab('show');
  }


  /*Function for next form*/
  function EditloadForm6() {
      $('a[href="#editremarks"]').tab('show');
  }


  /*Function return form 1*/
  function EditreturnForm7() {
      $('a[href="#editwarranty"]').tab('show');
  }


  /*Function approval prompt*/
  function mdlApproval() {
    $("#mdl-approval-dialog").modal("show");
  }

  /*Function reject prompt*/
  function mdlReject() {
    $("#mdl-reject-permission").modal("show");
  }

  function commitreject() {
    $("#mdl-reject-permission").modal('hide');
    $("#mdl-reject-dialog").modal("show");
  }

  function mdlOnhold() {
    $("#mdl-onhold-dialog").modal("show");
  }


  /*Function return to sales orders*/
  function returnQuotations() {
      $.post("dirs/quotations/quotations.php", {
      }, function (data){
          $("#load_quotations").html(data);
      });
  }

  /*Function for resubmittin if the internet was too slow*/
  function setSubmitApproved(isSubmitting) {
      if (isSubmitting) {
          $("#btn-spinner-approved").removeClass("d-none");
          $("#btn-text-approved").text(" Please wait...");
          $("#btn-submit-approved").prop("disabled", true);
          $("#btn-cancel-approved").prop("disabled", true);
          window.onbeforeunload = function () {
              return "Please wait, your request is being processed.";
          };
      } else {
          $("#btn-spinner-approved").addClass("d-none");
          $("#btn-text-approved").text("Commit");
          $("#btn-submit-approved").prop("disabled", false);
          $("#btn-cancel-approved").prop("disabled", false);
          window.onbeforeunload = null;
      }
  }




  /*Function Approved Quotation*/
  function commitApproved() {
    setSubmitApproved(true);
      var CustomerName = $("#edit-customer").val();
      var ContactNumber = $("#edit-contactnumber").val();
      var TinNumber = $("#edit-tinumber").val();

      var DeliveryCharge = $("#edit-deliverycharge").val();
      var GrandTotal     = $("#edit-grandtotal").val();
      var QNumber        = $("#edit-qnumber").val();
      var PreparedUser  = $("#preparedby-user").val();

      /* For Item Orders */
      let OrdersData = [];

      $(".edit-item-order").each(function () {
          let orderId        = $(this).find(".order-id").val();
          let manualDiscount = $(this).find(".edit-manualdiscount").val();
          let discount       = $(this).find(".edit-discountperunit").val();
          let grossTotal     = $(this).find(".edit-grosstotal").val();
          let discountedamountperunit     = $(this).find(".edit-discountedamountperunit").val();
          OrdersData.push({
              id: orderId,
              manualDiscount: manualDiscount,
              discount: discount,
              grossTotal: grossTotal,
              discountedamountperunit: discountedamountperunit
          });
      });

      /* For Terms and condition */
      let TermsData = [];

      $(".termscondition").each(function () {
          let termsId  = $(this).find(".terms-id").val();
          let termsVal = $(this).find(".edit-termscondition").val().trim();

          if (termsVal !== "") {
              TermsData.push({
                  id: termsId,
                  value: termsVal
              });
          }
      });

      /* For Warranty */
      let WarrantyData = [];

      $(".warranty").each(function () {
          let warrantyId  = $(this).find(".warranty-id").val();
          let warrantyVal = $(this).find(".edit-warranty").val().trim();

          if (warrantyVal !== "") {
              WarrantyData.push({
                  id: warrantyId,
                  value: warrantyVal
              });
          }
      });

      let Status = "APPROVED";
     $.post(
          "dirs/quotations/actions/update_quotapproved.php",
          {

              CustomerName :CustomerName,
              ContactNumber : ContactNumber,
              TinNumber : TinNumber,
              
              DeliveryCharge: DeliveryCharge,
              GrandTotal: GrandTotal,
              QNumber: QNumber,
              PreparedUser: PreparedUser,
              Orders: JSON.stringify(OrdersData),
              Terms: JSON.stringify(TermsData),
              Warranty: JSON.stringify(WarrantyData),
              Status: Status
          }
      )
      .done(function (data) {
          setSubmitApproved(false);

          if ($.trim(data) === "success") {
              $("#mdl-approval-dialog").modal("hide");

              Swal.fire({
                  toast: true,
                  position: "top-end",
                  icon: "success",
                  title: "Quotation Approved.",
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true
              });

              returnQuotations();
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: data
              });
          }
      })
      .fail(function (xhr, status, err) {
          setSubmitApproved(false);
          Swal.fire({
              icon: "info",
              title: "Connection Lost",
              text: err
          });
      });
    }


    /*Function for resubmittin if the internet was too slow*/
    function setSubmitReject(isSubmitting) {
        if (isSubmitting) {
            $("#btn-spinner-reject").removeClass("d-none");
            $("#btn-text-reject").text(" Please wait...");
            $("#btn-submit-reject").prop("disabled", true);
            $("#btn-cancel-reject").prop("disabled", true);
            window.onbeforeunload = function () {
                return "Please wait, your request is being processed.";
            };
        } else {
            $("#btn-spinner-reject").addClass("d-none");
            $("#btn-text-reject").text("Commit");
            $("#btn-submit-reject").prop("disabled", false);
            $("#btn-cancel-reject").prop("disabled", false);
            window.onbeforeunload = null;
        }
    }

  /*Function Reject quotation*/
  function commitReject(){
    setSubmitReject(true);
      var QNumber     = $("#edit-qnumber").val();
      var Feedback    = $("#reject-comment").val();
      var Status      = 'REJECTED';
       $.post(
          "dirs/quotations/actions/update_reject.php",
          {
              QNumber: QNumber,
              Feedback: Feedback,
              Status: Status
          }
      )
      .done(function (data) {
          setSubmitReject(false);

          if ($.trim(data) === "success") {
              $("#mdl-reject-dialog").modal("hide");

              Swal.fire({
                  toast: true,
                  position: "top-end",
                  icon: "success",
                  title: "Quotation rejected.",
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true
              });

              returnQuotations();
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: data
              });
          }
      })
      .fail(function (xhr, status, err) {
          setSubmitReject(false);

          Swal.fire({
              icon: "info",
              title: "Connection Lost",
              text: err
          });
      });
  }

  /*Function for resubmittin if the internet was too slow*/
  function setSubmitOnhold(isSubmitting) {
      if (isSubmitting) {
          $("#btn-spinner-onhold").removeClass("d-none");
          $("#btn-text-onhold").text(" Please wait...");
          $("#btn-submit-onhold").prop("disabled", true);
          $("#btn-cancel-onhold").prop("disabled", true);
          window.onbeforeunload = function () {
              return "Please wait, your request is being processed.";
          };
      } else {
          $("#btn-spinner-onhold").addClass("d-none");
          $("#btn-text-onhold").text("Commit");
          $("#btn-submit-onhold").prop("disabled", false);
          $("#btn-cancel-onhold").prop("disabled", false);
          window.onbeforeunload = null;
      }
  }



  /*Function Reject quotation*/
  function commitOnhold(){
      setSubmitOnhold(true);
      var QNumber     = $("#edit-qnumber").val();
      var Comment     = $("#onhold-reason").val();
      var Feedback    = $("#additional-remarks").val();
      var Status      = 'ON HOLD';
      $.post(
        "dirs/quotations/actions/update_onhold.php",
        {
            QNumber: QNumber,
            Comment: Comment,
            Feedback: Feedback,
            Status: Status
        }
    )
    .done(function (data) {
        setSubmitOnhold(false);

        if ($.trim(data) === "success") {
            $("#mdl-onhold-dialog").modal("hide");

            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Quotation on hold.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            returnQuotations();
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data
            });
        }
    })
    .fail(function (xhr, status, err) {
        setSubmitOnhold(false);

        Swal.fire({
            icon: "info",
            title: "Connection Lost",
            text: err
        });
    });
}


  /*Function genereated link*/
  function mdllink(){
      var QNumber = $("#edit-qnumber").val();
      $("#mdl-generate-link").modal("show");
      $.post("dirs/quotations/actions/get_referencenumber.php",{
          QNumber : QNumber
      },function(data){
          response = JSON.parse(data);
          if(jQuery.trim(response.isSuccess) == "success"){
              $("#generate-link").val(response.Data.QNumber);
          }else{
              alert(jQuery.trim(response.Data));
          }
      });
  }

  /*Function copy reference number*/
  function copyData() {
      var input = document.getElementById("generate-link");
      input.select();
      input.setSelectionRange(0, 99999);
      navigator.clipboard.writeText(input.value)
          .then(() => {
              $("#mdl-generate-link").modal("hide");
          })
          .catch(err => {
              console.error("Failed to copy: ", err);
          });
  }





</script>