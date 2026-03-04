<!-- Create order -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div>
    <h4 class="text-muted mb-0">Choose a unit to order.</h4>
    <small class="text-muted">Choose the unit and proceed to place the order.</small>
  </div>
  <div class="justify-content-end d-flex col-md-6">
  	<button class="btn btn-outline-secondary" type="button" onclick="loadAddOrder()"><i class="bi bi-plus text-danger"></i>	Add Order</button>
  </div>
</div>
<hr>
<div class="card shadow-sm mb-2" id="order-scrollbar" style="height:40vh;">

	  

	  <div id="display-orders" class="mb-2"></div>

</div>
<div class="card mt-2">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 mb-2">
				<div class="form-floating mb-2">
				  <input type="text" id="deliverycharge" name="deliverycharge" class="form-control" placeholder="Delivery Charge" value="0">
				  <label for="deliverycharge">Delivery Charge</label>
				</div>
			</div>
			<div class="col-md-6 mb-2">
				<div class="form-floating mb-2">
				  <input type="text" id="grandtotal" name="grandtotal" class="form-control" placeholder="Grand Total" readonly value="0">
				  <label for="grandtotal">Grand Total</label>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-secondary me-2" type="button" onclick="returnForm3()">Back</button>
	<button class="btn btn-danger" type="button" onclick="loadForm4()">Next</button>
</div>


<script>
	/*Script for scrollbar*/
	$(document).ready(function() {
	    OverlayScrollbars(document.getElementById("order-scrollbar"), {
	        className: "os-theme-dark",
	        scrollbars: {
	          autoHide: "leave",
	          clickScrolling: true
	        }
	    });
	});


	// Attach listener for direct input in Discount Per Unit
	$(document).on("input", ".discountperunit", function() {
	  applyDiscountPerUnit(this);
	});


	/*Script doenst allow input to enter negative number and text*/
	$(document).ready(function () {
	    $(document).on("input", ".quantity", function () {
	        let val = $(this).val();
	        val = val.replace(/[^0-9]/g, "");
	        if (val === "" || parseInt(val) < 0) {
	            $(this).val('');
	        } else {
	            $(this).val(val);
	        }
	    });
	});

