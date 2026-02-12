<!-- Nav Pills -->
<ul class="nav nav-pills nav-fill justify-content-center d-none">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#customer">Customer</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#payment">Payment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#order">Order</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#termscondition">Terms & Condition</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#warranty">Warranty</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#remarks">Finish</a>
  </li>
</ul>
<div class="mb-2 mt-2">
  <div class="card shadow-sm border-0 bg-light">
    <div class="card-body d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <div class="me-3">
          <img src="../assets/image/logo/qtlogo.png" alt="iQuote Logo" style="width: 50px; height: 50px; border-radius: 8px;">
        </div>
        <div>
          <h4 class="mb-1 fw-bold text-danger">Review Quotation</h4>
          <p class="mb-0 text-muted small">
              Review the details before proceeding with approval.
          </p>
        </div>
      </div>

      <!-- Dropdown Button -->
      <div class="dropdown">
        <button class="btn bi bi-list btn-outline-secondary" type="button" id="action-menu" data-bs-toggle="dropdown" aria-expanded="false">
        </button>
        <ul class="dropdown-menu" aria-labelledby="action-menu">
          <li><a class="dropdown-item" href="#" onclick="loadInbox()"><i class="bi bi-arrow-return-left me-2"></i>Back</a></li>
          <li><a class="dropdown-item" id="btn-approved" href="#" onclick="mdlApproval()"><i class="bi bi-check2 me-2"></i>Approve</a></li>
          <li><a class="dropdown-item" id="btn-onhold" href="#" onclick="mdlOnhold()"><i class="bi bi-check2 me-2"></i>Onhold</a></li>
          <li><a class="dropdown-item" id="btn-reject" href="#" onclick="mdlReject()"><i class="bi bi-x-lg me-2"></i>Reject</a></li>
          <li><a class="dropdown-item" id="btn-cancel" href="#" onclick="mdlCancel()"><i class="bi bi-x-circle me-2"></i>Cancel</a></li>
          <li><a class="dropdown-item" id="btn-generate" href="#" onclick="mdllink()"><i class="bi bi-link me-2"></i>Generate Link</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


<!-- Card Content -->
<div class="card mt-2 shadow">
  <div class="card-body">
    <div class="tab-content mt-3">
      <div class="tab-pane fade show active" id="customer">
        <?php include 'customer.php'; ?>
      </div>
      <div class="tab-pane fade" id="payment">
        <?php include 'payment.php'; ?>
      </div>
      <div class="tab-pane fade" id="order">
        <?php include 'order.php'; ?>
      </div>
      <div class="tab-pane fade" id="termscondition">
        <?php include 'termscondition.php'; ?>
      </div>
      <div class="tab-pane fade" id="warranty">
        <?php include 'warranty.php'; ?>
      </div>
      <div class="tab-pane fade" id="remarks">
        <?php include 'remarks.php'; ?>
      </div>
    </div>
  </div>
</div>
<div class="card shadow mt-2">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 mb-2">
        <div class="form-floating">
          <input type="text" id="preparedby" name="preparedby" class="form-control" placeholder="Prepared by" readonly>
          <label for="preparedby">Prepared by</label>
        </div>
      </div>
      <div class="col-md-6 mb-2">
        <div class="form-floating">
          <input type="text" id="datecreated" name="datecreated" class="form-control" placeholder="Date Created" readonly>
          <label for="datecreated">Date Created</label>
        </div>
      </div>
    </div>
  </div>
</div>




<?php include '../modal.php';  ?>

