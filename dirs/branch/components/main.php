<?php
require_once '../../../config/local_db.php';

$Branch = $conn->prepare("
    SELECT BranchCode, Branch, Branch_id, Area, Address
    FROM branches
    ORDER BY Branch 
");
$Branch->execute();
$rows = $Branch->fetchAll(PDO::FETCH_ASSOC);

/* Count all Branches */
$Branches = $conn->prepare("
    SELECT COUNT(Branch) AS TotalBranch
    FROM branches
");
$Branches->execute();
$row = $Branches->fetch(PDO::FETCH_ASSOC);

$totalBranches = $row['TotalBranch'];

?>


<div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-outline-secondary" type="button" onclick="createBranch()">
        Create Branch
    </button>
    <div class="d-flex align-items-center gap-2">
        <input type="search" name="search-branch" id="search-branch" class="form-control" placeholder="Search" style="max-width: 250px;">
        <h6 class="mb-0 ml-4">Total Branch: <?php echo $totalBranches; ?></h6>
    </div>
</div>


<div class="card shadow-sm mt-2">
  <div class="card-body">
    <div class="table-responsive" id="load-branches" style="height: 75vh;">
      <table class="table table-bordered table-hover" >
        <thead class="table-secondary text-center">
          <tr>
            <th>Code</th>
            <th>Branch</th>
            <th>Area</th>
            <th>Store Address</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="text-center"  id="branch-table">
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?php echo $row['BranchCode']; ?></td>
                <td><?php echo $row['Branch']; ?></td>
                <td><?php echo $row['Area']; ?></td>
                <td><?php echo $row['Address']; ?></td>
                <td class="t-action">
                  <button class="btn btn-outline-secondary" type="button" onclick="updateDetails('<?php echo $row['Branch_id']; ?>')"><i class="bi bi-repeat"></i> Update</button>
                  <button class="btn btn-outline-danger" type="button" onclick="mdldelBranch('<?php echo $row['Branch_id']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">No Account Available.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
      OverlayScrollbars(document.getElementById("load-branches"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      });
  });

  $(document).ready(function(){
      $("#search-branch").on("keyup", function(){
          var value = $(this).val().toLowerCase();
          $("#branch-table tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
      });
  });

</script>