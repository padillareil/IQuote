<button class="btn btn-outline-secondary" type="button" onclick="createContact()">Create Contact</button>

<?php
require_once '../../../config/local_db.php';

$Contact = $conn->prepare("
    SELECT Branch, TID, Telephone, Mobile, Network
    FROM contacts
    ORDER BY Branch 
");
$Contact->execute();
$rows = $Contact->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card shadow-sm mt-2">
  <div class="card-body">
    <div class="table-responsive" id="load-contacts" style="height: 75vh;">
      <table class="table table-bordered table-hover" >
        <thead class="table-secondary text-center">
          <tr>
            <th>Branch</th>
            <th>Telephone</th>
            <th>Mobile</th>
            <th>Network</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?php echo $row['Branch']; ?></td>
                <td><?php echo $row['Telephone']; ?></td>
                <td><?php echo $row['Mobile']; ?></td>
                <td><?php echo $row['Network']; ?></td>
                <td class="t-action">
                  <button class="btn btn-outline-secondary" type="button" onclick="updateContact('<?php echo $row['TID']; ?>')"><i class="bi bi-repeat"></i> Update</button>
                  <button class="btn btn-outline-danger" type="button" onclick="mdldelContact('<?php echo $row['TID']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
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
      OverlayScrollbars(document.getElementById("load-contacts"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      });
  });
</script>