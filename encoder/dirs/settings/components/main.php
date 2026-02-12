
<div class="container">
	<div class="mb-2 mt-2">
	  <div class="card shadow-sm border-0 bg-light">
	    <div class="card-body d-flex align-items-center">

	      <div class="me-3">
	        <img src="../assets/image/icon/logo.png" alt="iQuote Logo" style="width: 8vh; height: 8vh; border-radius: 8px;">
	      </div>
	      
	      <div>
	        <h4 class="mb-1 fw-bold text-danger">Settings</h4>
	        <p class="mb-0 text-muted small">Personal Profile.</p>
	      </div>
	      
	      <div class="ms-auto">
	        <button class="btn btn-outline-secondary" type="button" onclick="mdl_account()">Account Security</button>
	      </div>
	      
	    </div>
	  </div>

	</div>
	<div class="card shadow-sm mt-2 p-3">
	  <div class="d-flex align-items-center">
	    
	    <!-- Profile Image -->
	    <div class="me-3">
	      <img src="#" id="profile-image" alt="Profile" class="rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;" onclick="uploadProfile()">
	    </div>

	    <!-- Profile Info -->
	    <div>
	      <div class="mb-2">
	        <h5 class="form-label text-muted mb-0">Name</h5>
	        <p class="mb-0" id="user-fullname"></p>
	      </div>
	      <div class="mb-2">
	        <h5 class="form-label text-muted mb-0">Position</h5>
	        <p class="mb-0" id="user-position"></p>
	      </div>
	    </div>

	  </div>
	</div>


	<!-- <div class="card shadow-sm mt-2">
	  <div class="card-body">
	    	<h4 class="text-muted">Quotation Summary</h4>
	    	<div class="row row-cols-1 row-cols-md-5 g-4">
	    	  <div class="col">
	    	    <div class="card">
	    	      <div class="card-body">
	    	        <p class="card-title text-center">Pending</p>
	    	        <h2 class="card-text text-center" id="number-pending">0</h2>
	    	      </div>
	    	    </div>
	    	  </div>
	    	  <div class="col">
	    	    <div class="card">
	    	      <div class="card-body">
	    	        <p class="card-title text-center">Approved</p>
	    	        <h2 class="card-text text-center" id="number-approved">0</h2>
	    	      </div>
	    	    </div>
	    	  </div>
	    	  <div class="col">
	    	    <div class="card">
	    	      <div class="card-body">
	    	        <p class="card-title text-center">Rejected</p>
	    	        <h2 class="card-text text-center" id="number-rejected">0</h2>
	    	      </div>
	    	    </div>
	    	  </div>
	    	  <div class="col">
	    	    <div class="card">
	    	      <div class="card-body">
	    	        <p class="card-title text-center">On Hold</p>
	    	        <h2 class="card-text text-center" id="number-onhold">0</h2>
	    	      </div>
	    	    </div>
	    	  </div>

	    	  <div class="col">
	    	    <div class="card">
	    	      <div class="card-body">
	    	        <p class="card-title text-center">Cancelled</p>
	    	        <h2 class="card-text text-center" id="number-cancelled">0</h2>
	    	      </div>
	    	    </div>
	    	  </div>
	    	</div>

	  </div>
	</div> -->
</div>