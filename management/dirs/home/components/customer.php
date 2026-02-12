<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <!-- Left side: Header -->
  <div>
    <h4 class="text-muted mb-0">Customer Details</h4>
    <small class="text-muted">Please fill in the required information below.</small>
  </div>

  <!-- Right side: Saved Customer -->
  <!-- <div class="col-md-3">
    <select class="form-select border border-warning-subtle" id="prev-customers" name="prev-customers">
      <option selected disabled></option>
    </select>
    <small class="text-muted">Select an existing customer to auto-fill details.</small>
  </div> -->
  <div class="col-md-3">
    <label for="prev-customers" class="form-label visually-hidden">Previous Customers</label>
    <div class="input-group">
      <select class="form-select border border-warning-subtle" id="prev-customers" name="prev-customers">
        <option selected disabled></option>
      </select>
      <button class="btn btn-outline-secondary" type="button" title="Search Customer" onclick="mdlSearchCstmer()"><i class="bi bi-search"></i></button>
    </div>
    <small class="text-muted d-block mt-1">
      Select an existing customer to auto-fill details.
    </small>
  </div>
</div>

<hr>
<div class="row mt-4">
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="customer-name" name="customer-name" class="form-control border border-warning-subtle" placeholder="Customer" autocomplete="off">
		  <label for="customer-name">Customer</label>
		  <small class="text-muted">Make sure the customer/representative information is complete.</small>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="contactnumber" name="contactnumber" class="form-control border border-warning-subtle" placeholder="Contact number" autocomplete="off" maxlength="11">
		  <label for="contactnumber">Contact number</label>
		</div>
	</div>

	
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select border border-warning-subtle" id="customertype" name="customertype">
		  	<option selected disabled></option>
		  	<option value="Corporate Private">Corporate Private</option>
            <option value="Corporate Government">Corporate Government</option>
            <option value="Private">Private</option>
            <option value="Personal">Personal</option>
		  </select>
		  <label for="customertype">Customer type</label>
		  <!-- <small class="text-muted">Choose whether the customer classification is Personal or Corporate.</small> -->
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="tinumber" name="tinumber" class="form-control border border-warning-subtle" placeholder="TIN Number" autocomplete="off">
		  <label for="tinumber">TIN</label>
		</div>
	</div>

	<div class="col-md-12 mb-2 d-none" id="customer-company">
		<div class="form-floating mb-2">
		  <input type="text" id="companyname" name="companyname" class="form-control border border-warning-subtle" placeholder="Company" autocomplete="off">
		  <label for="companyname">Company</label>
		</div>
	</div>
	<hr>
	<h4 class="text-muted">Customer Address</h4>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select border border-warning-subtle" id="province" name="province">
		  	<option selected disabled></option>
		  </select>
		  <label for="province">Province</label>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select border border-warning-subtle" id="municipality" name="municipality">
		  	<option selected disabled></option>
		  </select>
		  <label for="municipality">Municipality</label>
		</div>
	</div>
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <select class="form-select border border-warning-subtle" id="barangay" name="barangay">
		  	<option selected disabled></option>
		  </select>
		  <label for="barangay">Barangay</label>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="street" name="street" class="form-control border border-warning-subtle" placeholder="Street/ Bldg No." autocomplete="off">
		  <label for="street">Street/ Bldg No.</label>
		</div>
	</div>

	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="zipcode" name="zipcode" class="form-control border border-warning-subtle" maxlength="4" placeholder="Zipcode" autocomplete="off">
		  <label for="zipcode">Zipcode</label>
		</div>
	</div>
	
	<div class="col-md-6 mb-2">
		<div class="form-floating mb-2">
		  <input type="text" id="landmark" name="landmark" class="form-control border border-warning-subtle" placeholder="Landmark (Optional)" autocomplete="off">
		  <label for="landmark">Landmark (Optional)</label>
		</div>
	</div>
	<hr>
	<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-danger" type="button" onclick="loadForm2()">Next</button>
	</div>
</div>


<input type="hidden" id="provincecode">  
<input type="hidden" id="municipalcode"> 
<input type="hidden" id="barangaycode"> 

