<!-- Nav Tabs -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#branch-bank">Bank Account - Branch</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#corporate-bank">Corporate Bank Accounts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#bank-transfer">Bank Transfer</a>
  </li>
</ul>

<!-- Tab Content -->
<div class="tab-content mt-3">
  <div class="tab-pane fade show active" id="branch-bank">
    <?php include 'branchbank.php'; ?>
  </div>
  <div class="tab-pane fade" id="corporate-bank">
    <?php include 'corpobank.php'; ?>
    
  </div>
  <div class="tab-pane fade" id="bank-transfer">
    <?php include 'banktransfer.php'; ?>
  </div>
</div>
