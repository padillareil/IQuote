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
    <div class="card-body d-flex align-items-center">
      <div class="me-3">
        <img src="../assets/image/icon/logo.png" style="height: 8vh; width: 8vh;">
      </div>
      <div>
        <h4 class="mb-1 fw-bold text-danger">Quotation Form</h4>
        <p class="mb-0 text-muted small">
          Quick, automatic, and paperless quotation — always here to help you serve your customers better.
        </p>
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


<?php include '../modal.php';  ?>