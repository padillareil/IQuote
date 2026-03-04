<!-- Create Unit Warranty -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div>
    <h4 class="text-muted mb-0">Warranty of Unit.</h4>
    <small class="text-muted">Apply the warranty details and coverage of the unit.</small>
  </div>
  <div class="justify-content-end d-flex col-md-6">
  	<button class="btn btn-outline-secondary" type="button" onclick="createWarranty()"><i class="bi bi-plus text-danger"></i>	Create Warranty</button>
  </div>
</div>
<hr>
<div class="mt-2 mb-2" id="warranty-container" style="height:40vh;">
	<div class="mt-2 mb-2" id="warranty-display"></div>

	
</div>
<hr>
<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-secondary me-2" type="button" onclick="returnForm6()">Back</button>
	<button class="btn btn-danger" type="button" onclick="loadForm6()">Next</button>
</div>


<script>
	/*Script for scrollbar*/
	$(document).ready(function() {
	    OverlayScrollbars(document.getElementById("warranty-container"), {
	        className: "os-theme-dark",
	        scrollbars: {
	          autoHide: "leave",
	          clickScrolling: true
	        }
	    });
	});

	function createWarranty() {
	    const container = document.getElementById("warranty-display");

	    // Create wrapper div
	    const wrapper = document.createElement("div");
	    wrapper.classList.add("col-md-12", "mb-2", "warranty");

	    // Inner HTML: textarea + remove button
	    wrapper.innerHTML = `
	        <div class="col-md-12 mb-2 warranty">
	        	<div class="input-group">
	        	  <textarea class="form-control warranty" name="warranty[]" style="height: 10vh;" placeholder="Warranty"></textarea>
	        	  <button class="btn btn-outline-danger bi bi-x-lg" type="button" title="Remove"></button>
	        	</div>
	        </div>
	    `;

	    // Append to container
	    container.appendChild(wrapper);

	    // Add click event to remove button
	    const removeBtn = wrapper.querySelector("button");
	    removeBtn.addEventListener("click", function() {
	        wrapper.remove();
	    });
	}

</script>