<!-- Create order -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div>
    <h4 class="text-muted mb-0">Order(s)</h4>
<!--     <small class="text-muted">Choose the unit and proceed to place the order.</small> -->
  </div>
</div>
<hr>
<div class="card shadow-sm mb-2">
	<div class="card-body">
		<div id="item-orders"></div>
	</div>
	<div class="card-footer">
		<div class="row">
			<div class="col-md-6 mb-2">
				<div class="form-floating mb-2">
				  <input type="text" id="edit-deliverycharge" name="edit-deliverycharge" class="form-control border border-warning edit-deliverycharge" placeholder="Delivery Charge">
				  <label for="edit-deliverycharge">Delivery Charge</label>
				</div>
			</div>
			<div class="col-md-6 mb-2">
				<div class="form-floating mb-2">
				  <input type="text" id="edit-grandtotal" name="edit-grandtotal" class="form-control edit-grandtotal" placeholder="Grand Total" readonly>
				  <label for="edit-grandtotal">Grand Total</label>
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
	$(document).ready(function () {
	    $(document).on("input", "#edit-deliverycharge", function () {
	        let val = $(this).val();
	        val = val.replace(/[^0-9]/g, "");
	        if (val === "" || parseInt(val) < 0) {
	            $(this).val('');
	        } else {
	            $(this).val(val);
	        }
	    });
	});
</script>

