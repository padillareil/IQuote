<div class="container-fluid">
	<div class="mb-2 mt-2">
	  <div class="card shadow-sm border-0 bg-light">
	    <div class="card-body d-flex align-items-center">
	      <div class="me-3">
	        <img src="../assets/image/icon/logo.png" alt="iQuote Logo" style="width: 8vh; height: 8vh; border-radius: 8px;">
	      </div>
	      <div>
	        <h4 class="mb-1 fw-bold text-danger">Imperial Appliance Plaza - Branch List</h4>
	        <small class="text-muted">Add and update branch.</small>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="card card-shadow">
		<div class="card-body">
			<div id="load_IAP_branch"></div>
		</div>
		<div class="card-footer d-flex justify-content-between">
		  <button class="btn btn-outline-secondary" type="button" id="btn-preview">Preview</button>
		  <button class="btn btn-outline-secondary" type="button" id="btn-next">Next</button>
		</div>
	</div>
</div>

<input type="hidden" id="branch-id">


<script src="dirs/branch/script/branch.js"></script>

<?php include 'modal.php'; ?>


