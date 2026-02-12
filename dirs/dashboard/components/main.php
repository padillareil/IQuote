<button class="btn btn-outline-secondary mb-3" type="button" onclick="resetAccount()">Reset Account</button>

<?php
require_once '../../../config/local_db.php';

$REset = $conn->prepare("
    SELECT Time, ResetDate, Username
    FROM accountreset_logs
    ORDER BY Docdate 
");
$REset->execute();
$rows = $REset->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card shadow-sm mt-2">
  <div class="card-body">
    <div class="table-responsive" id="load-reset" style="height: 75vh;">
      <table class="table table-bordered table-hover" >
        <thead class="table-secondary text-center">
          <tr>
            <th>Time</th>
            <th>Date</th>
            <th>Admin</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?php echo $row['Time']; ?></td>
                <td><?php echo $row['ResetDate']; ?></td>
                <td><?php echo $row['Username']; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">No Reset Schedule Available.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
      OverlayScrollbars(document.getElementById("load-reset"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      });
  });
</script>