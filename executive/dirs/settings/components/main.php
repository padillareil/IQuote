
<div class="container">
	<div class="mb-2 mt-2">
	  <div class="card shadow-sm border-0 bg-light">
	    <div class="card-body d-flex align-items-center">

	      <div class="me-3">
	        <img src="../assets/image/icon/logo.png" alt="iQuote Logo" style="width: 8vh; height: 8vh; border-radius: 8px;">
	      </div>
	      
	      <div>
	        <h4 class="mb-1  text-danger">Settings</h4>
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


	<div class="card shadow-sm border-0">
	    <div class="card-body">
	        <!-- Header with integrated Filter Toggle -->
	        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 border-bottom pb-3">
	            <h4 class="text-secondary mb-0 ">Quotation Summary</h4>
	            
	            <!-- Filter Toggle (Bootstrap Button Group) -->
	            <div class="btn-group" role="group" aria-label="Quotation scope filter">
	                <input type="radio" class="btn-check" name="quoteScope" id="scopeAccount" checked autocomplete="off" onchange="filterSummary('account')">
	                <label class="btn btn-outline-danger btn-sm px-3" for="scopeAccount">My Account</label>

	                <input type="radio" class="btn-check" name="quoteScope" id="scopeTeam" autocomplete="off" onchange="filterSummary('team')">
	                <label class="btn btn-outline-danger btn-sm px-3" for="scopeTeam">My Team</label>
	            </div>
	        </div>

	        <!-- Status Cards Grid -->
	        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3">
	            <!-- Pending Card -->
	            <div class="col">
	                <div class="card h-100 border-start shadow-xs">
	                    <div class="card-body text-center py-3">
	                        <p class="text-muted small  text-uppercase mb-1">Pending</p>
	                        <h2 class=" mb-0" id="number-pending">0</h2>
	                    </div>
	                </div>
	            </div>
	            <!-- Approved Card -->
	            <div class="col">
	                <div class="card h-100 border-start shadow-xs">
	                    <div class="card-body text-center py-3">
	                        <p class="text-muted small  text-uppercase mb-1">Approved</p>
	                        <h2 class=" mb-0" id="number-approved">0</h2>
	                    </div>
	                </div>
	            </div>
	            <!-- Rejected Card -->
	            <div class="col">
	                <div class="card h-100 border-start shadow-xs">
	                    <div class="card-body text-center py-3">
	                        <p class="text-muted small  text-uppercase mb-1">Rejected</p>
	                        <h2 class=" mb-0" id="number-rejected">0</h2>
	                    </div>
	                </div>
	            </div>
	            <!-- On Hold Card -->
	            <div class="col">
	                <div class="card h-100 border-start shadow-xs">
	                    <div class="card-body text-center py-3">
	                        <p class="text-muted small  text-uppercase mb-1">On Hold</p>
	                        <h2 class=" mb-0" id="number-onhold">0</h2>
	                    </div>
	                </div>
	            </div>
	            <!-- Cancelled Card -->
	            <div class="col-12 col-sm-12 col-md-auto flex-fill">
	                <div class="card h-100 border-start shadow-xs">
	                    <div class="card-body text-center py-3">
	                        <p class="text-muted small  text-uppercase mb-1">Cancelled</p>
	                        <h2 class=" mb-0" id="number-cancelled">0</h2>
	                    </div>
	                </div>
	            </div>
	        </div>

	    </div>
	</div>
</div>