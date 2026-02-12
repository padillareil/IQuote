<?php
require_once '../../../config/local_db.php';
$Banks = $conn->prepare("
    SELECT RowNum, BankAccountName, Bank, BankAccountNumber, Corporation, BankOwnership, Corpcode
    FROM CORPBNK
");
$Banks->execute();
$rows = $Banks->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
   <button class="btn btn-outline-secondary" type="button" onclick="addTransferBank()">Add Head Office - Bank Transfer</button>
    <div class="d-flex align-items-center gap-2">
        <input type="search" name="search-transferbank" id="search-transferbank" class="form-control" placeholder="Search" style="max-width: 250px;">
    </div>
</div>
<div class="card shadow-sm mt-2">
  <div class="card-body">
    <div class="table-responsive" id="bank-corpo" style="height: 75vh;">
      <table class="table table-sm table-bordered table-hover" >
        <thead>
          <tr class="text-center">
            <th colspan="5"><h4 class="text-muted">BANK TRANSFER ACCOUNT'S</h4></th>
          </tr>
          <tr class="table-secondary text-center">
            <th>Bank</th>
            <th>Account Name</th>
            <th>Account Number</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="text-center" id="bank-transfer">
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?php echo $row['Bank']; ?></td>
                <td><?php echo reil_decrypt($row['BankAccountName']); ?></td>
                <td><?php echo reil_decrypt($row['BankAccountNumber']); ?></td>
                <td class="t-action">
                  <button class="btn btn-sm btn-outline-secondary mb-2" type="button" onclick="editBank('<?php echo $row['RowNum']; ?>')"><i class="bi bi-repeat"></i> Update</button>
                  <button class="btn  btn-sm btn-outline-danger" type="button" onclick="deleteBank('<?php echo $row['RowNum']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
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
