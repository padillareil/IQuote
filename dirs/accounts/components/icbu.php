<?php
require_once '../../../config/local_db.php';

$User = $conn->prepare("
    SELECT UserName, Name, UPosition, Branch, AccountStatus
    FROM USR
    WHERE Role = 'HBU' AND Bcode = 'ICBU'
    ORDER BY Name ASC
");
$User->execute();
$rows = $User->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-end">
    <input type="search" name="search-icbu" id="search-icbu" class="form-control" placeholder="Search" style="max-width: 250px;">
</div>

<div class="card shadow-sm mt-2">
  <div class="card-body">
    <div class="table-responsive overscroll-auto" style="height: 60vh;">
      <table class="table table-bordered">
        <thead class="table-secondary text-center">
          <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="text-center" id="icbu-table">
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?php echo $row['Name']; ?></td>
                <td><?php echo $row['UPosition']; ?></td>
                <td>
                  <?php if ($row['AccountStatus'] === 'ENABLE'): ?>
                    <span class="badge bg-success">Access</span>
                  <?php elseif ($row['AccountStatus'] === 'DISABLED'): ?>
                    <span class="badge bg-danger">Block</span>
                  <?php else: ?>
                    <span class="badge bg-secondary"><?php echo htmlspecialchars($row['AccountStatus']); ?></span>
                  <?php endif; ?>
                </td>

                <td class="t-action">
                  <div class="dropdown">
                    <button class="btn btn-sm bi bi-gear btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#" title="Account Support" onclick="mdlRecovery('<?php echo $row['UserName']; ?>')"><i class="bi bi-person-gear"></i> Account Recovery</a></li>
                      <li><a class="dropdown-item" href="#" title="Upload Signature" onclick="mdlUpload('<?php echo $row['UserName']; ?>')"><i class="bi bi-upload"></i> Upload Signature</a></li>
                      <li><a class="dropdown-item" href="#" title="Account Update" onclick="mdlUpdate('<?php echo $row['UserName']; ?>')"><i class="bi bi-arrow-repeat"></i> Update Account</a></li>
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
     $("#search-icbu").on("keyup", function(){
            var value = $(this).val().toLowerCase();
            $("#icbu-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
