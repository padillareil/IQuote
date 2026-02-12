<!-- Choose Releasing Store Branch -->
<div class="mb-3 flex-wrap">
	<div class="row">
		<div class="col-md-6">
		  <h4 class="text-muted mb-0">Releasing Branch</h4>
		  <!-- <small class="text-muted">Select branch where you want to release the unit.</small> -->
		</div>
		<div class="col-md-6">
			<div class="form-floating mb-2">
			 	<input type="text" id="edit-branch" name="edit-branch" class="form-control" placeholder="Branch" readonly>
			  <label class="text-muted">Branch</labels>
			</div>
		</div>
	</div>
</div>
<hr>
<!-- Choose Mode of Payment -->
<div class="mb-3">
	<div class="row">
		<div class="col-md-6">
			<!-- Title -->
			<div class="mb-2">
			  <h4 class="text-muted mb-0">Mode of Payment</h4>
			<!--   <small class="text-muted">Select customer preferred payment option below.</small> -->
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-floating mb-2">
			  <input type="text" id="editmode-payment" name="editmode-payment" class="form-control" readonly>
			  <label class="text-muted">Payment Method</labels>
			</div>

			<div id="installment-field" class="d-none">
		<!-- For installment terms -->
				<div class="form-floating mb-2 installment">
				  <input type="text" id="installment-period-edit" name="installment-period-edit" class="form-control" placeholder="Installment Period" readonly>
				  <label class="text-muted">Installment Period</label>
				</div>

				<div class="form-floating mb-2" id="downpayment-field">
				  <input type="text" id="downpayment-edit" name="downpayment-edit" class="form-control" placeholder="Downpayment" readonly>
				  <label class="text-muted">Downpayment</label>
				</div>
			</div>
		<!-- For installment terms -->


		<!--For Check terms  -->
		<div id="checkbank-edit" class="d-none"> 
			<div class="form-floating mb-2 checkterms">
			    <input type="text" id="edit-checkbank" name="edit-checkbank" class="form-control" placeholder="Bank" readonly>
			    <label class="text-muted">Bank</label>
			</div>
			<div class="form-floating mb-2" id="checkaccountname-edit">
			  <input type="text" id="bank-accountnamecheck" name="bank-accountnamecheck" class="form-control" placeholder="Account Name" readonly>
			  <label for="bank-accountnamecheck">Account Name</label>
			</div>
			<div class="form-floating mb-2" id="checkaccoutnumber-edit">
			  <input type="text" id="bank-accountnumbercheck" name="bank-accountnumbercheck" class="form-control" placeholder="Account Number" readonly>
			  <label for="bank-accountnumbercheck">Account Number</label>
			</div>
		</div>
		<!--For Check terms  -->

		<!-- For Bank Transfer -->
		<div id="banktransfer-edit" class="d-none">
			<div class="form-floating mb-2 banktransfer">
			  <input type="text" id="edit-transferbank" name="edit-transferbank" class="form-control" placeholder="Bank" readonly>
			  <label class="text-muted">Bank</label>
			</div>
			<div class="form-floating mb-2">
			  <input type="text" id="transfer-edit-accountname" name="transfer-edit-accountname" class="form-control" placeholder="Account Name" readonly>
			  <label for="transfer-edit-accountname">Account Name</label>
			</div>
			<div class="form-floating mb-2">
			  <input type="text" id="transfer-edit-accountnumber" name="transfer-edit-accountnumber" class="form-control" placeholder="Account Number" readonly>
			  <label for="transfer-edit-accountnumber">Account Number</label>
			</div>
		</div>
		<!-- For Bank Transfer -->


			
		</div>
	</div>
</div>




<hr>
<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-secondary me-2" type="button" onclick="EditreturnForm1()">Back</button>
	<button class="btn btn-danger" type="button" onclick="EditloadForm3()">Next</button>
</div>





  <!-- Fields -->
  