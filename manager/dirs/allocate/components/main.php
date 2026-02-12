<!-- Nav Pills -->
<input type="hidden" id="get-username">
<ul class="nav nav-pills nav-fill justify-content-center d-none">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#account">Account</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#edit">Edit</a>
  </li>
</ul>
<div class="mb-2 mt-2">
  <div class="card shadow-sm border-0 bg-light">
    <div class="card-body d-flex align-items-center">
      <div class="me-3">
        <img src="../assets/image/icon/logo.png" alt="iQuote Logo" style="width: 8vh; height: 8vh; border-radius: 8px;">
      </div>
      <div>
        <h4 class="mb-1 fw-bold text-danger">Accounts</h4>
        <p class="mb-0 text-muted small">Manage and create accounts for staff.</p>
      </div>
    </div>
  </div>
</div>

<!-- Card Content -->
<div class="card mt-2 shadow">
  <div class="card-body">
    <div class="tab-content mt-3">
      <div class="tab-pane fade show active" id="account">
        <?php include 'allocate.php'; ?>
    </div>
  </div>
</div>