/*Script doenst alllow to input enter negative and text for manual disocunt*/
	$(document).ready(function () {
	    $(document).on("input", ".manualdiscount", function () {
	        let val = $(this).val();
	        val = val.replace(/[^0-9]/g, "");
	        if (val === "" || parseInt(val) < 0) {
	            $(this).val('');
	        } else {
	            $(this).val(val);
	        }
	    });
	});


	$(document).ready(function () {
	    // Format only numeric input (quantity, discount, deliverycharge)
	    $(document).on("input", ".quantity, .discountperunit, #deliverycharge, .manualdiscount", function () {  // ✅ use #deliverycharge
	        let val = $(this).val().replace(/[^0-9]/g, "");
	        $(this).val(val ? Number(val).toLocaleString() : "");

	        let $row = $(this).closest(".order-form");
	        if ($row.length) {
	            calculateGrossTotal($row);
	        }
	        calculateGrandTotal();
	    });

	    // If selling price changes (loaded from DB), recalc
	    $(document).on("input", ".sellingprice", function () {
	        let $row = $(this).closest(".order-form");
	        calculateGrossTotal($row);
	        calculateGrandTotal();
	    });

	    function calculateGrossTotal($row) {
	        let sPrice   = parseFloat($row.find(".sellingprice").val().replace(/,/g, "")) || 0;
	        let qty      = parseFloat($row.find(".quantity").val().replace(/,/g, "")) || 0;
	        let discount = parseFloat($row.find(".discountperunit").val().replace(/,/g, "")) || 0;

	        // Base gross
	        let gross = sPrice * qty;

	        // Apply discount per unit if any
	        if (discount > 0) {
	            gross -= discount * qty;
	        }

	        $row.find(".grosstotal").val(gross > 0 ? gross.toLocaleString() : "");
	    }

	    function calculateGrandTotal() {
	        let grand = 0;

	        // Loop through all rows
	        $(".order-form").each(function () {
	            let rowGross = parseFloat($(this).find(".grosstotal").val().replace(/,/g, "")) || 0;
	            grand += rowGross;
	        });

	        // ✅ Single delivery charge field (ID)
	        let delivery = parseFloat($("#deliverycharge").val()?.replace(/,/g, "")) || 0;
	        grand += delivery;

	        $("#grandtotal").val(grand > 0 ? grand.toLocaleString() : "");
	    }
	});



	function loadAddOrder() {
	  const container = document.getElementById("display-orders");
	  const wrapper = document.createElement("div");
	  wrapper.classList.add("row", "order-form", "border", "rounded", "p-3", "mb-3");

	  wrapper.innerHTML = `
		    <!-- Brand -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <select class="form-select brand" name="brand[]">
		          <option selected disabled></option>
		        </select>
		        <label>Choose Brand</label>
		      </div>
		    </div>
		    <!-- Model -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <select class="form-select model" name="model[]">
		          <option selected disabled></option>
		        </select>
		        <label>Choose Model</label>
		      </div>
		    </div>
		    <!-- Category -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <input type="text" name="category[]" class="form-control category" placeholder="Category" readonly>
		        <label>Category</label>
		      </div>
		    </div>
		    <input type="hidden" class="itemcode" name="itemcode[]">
		    <!-- SRP -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <input type="text" name="sellingprice[]" class="form-control sellingprice" placeholder="SRP/ Unit Price">
		        <label>SRP/ Unit Price</label>
		      </div>
		    </div>
		    <input type="hidden" class="price-limit" name="price-limit[]">
		    <!-- Quantity -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <input type="text" name="quantity[]" class="form-control quantity" placeholder="Quantity">
		        <label>Quantity</label>
		      </div>
		    </div>
		    <!-- Discount per unit -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <input type="text" name="discountperunit[]" class="form-control discountperunit" placeholder="Discount Per Unit">
		        <label>Discount Per Unit</label>
		      </div>
		    </div>
		    <!-- Discounted Amount per unit -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <input type="text" name="discountedamountperunit[]" class="form-control discountedamountperunit" placeholder="Discounted Amount Per Unit" readonly>
		        <label>Discounted Amount Per Unit</label>
		      </div>
		    </div>
		    <!-- Gross total -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <input type="text" name="grosstotal[]" class="form-control grosstotal" placeholder="Gross Total" readonly>
		        <label>Gross Total</label>
		  			<small class="text-danger error-msg d-none">The discounted amount you are suggesting is beyond your user authorization.</small>
		      </div>
		    </div>
		    <!-- Manual Discount -->
		    <div class="col-md-6 mb-2">
		      <div class="form-floating mb-2">
		        <input type="text" name="manualdiscount[]" class="form-control manualdiscount" placeholder="Manual Discount">
		        <label>Manual Discount</label>
		      </div>
		    </div>
		    <!-- Action buttons -->
		    <div class="justify-content-end d-flex">
		      <button class="btn btn-outline-secondary me-2" type="button" title="Apply Manual Discount" onclick="applyManualDiscount(this)">Apply Manual Discount</button>
		      <button class="btn btn-outline-danger bi bi-x-lg" type="button" title="Cancel Item Order" onclick="this.closest('.order-form').remove()"></button>
		    </div>
	  `;

	  container.appendChild(wrapper);

	  // convert wrapper into jQuery object
	  let $wrapper = $(wrapper);

	  // fetch brands for this new row only
	  loadBrand($wrapper);

	  // reset fields when model changes
	  $wrapper.find(".model").on("change", function() {
	    $wrapper.find(".quantity").val("");
	    $wrapper.find(".discountperunit").val("");
	    $wrapper.find(".discountedamountperunit").val("");
	    $wrapper.find(".grosstotal").val("");
	    $wrapper.find(".manualdiscount").val("");
	  });
	}



	/* Function Fetch brand */
	function loadBrand($row) {
	  $.post("dirs/home/actions/get_brand.php", {}, function(data){
	    let response = JSON.parse(data);

	    if ($.trim(response.isSuccess) === "success") {
	      let $brandSelect = $row.find(".brand");
	      $brandSelect.empty().append('<option selected disabled>Choose Brand</option>');

	      $.each(response.Data, function(index, item){
	        $brandSelect.append(
	          $("<option>", {
	            value: item.Brand,
	            text: item.Brand
	          })
	        );
	      });
	    } else {
	      alert($.trim(response.Data));
	    }
	  });
	}


	// When user selects a brand, load models for that row only
	$(document).on("change", ".brand", function(){
	  let selectedBrand = $(this).val();
	  let $row = $(this).closest(".order-form");
	  if (selectedBrand) {
	    loadModel(selectedBrand, $row);
	  }
	});


	/* Function Fetch Model */
	function loadModel(Brand, $row) {
	  $.post("dirs/home/actions/get_model.php", { Brand: Brand }, function(data){
	    let response = JSON.parse(data);

	    if ($.trim(response.isSuccess) === "success") {
	      let $modelSelect = $row.find(".model");
	      $modelSelect.empty().append('<option selected disabled>Choose Model</option>');

	      $.each(response.Data, function(index, item){
	        $modelSelect.append(
	          $("<option>", {
	            value: item.Model,
	            text: item.Model,
	            "data-category": item.ItemGroup,
	            "data-itemcode": item.ItemCode
	          })
	        );
	      });
	    } else {
	      alert($.trim(response.Data));
	    }
	  });
	}


	// When user selects a model, update category/itemcode/prices in that row only
	$(document).on("change", ".model", function(){
	  let selected = $(this).find(":selected");
	  let $row = $(this).closest(".order-form");

	  let category = selected.data("category");
	  let itemCode = selected.data("itemcode");

	/*  console.log("Model changed:", selected.val(), 
	              "Category:", category, 
	              "ItemCode:", itemCode);*/

	  $row.find(".category").val(category || "");
	  $row.find(".itemcode").val(itemCode || "");

	  if (itemCode) {
	    loadLimitPrice(itemCode, $row);
	  } else {
	    console.warn("⚠️ No itemCode found in selected option");
	  }
	});


	/* Function Fetch Price */
	function loadLimitPrice(ItemCode, $row) {
	  let Branch = $("#branch").val();

	  $.post("dirs/home/actions/get_price.php", { 
	    Branch: Branch,
	    ItemCode: ItemCode
	  }, function(data){
	    let response = JSON.parse(data);

	    if ($.trim(response.isSuccess) === "success" && response.Data.length > 0) {
	      let item = response.Data[0];
	      $row.find(".sellingprice").val(item.SellingPrice);
	      $row.find(".discountedamountperunit").val(item.SellingPrice);
	      $row.find(".price-limit").val(item.FloorPrice);
	    } else {
	      Swal.fire({
	        icon: 'info',
	        title: 'No Price Available',
	        text: 'Please contact Merchandising for verification and updates in this item.',
	        confirmButtonText: 'OK'
	      });
	      $row.find(".sellingprice").val('');
	      $row.find(".price-limit").val('');
	    }
	  });
	}

