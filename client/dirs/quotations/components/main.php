<!-- Nav Pills -->
<ul class="nav nav-pills nav-fill justify-content-center d-none">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#inbox">Customer</a>
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
        <h4 class="mb-1 fw-bold text-danger">Inbox</h4>
        <small class="text-muted">All quotations you’ve created are listed here.</small>
      </div>
    </div>
  </div>
</div>

<!-- Card Content -->
<div class="card mt-2 shadow">
  <div class="card-body">
    <div class="tab-content mt-3">
      <div class="tab-pane fade show active" id="inbox">
        <?php include 'inbox.php'; ?>
      </div>
      <div class="tab-pane fade" id="edit">
        <?php include 'editquotation.php'; ?>
      </div>
    </div>
  </div>
</div>


<?php include '../modal.php';  ?>