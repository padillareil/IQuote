<!-- Create order -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div>
    <h4 class="text-muted mb-0">Order Selection</h4>
    <small class="text-muted">Select a unit to order.</small>
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
				  <input type="text" id="deliverycharge" name="deliverycharge" class="form-control border border-warning-subtle" placeholder="Delivery Charge" value="0" autocomplete="off">
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
	    $(document).on("input", ".discountperunit", function () {
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


	/*Script doenst allow input to enter negative number and text*/
	$(document).ready(function () {
	    $(document).on("input", ".sellingprice", function () {
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
	    $(document).on("input", "#deliverycharge", function () {
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


	function calculateGrossTotal($row) {
	    let sPrice     = parseFloat($row.find(".sellingprice").val().replace(/,/g, "")) || 0;
	    let qty        = parseFloat($row.find(".quantity").val().replace(/,/g, "")) || 0;
	    let discount   = parseFloat($row.find(".discountperunit").val().replace(/,/g, "")) || 0;
	    let floorPrice = parseFloat($row.find(".price-limit").val().replace(/,/g, "")) || 0;

	    // Base gross
	    let gross = sPrice * qty;
	    if (discount > 0) gross -= discount * qty;

	    // Update gross total
	    $row.find(".grosstotal").val(gross > 0 ? gross.toLocaleString() : "");

	    // ✅ Update price-limit total
	    let priceLimitTotal = floorPrice * qty;
	    $row.find(".price-limit-total").val(priceLimitTotal > 0 ? priceLimitTotal.toLocaleString() : "");
	}

	function calculateGrandTotal() {
	    let grand = 0;
	    $(".order-form").each(function () {
	        let $grossInput = $(this).find(".grosstotal");
	        let rowGross = parseFloat($grossInput.val().replace(/,/g, "")) || 0;
	        grand += rowGross;

	        // format row
	        if (rowGross > 0) {
	            $grossInput.val(
	                rowGross.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
	            );
	        }
	    });

	    let delivery = parseFloat($("#deliverycharge").val()?.replace(/,/g, "")) || 0;
	    grand += delivery;

	    $("#grandtotal").val(
	        grand > 0 
	            ? grand.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) 
	            : ""
	    );
	}

	$(document).ready(function () {
	    // watchers
	    $(document).on("input", ".quantity, .sellingprice, .discountperunit, .manualdiscount, .price-limit", function () {
	        let $row = $(this).closest(".order-form");
	        if ($row.length) calculateGrossTotal($row);
	        calculateGrandTotal();
	    });

	    $(document).on("input", "#deliverycharge", function () {
	        calculateGrandTotal();
	    });
	});


	function loadAddOrder() {
	    const container = document.getElementById("display-orders");
	    const wrapper = document.createElement("div");
	    wrapper.classList.add("row", "order-form", "border", "rounded", "p-3", "mb-3");

	    wrapper.innerHTML = `
	        <!-- Brand -->
	        <div class="col-md-6 mb-2">
	            <div class="form-floating mb-2">
	                <select class="form-select brand border-warning-subtle" name="brand[]">
	                    <option selected disabled></option>
	                </select>
	                <label>Choose Brand</label>
	            </div>
	        </div>
	        <!-- Model -->
	        <div class="col-md-6 mb-2">
	            <div class="form-floating mb-2">
	                <select class="form-select model border-warning-subtle" name="model[]">
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
	                <input type="text" name="sellingprice[]" class="form-control sellingprice border-warning-subtle" placeholder="SRP/ Unit Price">
	                <label>SRP/ Unit Price</label>
	            </div>
	        </div>
	        <input type="hidden" class="price-limit" name="price-limit[]">
	        <input type="hidden" class="price-limit-total" name="price-limit-total[]">
	        <!-- Quantity -->
	        <div class="col-md-6 mb-2">
	            <div class="form-floating mb-2">
	                <input type="text" name="quantity[]" class="form-control quantity border-warning-subtle" placeholder="Quantity" autocomplete="off">
	                <label>Quantity</label>
	            </div>
	        </div>
	        <!-- Discount per unit -->
	        <div class="col-md-6 mb-2">
	            <div class="form-floating mb-2">
	                <input type="text" name="discountperunit[]" class="form-control discountperunit border-warning-subtle" placeholder="Discount Per Unit" autocomplete="off">
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
	                <input type="text" name="manualdiscount[]" class="form-control manualdiscount border-warning-subtle" placeholder="Manual Discount">
	                <label>Discounted Amount</label>
	            </div>
	        </div>
	        <!-- Action buttons -->
	        <div class="justify-content-end d-flex">
	            <button class="btn btn-outline-secondary me-2" type="button" title="Apply Discounted Amount" onclick="applyManualDiscount(this)">Apply Discounted Amount</button>
	            <button class="btn btn-outline-danger" type="button" title="Cancel Item Order" onclick="removeOrder(this)">Remove</button>
	        </div>
	    `;

	    container.prepend(wrapper);

	    // turn wrapper into jQuery object
	    let $wrapper = $(wrapper);

	    // fetch brands for this new row
	    loadBrand($wrapper);

	    // reset fields when model changes
	    $wrapper.find(".model").on("change", function () {
	        $wrapper.find(".quantity, .discountperunit, .discountedamountperunit, .grosstotal, .manualdiscount").val("");
	        calculateGrandTotal();
	    });

	    // trigger grand total when quantity/discount/manualdiscount changes
	    $wrapper.find(".quantity, .discountperunit, .manualdiscount, .sellingprice").on("input", calculateGrandTotal);

	    // recalc once when row is added
	    calculateGrandTotal();
	}

	// 🔥 new helper for removing row
	function removeOrder(btn) {
	    $(btn).closest('.order-form').remove();
	    calculateGrandTotal(); // recalc after removal
	}


	function loadBrand($row) {
	  $.post("dirs/home/actions/get_brand.php", {}, function(data){
	    let response = JSON.parse(data);

	    if ($.trim(response.isSuccess) === "success") {
	      let $brandSelect = $row.find(".brand");
	      $brandSelect.empty().append('<option selected disabled></option>');

	      $.each(response.Data, function(index, item){
	        $brandSelect.append(
	          $("<option>", {
	            value: item.Brand,
	            text: item.Brand
	          })
	        );
	      });

	      // when brand changes, reset dependent fields
	      $brandSelect.off("change").on("change", function() {
	        $row.find(".model").val("").empty().append('<option selected disabled>Choose Model</option>');
	        $row.find(".category").val("");
	        $row.find(".sellingprice").val("");
	        $row.find(".quantity").val("");
	        $row.find(".discountperunit").val("");
	        $row.find(".discountedamountperunit").val("");
	        $row.find(".grosstotal").val("");
	        $row.find(".manualdiscount").val("");
	        $row.find(".price-limit").val("");
	        $row.find(".price-limit-total").val("");

	        calculateGrandTotal(); // recalc after reset
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
	  let $modelSelect = $row.find(".model");
	  $modelSelect
	    .empty()
	    .append('<option disabled selected>Loading models...</option>')
	    .prop("disabled", true);

	  $.post("dirs/home/actions/get_model.php", { Brand: Brand }, function (data) {
	    let response = JSON.parse(data);

	    if ($.trim(response.isSuccess) === "success") {
	      $modelSelect.empty();

	      if (response.Data.length > 0) {
	        $modelSelect.append('<option disabled>Choose Model</option>');
	        $.each(response.Data, function (index, item) {
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
	        $modelSelect.append('<option disabled selected>No model available.</option>');
	      }
	    } else {
	      $modelSelect.empty().append('<option disabled selected>Error loading models.</option>');
	    }
	  })
	  .fail(function () {
	    $modelSelect.empty().append('<option disabled selected>Failed to load models.</option>');
	  })
	  .always(function () {
	    $modelSelect.prop("disabled", false);
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
/*	function loadLimitPrice(ItemCode, $row) {
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
*/

	function loadLimitPrice(ItemCode, $row) {
	  let Branch = $("#branch").val();

	  $.post("dirs/home/actions/get_price.php", { 
	    Branch: Branch,
	    ItemCode: ItemCode
	  }, function(data) {
	    let response = JSON.parse(data);

	    if ($.trim(response.isSuccess) === "success" && response.Data.length > 0) {
	      let item = response.Data[0];
	      $row.find(".sellingprice").val(item.SellingPrice);
	      $row.find(".discountedamountperunit").val(item.SellingPrice);
	      $row.find(".price-limit").val(item.FloorPrice);
	      $row.find(".quantity").prop('disabled', false);
	    } else {
	      Swal.fire({
	        icon: 'info',
	        title: 'No Price Available',
	        text: 'Please contact Merchandising for verification and updates in this item.',
	        confirmButtonText: 'OK'
	      });
	      $row.find(".sellingprice").val('');
	      $row.find(".price-limit").val('');
	      // $row.find(".quantity").prop('disabled', true); temporarily ddisabled
	    }
	  });
	}



	/*Orignal Computation of Apply Manual Discount if the OPCIS table was already fixed*/


	/* Apply Manual Discount */
	// function applyManualDiscount(btn) {
	//   let $row = $(btn).closest(".order-form");
	//   let manualDiscount = parseFloat($row.find(".manualdiscount").val().replace(/,/g, "")) || 0;
	//   let quantity       = parseFloat($row.find(".quantity").val().replace(/,/g, "")) || 0;
	//   let srp            = parseFloat($row.find(".sellingprice").val().replace(/,/g, "")) || 0;
	//   let floorPrice     = parseFloat($row.find(".price-limit").val().replace(/,/g, "")) || 0;

	//   if (!manualDiscount || !quantity || !srp) {
	//     Swal.fire({
	//       icon: "warning",
	//       title: "Missing Data",
	//       text: "Please enter Manual Discount Amount."
	//     });
	//     return;
	//   }

	//   let totalOriginal = srp * quantity;        
	//   let floorTotal    = floorPrice * quantity;

	//   if (manualDiscount < floorTotal) {
	//     Swal.fire({
	//       icon: "error",
	//       title: "Invalid Discount",
	//       text: "The Discounted Amount you are suggesting is beyond your user authorization."
	//     }).then(() => {
	//       resetDiscount($row);
	//     });
	//     return;
	//   }

	//   if (manualDiscount > totalOriginal) {
	//     Swal.fire({
	//       icon: "error",
	//       title: "Invalid Discount",
	//       text: "The discount exceeds the Selling Price."
	//     }).then(() => {
	//       resetDiscount($row);
	//     });
	//     return;
	//   }

	//   // compute discount values
	//   let discountPerUnit         = (totalOriginal - manualDiscount) / quantity;
	//   let discountedAmountPerUnit = srp - discountPerUnit;

	//   // update fields
	//   $row.find(".discountperunit").val(discountPerUnit.toFixed(2));
	//   $row.find(".discountedamountperunit").val(discountedAmountPerUnit.toFixed(2));
	//   $row.find(".grosstotal").val(
	//     manualDiscount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
	//   );

	//   // ✅ update grand total
	//   calculateGrandTotal();
	// }

	/***********TEMPORARILY OVERIDE DISCOUNTING SCRIPTS*****************************************/

	/*Temporarily Computation of Apply Manual Discount that allow approver to overide the dicounting*/
	function applyManualDiscount(btn) {
	  let $row = $(btn).closest(".order-form");
	  let manualDiscount = parseFloat($row.find(".manualdiscount").val().replace(/,/g, "")) || 0;
	  let quantity       = parseFloat($row.find(".quantity").val().replace(/,/g, "")) || 0;
	  let srp            = parseFloat($row.find(".sellingprice").val().replace(/,/g, "")) || 0;
	  let floorPrice     = parseFloat($row.find(".price-limit").val().replace(/,/g, "")) || 0;
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
	  if (manualDiscount < floorTotal || manualDiscount > totalOriginal) {
	    Swal.fire({
	      icon: "warning",
	      title: "Confirm Discount",
	      text:
	        manualDiscount < floorTotal
	          ? "The Discounted Amount is beyond your user authorization. Do you want to proceed?"
	          : "The discount exceeds the Selling Price. Do you want to proceed?",
	      showCancelButton: true,
	      confirmButtonText: "Proceed",
	      cancelButtonText: "No",
	      focusConfirm: true
	    }).then((result) => {
	      if (result.isConfirmed) {
	        applyDiscountAndCompute($row, manualDiscount, quantity, srp);
	      } else {
	        resetDiscount($row);
	      }
	    });

	    return; 
	  }
	  applyDiscountAndCompute($row, manualDiscount, quantity, srp);
	}

	/*Temporarily Change this function when OPCIS already reapired thi is the function helper forapply manualdiscount*/
	function applyDiscountAndCompute($row, manualDiscount, quantity, srp) {
    let discountPerUnit = (srp * quantity - manualDiscount) / quantity;
    $row.find(".discountperunit").val(discountPerUnit.toFixed(2));
    let discountedAmountPerUnit = srp - discountPerUnit;
    $row.find(".discountedamountperunit").val(discountedAmountPerUnit.toFixed(2));
    let grossTotal = discountedAmountPerUnit * quantity;
    $row.find(".grosstotal").val(
        grossTotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
    );
    calculateGrandTotal();
    calculateGrossTotal();

	}


/*Temporarily Change this function when OPCIS already repaired thi function is for Discount per Unit*/
	function applyDiscountPerUnit(input) {
	  let $row = $(input).closest(".order-form");
	  let discountPerUnitRaw = $(input).val();
	  if (!discountPerUnitRaw) return; 
	  let discountPerUnit = parseFloat(discountPerUnitRaw);
	  if (isNaN(discountPerUnit)) return; 
	  let quantity   = parseFloat($row.find(".quantity").val()) || 0;
	  let srp        = parseFloat($row.find(".sellingprice").val()) || 0;
	  let floorPrice = parseFloat($row.find(".price-limit").val()) || 0;

	  let discountedAmountPerUnit = srp - discountPerUnit;
	  let manualDiscount          = discountedAmountPerUnit * quantity;
	  let floorTotal              = floorPrice * quantity;
	  let totalOriginal           = srp * quantity;
	  if (manualDiscount < floorTotal || manualDiscount > totalOriginal) {
	    Swal.fire({
	      icon: "warning",
	      title: "Confirm Discount",
	      text: manualDiscount < floorTotal
	        ? "The Discounted Amount is beyond your user authorization. Do you want to proceed?"
	        : "The discount exceeds the Selling Price. Do you want to proceed?",
	      showCancelButton: true,
	      confirmButtonText: "Proceed",
	      cancelButtonText: "No",
	      focusConfirm: true
	    }).then((result) => {
	      if (result.isConfirmed) {
	        $row.find(".discountedamountperunit").val(discountedAmountPerUnit.toFixed(2));
	        $row.find(".grosstotal").val(manualDiscount.toFixed(2));
	        calculateGrandTotal();
	      } else {
	        restoreOriginalValues($row);
	      }
	    });
	    return; 
	  }
	  $row.find(".discountedamountperunit").val(discountedAmountPerUnit.toFixed(2));
	  $row.find(".grosstotal").val(manualDiscount.toFixed(2));
	  calculateGrandTotal();
	}



/*Function helper to restore orignal value*/
	function restoreOriginalValues($row) {
	    let quantity = parseFloat($row.find(".quantity").val().replace(/,/g, "")) || 0;
	    let srp      = parseFloat($row.find(".sellingprice").val().replace(/,/g, "")) || 0;
	    $row.find(".discountperunit").val(' ');
	    $row.find(".discountedamountperunit").val(srp.toFixed(2));
	    let grossTotal = srp * quantity;
	    $row.find(".grosstotal").val(grossTotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
	    calculateGrandTotal();
	}
	function resetDiscount($row) {
	    restoreOriginalValues($row);
	}
	
	/***********TEMPORARILY OVERIDE DISCOUNTING SCRIPTS*****************************************/


	/* Reset discount fields in case of invalid entry */
	function resetDiscount($row) {
	  $row.find(".manualdiscount").val("");
	  $row.find(".discountperunit").val("");
	  $row.find(".discountedamountperunit").val("");
	  $row.find(".grosstotal").val("");
	  calculateGrandTotal();
	}


	//  Apply discount per unit manually
	// function applyDiscountPerUnit(input) {
	//   let $row = $(input).closest(".order-form");

	//   let discountPerUnit = parseFloat($(input).val()) || 0;
	//   let quantity        = parseFloat($row.find(".quantity").val()) || 0;
	//   let srp             = parseFloat($row.find(".sellingprice").val()) || 0;
	//   let floorPrice      = parseFloat($row.find(".price-limit").val()) || 0;

	//   let discountedAmountPerUnit = srp - discountPerUnit;
	//   let manualDiscount          = discountedAmountPerUnit * quantity;
	//   let floorTotal              = floorPrice * quantity;
	//   let totalOriginal           = srp * quantity;

	//   if (manualDiscount < floorTotal) {
	//     Swal.fire({
	//       icon: "error",
	//       title: "Invalid Discount",
	//       text: "The Discounted Amount you are suggesting is beyond your user authorization."
	//     }).then(() => {
	//       resetDiscount($row);
	//     });
	//     return;
	//   }

	//   if (manualDiscount > totalOriginal) {
	//     Swal.fire({
	//       icon: "error",
	//       title: "Invalid Discount",
	//       text: "The discount exceeds the Selling Price."
	//     }).then(() => {
	//       resetDiscount($row);
	//     });
	//     return;
	//   }

	//   $row.find(".discountedamountperunit").val(discountedAmountPerUnit.toFixed(2));
	//   $row.find(".grosstotal").val(manualDiscount.toFixed(2));
	// }

	// Reset helper
	function resetDiscount($row) {
	  let srp      = parseFloat($row.find(".sellingprice").val()) || 0;
	  let quantity = parseFloat($row.find(".quantity").val()) || 0;
	  $row.find(".manualdiscount").val("");
	  $row.find(".discountperunit").val("");
	  $row.find(".discountedamountperunit").val(srp.toFixed(2)); // back to SRP
	  $row.find(".grosstotal").val((srp * quantity).toFixed(2));
	}

	/*Function load Form 4 Original*/
	function loadForm4() {
	    let $rows = $(".order-form");

	    if ($rows.length === 0) {
	        Swal.fire({
	            icon: "warning",
	            title: "No Orders",
	            text: "There are no order items to process."
	        });
	        return; 
	    }

	    let isValid = true;
	    let missingFields = [];
	    $rows.each(function (index) {
	        let $row = $(this);
	        let brand       = $row.find(".brand").val();
	        let model       = $row.find(".model").val();
	        let category    = $row.find(".category").val();
	        let srp         = $row.find(".sellingprice").val();
	        let $qty        = $row.find(".quantity");
	        let qty         = $qty.val();
	        let discounted  = $row.find(".discountedamountperunit").val();
	        let gross       = $row.find(".grosstotal").val();

	        if (!brand)        { isValid = false; missingFields.push(`Row ${index+1}: Brand`); }
	        if (!model)        { isValid = false; missingFields.push(`Row ${index+1}: Model`); }
	        if (!category)     { isValid = false; missingFields.push(`Row ${index+1}: Category`); }
	        if (!srp)          { isValid = false; missingFields.push(`Row ${index+1}: Selling Price`); }
	        if (!qty || $qty.prop("disabled")) {
	            isValid = false;
	            missingFields.push(`Row ${index+1}: Quantity`);
	        }
	        if (!discounted)   { isValid = false; missingFields.push(`Row ${index+1}: Discounted Amount Per Unit`); }
	        if (!gross)        { isValid = false; missingFields.push(`Row ${index+1}: Gross Total`); }
	    });

	    if (!isValid) {
	        Swal.fire({
	            icon: "warning",
	            title: "Incomplete Order",
	            html: `Please fill in the following fields before proceeding.`
	        });
	        return; 
	    }
	    let invalidGrandTotal = false;
	    $rows.each(function () {
	        let $row = $(this);
	        let gross = parseFloat($row.find(".grosstotal").val().replace(/,/g, "")) || 0;

	        if (gross <= 0) {
	            invalidGrandTotal = true;
	            return false; // stop loop
	        }
	    });

	    if (invalidGrandTotal) {
	        Swal.fire({
	            icon: "warning",
	            title: "Invalid Grand Total",
	            text: "Please check for negative or empty amount."
	        });
	        return;
	    }
	    $('a[href="#termscondition"]').tab('show');
	}
</script>


