<!-- Create Unit Warranty -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div>
    <h4 class="text-muted mb-0">Warranty</h4>
    <small class="text-muted">Apply the warranty details and coverage of the unit.</small>
  </div>
  <div class="justify-content-end d-flex col-md-6">
  	<button class="btn btn-outline-secondary" type="button" onclick="createWarranty()" id="btn-warranty"><i class="bi bi-plus text-danger"></i>	Add Warranty</button>
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

	/*Prevent key down*/
	$(document).on("keydown", ".warranty", function (e) {
	    if (e.key === "Enter") {
	        e.preventDefault(); 
	        return false;
	    }
	});

	function createWarranty() {
	    const container = document.getElementById("warranty-display");
	    const wrapper = document.createElement("div");
	    wrapper.classList.add("col-md-12", "mb-2", "warranty");
	    wrapper.innerHTML = `
	        <div class="input-group">
	            <textarea class="form-control warranty" name="warranty[]" style="height: 10vh;" placeholder="Warranty"></textarea>
	            <button class="btn btn-outline-danger" type="button" title="Remove">
	                <i class="bi bi-x-lg"></i>
	            </button>
	        </div>
	    `;
	    container.prepend(wrapper);
	    $("#btn-warranty").html('<i class="bi bi-plus text-danger"></i> Add New Warranty');
	    const removeBtn = wrapper.querySelector("button");
	    removeBtn.addEventListener("click", function () {
	        wrapper.remove();
	        if ($("#warranty-display .warranty").length === 0) {
	            $("#btn-warranty").html('<i class="bi bi-plus text-danger"></i> Add Warranty');
	        }
	    });
	}


</script>