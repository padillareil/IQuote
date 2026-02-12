<!-- Create Unit Terms and Condition -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div>
    <h4 class="text-muted mb-0">Terms and Condition of Unit.</h4>
    <small class="text-muted">Set the agreement details and policies for this unit.</small>
  </div>
  <div class="justify-content-end d-flex col-md-6">
  	<button class="btn btn-outline-secondary" type="button" onclick="createTerms()"><i class="bi bi-plus text-danger"></i>	Create Terms</button>
  </div>
</div>
<hr>
<div class="card mt-2 mb-2" id="oterms-condition-container" style="height:40vh;">
	<div id="terms-condition-display" class="mt-2 mb-3"></div>
</div>
<hr>
<div class="justify-content-end d-flex mt-3 mb-3">
		<button class="btn btn-secondary me-2" type="button" onclick="returnForm5()">Back</button>
	<button class="btn btn-danger" type="button" onclick="loadForm5()">Next</button>
</div>





<script>
	/*Script for scrollbar*/
	$(document).ready(function() {
	    OverlayScrollbars(document.getElementById("oterms-condition-container"), {
	        className: "os-theme-dark",
	        scrollbars: {
	          autoHide: "leave",
	          clickScrolling: true
	        }
	    });
	});

	function createTerms() {
	    const container = document.getElementById("terms-condition-display");

	    // Create wrapper div
	    const wrapper = document.createElement("div");
	    wrapper.classList.add("col-md-12", "mb-2", "termscondition");

	    // Inner HTML: textarea + remove button
	    wrapper.innerHTML = `
	        <div class="input-group">
	            <textarea class="form-control termscondition" name="termscondition[]" style="height: 10vh;" placeholder="Terms & Condition"></textarea>
	            <button class="btn btn-outline-danger bi bi-x-lg" type="button" title="Remove"></button>
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