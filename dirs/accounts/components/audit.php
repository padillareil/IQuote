<?php
require_once '../../../config/local_db.php';

$User = $conn->prepare("
    SELECT UserName, Name, UPosition, Branch, AccountStatus
    FROM USR
    WHERE Position = 'Audit'    ORDER BY Name ASC
");
$User->execute();
$rows = $User->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-outline-secondary mb-3" type="button" onclick="createAudit()">Create Audit</button>
    <div class="d-flex align-items-center gap-2">
        <input type="search" name="search-branch" id="search-branch" class="form-control" placeholder="Search" style="max-width: 250px;">
    </div>
</div>

<div class="card shadow-sm mt-2">
  <div class="card-body">
    <div class="table-responsive overscroll-auto" style="height: 60vh;">
      <table class="table table-bordered">
        <thead class="table-secondary text-center">
          <tr>
            <th>Name</th>
            <th>Position</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="text-center" id="branch-table">
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?php echo $row['Name']; ?></td>
                <td><?php echo $row['UPosition']; ?></td>
                <td class="t-action">
                  <div class="dropdown">
                    <button class="btn btn-sm bi bi-gear btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#" title="Account Support" onclick="mdlRecovery('<?php echo $row['UserName']; ?>')"><i class="bi bi-person-gear"></i> Account Recovery</a></li>
                      <li><a class="dropdown-item" href="#" title="Enable Access" onclick="mdlEnable('<?php echo $row['UserName']; ?>')"><i class="bi bi-toggle-off"></i> Enable Account</a></li>
                      <li><a class="dropdown-item" href="#" title="Block Access" onclick="mdlBlock('<?php echo $row['UserName']; ?>')"><i class="bi bi-toggle-on"></i> Disable Account</a></li>
                      <hr>
                      <li><a class="dropdown-item" href="#" title="Delete Account" onclick="mdlDelete('<?php echo $row['UserName']; ?>')"><i class="bi bi-trash"></i> Delete Account</a></li>
                    </ul>
                  </div>
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
  $(document).ready(function(){
        $("#search-branch").on("keyup", function(){
            var value = $(this).val().toLowerCase();
            $("#branch-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>