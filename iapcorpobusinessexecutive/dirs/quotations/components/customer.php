<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <!-- Left side: Header -->
  <div>
    <h4 class="text-muted mb-0">Customer Details</h4>
    <small class="text-muted">Please fill in the required information below.</small>
  </div>

  <!-- Right side: Saved Customer -->
  <div class="col-md-3">
    <select class="form-select" id="prev-customers" name="prev-customers">
      <option selected disabled></option>
      <option value="Reil P. Padilla">Reil P. Padilla</option>
      <option value="Jasmine B. Padilla">Jasmine B. Padilla</option>
    </select>
    <small class="text-muted">Select an existing customer to auto-fill details.</small>
  </div>
</div>

<hr>
<div class="row mt-4">
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="customer" name="customer" class="form-control" placeholder="Customer/ Representative">
		  <label for="customer">Customer/ Representative</label>
		  <small class="text-muted">Make sure the customer/representative information is complete.</small>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="contactnumber" name="contactnumber" class="form-control" placeholder="Contact number">
		  <label for="contactnumber">Contact number</label>
		</div>
	</div>

	

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select" id="customertype" name="customertype">
		  	<option selected disabled></option>
		  	<option value="Corporate">Corporate</option>
		  	<option value="Personal">Personal</option>
		  </select>
		  <label for="customertype">Customer Type</label>
		  <small class="text-muted">Choose whether this customer is an personal or business.</small>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="tinumber" name="tinumber" class="form-control" placeholder="TIN Number">
		  <label for="tinumber">TIN Number</label>
		</div>
	</div>

	<div class="col-md-12 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="companyname" name="companyname" class="form-control" placeholder="Company">
		  <label for="companyname">Company</label>
		</div>
	</div>
	<hr>
	<h4 class="text-muted">Customer Address</h4>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select" id="province" name="province">
		  	<option selected disabled></option>
		  	<option value="Corporate">Corporate</option>
		  	<option value="Personal">Personal</option>
		  </select>
		  <label for="province">Province</label>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select" id="municipality" name="municipality">
		  	<option selected disabled></option>
		  	<option value="Corporate">Corporate</option>
		  	<option value="Personal">Personal</option>
		  </select>
		  <label for="municipality">Municipality</label>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select" id="barangay" name="barangay">
		  	<option selected disabled></option>
		  	<option value="Corporate">Corporate</option>
		  	<option value="Personal">Personal</option>
		  </select>
		  <label for="barangay">Barangay</label>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="street" name="street" class="form-control" placeholder="Street/ Bldg No.">
		  <label for="street">Street/ Bldg No.</label>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Zipcode">
		  <label for="zipcode">Zipcode</label>
		</div>
	</div>
	
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="landmark" name="landmark" class="form-control" placeholder="Landmark">
		  <label for="landmark">Landmark</label>
		</div>
		<small class="text-muted">This field is optional.</small>
	</div>
	<hr>
	<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-danger" type="button" onclick="loadForm2()">Next</button>
	</div>
</div>