<script>
$(document).ready(function () {
    getProvince();

    $("#province").on("change", function () {
        const provinceCode = $(this).val();
        $("#provincecode").val(provinceCode);
        resetSelect("#municipality", "Select Municipality");
        resetSelect("#barangay", "Select Barangay");
        $("#municipalcode, #barangaycode").val("");
        getMunicipality(provinceCode);
    });

    $("#municipality").on("change", function () {
        const $selected = $(this).find("option:selected");
        $("#municipalcode").val($selected.data("prvcode") || "");
        resetSelect("#barangay", "Select Barangay");
        $("#barangaycode").val("");
        getBarangay($selected.val());
    });

    $("#barangay").on("change", function () {
        $("#barangaycode").val($(this).val());
    });
});

// Helpers
function resetSelect(selector, placeholder) {
    $(selector).empty().append(`<option selected disabled>${placeholder}</option>`);
}

function populateSelect($select, data, valueKey, textKey, extraAttr = "") {
    $select.empty().append(`<option selected disabled></option>`);
    data.forEach(item => {
        $select.append(
            `<option value="${item[valueKey]}" ${extraAttr ? `${extraAttr}="${item[extraAttr]}"` : ""}>
                ${item[textKey]}
            </option>`
        );
    });
}

// Get provinces
function getProvince() {
    $.post("dirs/home/actions/get_province.php", {}, function (data) {
        const response = JSON.parse(data);
        const $select = $("#province");
        $select.empty().append('<option selected disabled>Select Province</option>');

        if (response.isSuccess === "success") {
            response.Data.forEach(province => {
                $select.append(`<option value="${province.Code}">${province.Name}</option>`);
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: response.Data });
        }
    });
}

// Get municipalities
function getMunicipality(provinceCode) {
    $.post("dirs/home/actions/get_municipality.php", { Code: provinceCode }, function (data) {
        const response = JSON.parse(data);
        const $select = $("#municipality");
        $select.empty().append('<option selected disabled>Select Municipality</option>');

        if (response.isSuccess === "success") {
            response.Data.forEach(municipality => {
                $select.append(
                    `<option value="${municipality.Code}" data-prvcode="${municipality.PRVCode}">${municipality.Name}</option>`
                );
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: response.Data });
        }
    });
}


// Get barangays
function getBarangay(municipalityCode) {
    $.post("dirs/home/actions/get_barangay.php", { Code: municipalityCode }, function (data) {
        const response = JSON.parse(data);
        if (response.isSuccess === "success") {
            populateSelect($("#barangay"), response.Data, "TCCode", "Name");
        } else {
            Swal.fire({ icon: "error", title: "Error", text: response.Data });
        }
    });
}

function loadcustomerType() {
    var CustomerType = $("#customertype").val(); 
    if (CustomerType === "Corporate Private" || CustomerType === "Corporate Government" || CustomerType === "Private") {
        $("#customer-company").removeClass("d-none"); 
    } else {
        $("#customer-company").addClass("d-none"); 
    }
}

$(document).ready(function () {
    $("#customertype").on("change", loadcustomerType);
});


/*Script doenst allow input to enter negative number and text*/
$(document).ready(function () {
    $(document).on("input", "#contactnumber", function () {
        let val = $(this).val();
        val = val.replace(/[^0-9]/g, "");
        if (val === "" || parseInt(val) < 0) {
            $(this).val('');
        } else {
            $(this).val(val);
        }
    });
});

/*Script doenst allow input to enter negative number and text*/
$(document).ready(function () {
    $(document).on("input", "#zipcode", function () {
        let val = $(this).val();
        val = val.replace(/[^0-9]/g, "");
        if (val === "" || parseInt(val) < 0) {
            $(this).val('');
        } else {
            $(this).val(val);
        }
    });
});

/*Script for tin number formating*/
$(document).ready(function () {
    $(document).on("input", "#tinumber", function () {
        let val = $(this).val().replace(/[^0-9]/g, "");
        if (val.length > 12) {
            val = val.substring(0, 12);
        }
        let formatted = val.match(/.{1,3}/g)?.join("-") || "";
        $(this).val(formatted);
    });
});





</script>