/*Apply Manual Discount*/
	function applyManualDiscount(btn) {
	  let $row = $(btn).closest(".order-form");
	  let manualDiscount = parseFloat($row.find(".manualdiscount").val()) || 0; // total after discount
	  let quantity       = parseFloat($row.find(".quantity").val()) || 0;
	  let srp            = parseFloat($row.find(".sellingprice").val()) || 0;
	  let floorPrice     = parseFloat($row.find(".price-limit").val()) || 0;

	  if (!manualDiscount || !quantity || !srp) {
	    Swal.fire({
	      icon: "warning",
	      title: "Missing Data",
	      text: "Please enter Manual Discount Amount."
	    });
	    return;
	  }

	  let totalOriginal = srp * quantity;        
	  let floorTotal    = floorPrice * quantity;

	  if (manualDiscount < floorTotal) {
	    Swal.fire({
	      icon: "error",
	      title: "Invalid Discount",
	      text: "The Discounted Amount you are suggesting is beyond your user authorization."
	    }).then(() => {
	      resetDiscount($row);
	    });
	    return;
	  }

	  if (manualDiscount > totalOriginal) {
	    Swal.fire({
	      icon: "error",
	      title: "Invalid Discount",
	      text: "The discount exceeds the Selling Price."
	    }).then(() => {
	      resetDiscount($row);
	    });
	    return;
	  }

	  let discountPerUnit         = (totalOriginal - manualDiscount) / quantity;
	  let discountedAmountPerUnit = srp - discountPerUnit;

	  $row.find(".discountperunit").val(discountPerUnit.toFixed(2));
	  $row.find(".discountedamountperunit").val(discountedAmountPerUnit.toFixed(2));
	  $row.find(".grosstotal").val(manualDiscount.toFixed(2));
	}

	//  Apply discount per unit manually
	function applyDiscountPerUnit(input) {
	  let $row = $(input).closest(".order-form");

	  let discountPerUnit = parseFloat($(input).val()) || 0;
	  let quantity        = parseFloat($row.find(".quantity").val()) || 0;
	  let srp             = parseFloat($row.find(".sellingprice").val()) || 0;
	  let floorPrice      = parseFloat($row.find(".price-limit").val()) || 0;

	  let discountedAmountPerUnit = srp - discountPerUnit;
	  let manualDiscount          = discountedAmountPerUnit * quantity;
	  let floorTotal              = floorPrice * quantity;
	  let totalOriginal           = srp * quantity;

	  if (manualDiscount < floorTotal) {
	    Swal.fire({
	      icon: "error",
	      title: "Invalid Discount",
	      text: "The Discounted Amount you are suggesting is beyond your user authorization."
	    }).then(() => {
	      resetDiscount($row);
	    });
	    return;
	  }

	  if (manualDiscount > totalOriginal) {
	    Swal.fire({
	      icon: "error",
	      title: "Invalid Discount",
	      text: "The discount exceeds the Selling Price."
	    }).then(() => {
	      resetDiscount($row);
	    });
	    return;
	  }

	  $row.find(".discountedamountperunit").val(discountedAmountPerUnit.toFixed(2));
	  $row.find(".grosstotal").val(manualDiscount.toFixed(2));
	}

	// Reset helper
	function resetDiscount($row) {
	  let srp      = parseFloat($row.find(".sellingprice").val()) || 0;
	  let quantity = parseFloat($row.find(".quantity").val()) || 0;
	  $row.find(".manualdiscount").val("");
	  $row.find(".discountperunit").val("");
	  $row.find(".discountedamountperunit").val(srp.toFixed(2)); // back to SRP
	  $row.find(".grosstotal").val((srp * quantity).toFixed(2));
	}

	/*Function for next form*/
	function loadForm4() {
	  let $row = $(".order-form"); // or loop through all rows if multiple
	  let isValid = true;
	  let missingFields = [];

	  // Required fields
	  let brand   = $row.find(".brand").val();
	  let model   = $row.find(".model").val();
	  let category = $row.find(".category").val();
	  let srp     = $row.find(".sellingprice").val();
	  let qty     = $row.find(".quantity").val();
	  let discounted = $row.find(".discountedamountperunit").val();
	  let gross   = $row.find(".grosstotal").val();

	  if (!brand)   { isValid = false; missingFields.push("Brand"); }
	  if (!model)   { isValid = false; missingFields.push("Model"); }
	  if (!category){ isValid = false; missingFields.push("Category"); }
	  if (!srp)     { isValid = false; missingFields.push("Selling Price"); }
	  if (!qty)     { isValid = false; missingFields.push("Quantity"); }
	  if (!discounted){ isValid = false; missingFields.push("Discounted Amount Per Unit"); }
	  if (!gross)   { isValid = false; missingFields.push("Gross Total"); }

	  if (!isValid) {
	    Swal.fire({
	      icon: "warning",
	      title: "Incomplete Order",
	      text: `Please fill in the following fields before proceeding.`
	    });
	    return; 
	  }

	  $('a[href="#termscondition"]').tab('show');
	}
</script>


