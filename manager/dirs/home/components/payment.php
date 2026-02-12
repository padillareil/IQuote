<!-- Choose Releasing Store Branch -->
<div class="mb-3 flex-wrap">
	<div class="row">
		<div class="col-md-6">
		  <h4 class="text-muted mb-0">Releasing Branch</h4>
		  <small class="text-muted">Select branch where you want to release the unit.</small>
		</div>
		<div class="col-md-6">
			<div class="form-floating mb-2">
			  <select class="form-select border border-warning-subtle" id="branch" name="branch">
			  	<option selected disabled></option>
			  </select>
			  <label for="branch">Branch</label>
			</div>
		</div>
	</div>
 
 
  <input type="hidden" id="corporation-branch"> 
</div>
<hr>
<!-- Choose Mode of Payment -->
<div class="mb-3">
	<div class="row">
		<div class="col-md-6">
			<!-- Title -->
			<div class="mb-2">
			  <h4 class="text-muted mb-0">Mode of Payment</h4>
			  <!-- <small class="text-muted">Select customer preferred payment option below.</small> -->
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-floating mb-4">
			  <select class="form-select border border-warning-subtle" id="mode-payment" name="mode-payment">
			    <option value="Cash">Cash</option>
			    <option value="Check">Check</option>
			    <option value="Installment">Installment</option>
			    <option value="Bank Transfer">Bank Transfer</option>
			    <option value="Debit/Credit Card">Debit/Credit Card</option>
			  </select>
			  <label for="mode-payment">Payment Method</label>
			</div>

		<div id="other-fields">
		<!-- For installment terms -->
			<div class="form-floating mb-2" id="installment">
			  <select class="form-select border border-warning-subtle" id="installment-period" name="installment-period">
			  	<option selected disabled></option>
			  </select>
			  <label for="installment-period">Installment Period</label>
			</div>

			<div class="form-floating mb-2" id="downpayment">
			  <select class="form-select border border-warning-subtle" id="downpayment-select" name="downpayment-select">
			  	<option selected disabled></option>
			  </select>
			  <label for="downpayment-select">Downpayment</label>
			</div>
		<!-- For installment terms -->


		<!--For Check terms  -->
			<div class="form-floating mb-2 checkterms" id="checkterms">
			  <select class="form-select border border-warning-subtle" id="bank" name="bank">
			  	<option selected disabled></option>
			  </select>
			  <label for="bank">Bank</label>
			</div>
			<div class="form-floating mb-2" id="accountname-check">
			  <input type="text" id="bank-accountname" name="bank-accountname" class="form-control" placeholder="Account Name" readonly>
			  <label for="bank-accountname">Account Name</label>
			</div>
			<div class="form-floating mb-2" id="accountnumber-check">
			  <input type="text" id="bank-accountnumber" name="bank-accountnumber" class="form-control" placeholder="Account Number" readonly>
			  <label for="bank-accountnumber">Account Number</label>
			</div>
		<!--For Check terms  -->

		<!-- For Bank Transfer -->
			<div class="form-floating mb-2 banktransfer" id="banktransfer">
			  <select class="form-select border border-warning-subtle" id="transfer-bank" name="transfer-bank">
			  	<option selected disabled></option>
			  </select>
			  <label for="transfer-bank">Bank</label>
			</div>
			<div class="form-floating mb-2 d-none" id="accountname-form">
			  <input type="text" id="transfer-bank-accountname" name="transfer-bank-accountname" class="form-control" placeholder="Account Name" readonly>
			  <label for="transfer-bank-accountname">Account Name</label>
			</div>
			<div class="form-floating mb-2 d-none" id="accountnumber-form">
			  <input type="text" id="transfer-bank-accountnumber" name="transfer-bank-accountnumber" class="form-control" placeholder="Account Number" readonly>
			  <label for="transfer-bank-accountnumber">Account Number</label>
			</div>
		<!-- For Bank Transfer -->
			</div>
		</div>
	</div>
</div>




<hr>
<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-secondary me-2" type="button" onclick="returnForm1()">Back</button>
	<button class="btn btn-danger" type="button" onclick="loadForm3()">Next</button>
</div>

  

<script>
	$(document).ready(function () {
	    paymentMode();
	    $("#mode-payment").on("change", paymentMode);
	    function resetPaymentFields() {
	        $("#installment, #downpayment, #checkterms, #accountnumber-check, #accountname-check, #banktransfer, #accountnumber-form, #accountname-form")
	            .addClass("d-none");
	        $("#installment-period").val("");
	        $("#downpayment-select").val("");
	        $("#bank").val("");
	        $("#bank-accountname").val("");
	        $("#bank-accountnumber").val("");
	        $("#transfer-bank").val("");
	        $("#transfer-bank-accountname").val("");
	        $("#transfer-bank-accountnumber").val("");
	    }

	    function paymentMode() {
	        var paymentMode = $("#mode-payment").val();
	        resetPaymentFields();
	        if (paymentMode === "Installment") {
	            $("#installment, #downpayment").removeClass("d-none");
	        } else if (paymentMode === "Check") {
	            $("#accountnumber-check, #accountname-check, #checkterms").removeClass("d-none");
	        } else if (paymentMode === "Bank Transfer") {
	            $("#accountnumber-form, #accountname-form, #banktransfer").removeClass("d-none");
	        }
	    }
	});

</script>