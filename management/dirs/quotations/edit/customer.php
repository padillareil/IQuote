<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div>
    <h4 class="text-muted mb-0">Customer Details</h4>
    <!-- <small class="text-muted">Please fill in the required information below.</small> -->
  </div>
</div>
<input type="hidden" id="preparedby-user">
<hr>
<div class="row mt-4">
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-customer" name="edit-customer" class="form-control" placeholder="Customer/ Representative" readonly>
		  <label for="edit-customer">Customer/ Representative</label>
		  <!-- <small class="text-muted">Make sure the customer/representative information is complete.</small> -->
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-contactnumber" name="edit-contactnumber" class="form-control" placeholder="Contact number" readonly>
		  <label for="edit-contactnumber">Contact number</label>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-customertype" name="edit-customertype" class="form-control" placeholder="TIN Number" readonly>
		  <label for="edit-customertype">Customer Type</label>
		  <!-- <small class="text-muted">Choose whether this customer is an personal or business.</small> -->
		</div>
	</div>
	
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-tinumber" name="edit-tinumber" class="form-control" placeholder="TIN Number" readonly>
		  <label for="edit-tinumber">TIN Number</label>
		</div>
	</div>


	
	
	<div class="col-md-12 mb-2" id="customer-company">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-companyname" name="edit-companyname" class="form-control" placeholder="Company" readonly>
		  <label for="edit-companyname">Company</label>
		</div>
	</div>
	<hr>
	<h4 class="text-muted">Customer Address</h4>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-province" name="edit-province" class="form-control" placeholder="Zipcode" readonly>
		  <label for="edit-province">Province</label>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-municipality" name="edit-municipality" class="form-control" placeholder="Zipcode" readonly>
		  <label for="edit-municipality">Municipality</label>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-barangay" name="edit-barangay" class="form-control" placeholder="Zipcode" readonly>
		  <label for="edit-barangay">Barangay</label>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-street" name="edit-street" class="form-control" placeholder="Zipcode" readonly>
		  <label for="edit-street">Street/ Bldg No.</label>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-zipcode" name="edit-zipcode" class="form-control" placeholder="Zipcode" readonly>
		  <label for="edit-zipcode">Zipcode</label>
		</div>
	</div>
	
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="edit-landmark" name="edit-landmark" class="form-control" placeholder="Landmark" readonly>
		  <label for="edit-landmark">Landmark</label>
		</div>
	<!-- 	<small class="text-muted">This field is optional.</small> -->
	</div>
	<hr>
	<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-danger" type="button" onclick="EditloadForm2()">Next</button>
	</div>
</div>



