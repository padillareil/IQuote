<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div class="mb-2">
    <h4 class="text-muted mb-0">
      <span class="text-uppercase" id="department"></span>
    </h4>
    <small class="text-muted">List of all staff under your supervision.</small>
  </div>
  <div class="col-md-3 text-md-end text-start">
    <button class="btn btn-outline-secondary" type="button" title="Create Account" onclick="mdlStaff()">
      <i class="bi bi-plus text-danger"></i> Create Account
    </button>
  </div>
</div>

<hr>
  <div class="row g-2">
   <!--  <div class="col-md-2">
      <select class="form-select" id="filter-status">
        <option selected disabled>Filter</option>
        <option value="Online">Online</option>
        <option value="Offline">Online</option>
      </select>
    </div> -->
    <div class="col-md-12">
      <input type="search" name="search-staff" id="search-staff" placeholder="Search" class="form-control">
    </div>
  </div>
  <?php
  session_start();
  $Admin = $_SESSION['UserName'];

  require_once '../../../../config/local_db.php';

  // Get branch of the logged-in user
  $adminStmt = $conn->prepare("SELECT Branch FROM USR WHERE UserName = ?");
  $adminStmt->execute([$Admin]);
  $Branch = $adminStmt->fetchColumn();

  // Get all staff in the same branch
  $staffStmt = $conn->prepare("
      SELECT UserName, Name, UPosition, Branch, AccountStatus
      FROM USR
      WHERE Createdby = ? AND AccountStatus != 'REMOVED'
      ORDER BY Name ASC
  ");
  $staffStmt->execute([$Admin]);
  $staffList = $staffStmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <div class="card shadow-sm mt-2" id="account-users" style="height:60vh;">
    <div class="card-body" id="search-account">
      <div class="list-group list-group-flush border-bottom scrollarea" id="staff-results">
        
          <?php if (count($staffList) > 0): ?>
              <?php foreach ($staffList as $row): ?>
                  <a href="#" class="list-group-item list-group-item-action" aria-current="true" onclick="mdl_UserAccount('<?php echo $row['UserName']; ?>'); getUsername('<?php echo $row['UserName']; ?>')">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <small class="text-muted d-block">Name:</small>
                        <strong class="mb-1"><?php echo $row['Name']; ?></strong>
                      </div>
                      <div class="text-end">
                        <small class="text-muted d-block">Account Status:</small>
                        <?php if ($row['AccountStatus'] === 'ENABLE'): ?>
                          <span class="badge bg-success"><?php echo $row['AccountStatus']; ?></span>
                        <?php elseif ($row['AccountStatus'] === 'DISABLED'): ?>
                          <span class="badge bg-danger"><?php echo $row['AccountStatus']; ?></span>
                        <?php else: ?>
                          <span class="badge bg-secondary"><?php echo $row['AccountStatus']; ?></span>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <div>
                        <small class="text-muted d-block">Position:</small>
                        <strong><?php echo $row['UPosition']; ?></strong>
                      </div>
                      <div class="text-end">
                        <small class="text-muted d-block">Account Assignment:</small>
                        <small class="text-muted d-block"><?php echo $row['Branch']; ?></small>
                      </div>
                    </div>
                  </a>
              <?php endforeach; ?>
          <?php else: ?>
              <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
                  <div class="d-flex w-100 align-items-center justify-content-between">
                      <strong class="mb-1">No Staff record.</strong>
                  </div>
              </a>
          <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
  /*Script for scrollbar*/
  $(document).ready(function() {
      OverlayScrollbars(document.getElementById("account-users"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      });
  });

/*Script search account*/
  $(document).ready(function () {
    $('#search-staff').on('input', function () {
      const search = $(this).val().toLowerCase();
      
      $('#search-account a.list-group-item').each(function () {
        const rowText = $(this).text().toLowerCase();

        if (rowText.includes(search)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  });
;

</script>
