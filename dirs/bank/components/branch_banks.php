<?php
require_once '../../../config/local_db.php';


function reil_decrypt(string $encryptedData): string {
    $key = hash('sha256', 'Greek2001', true);
    $data = base64_decode($encryptedData);
    if ($data === false || strlen($data) < 17) return '';

    $iv = substr($data, 0, 16);
    $cipher = substr($data, 16);
    $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? '' : $plain;
}

$Banks = $conn->prepare("
    SELECT Bnkid, Bank, AccName, AccNumber, Branch
    FROM bnk
    WHERE BnkOwnership = 'BRNCH'
    ORDER BY Branch 
");
$Banks->execute();
$rows = $Banks->fetchAll(PDO::FETCH_ASSOC);
?>
			
<div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-outline-secondary" type="button" onclick="mdlCreateBranch()">Add Branch Bank</button>
    <div class="d-flex align-items-center gap-2">
        <input type="search" name="search-branchbank" id="search-branchbank" class="form-control" placeholder="Search" style="max-width: 250px;">
    </div>
</div>

<div class="card shadow-sm mt-2">
  <div class="card-body">
    <div class="table-responsive" id="bank-branches" style="height: 75vh;">
      <table class="table table-sm table-bordered table-hover" >
        <thead>
          <tr class="text-center">
            <th colspan="5"><h4 class="text-muted">BRANCH BANK ACCOUNT'S</h4></th>
          </tr>
          <tr class="table-secondary text-center">
            <th>Branch</th>
            <th>Bank</th>
            <th>Account Name</th>
            <th>Account Number</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="text-center" id="bank-branches-table" >
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td><?php echo $row['Branch']; ?></td>
                <td><?php echo $row['Bank']; ?></td>
                <td><?php echo reil_decrypt($row['AccName']); ?></td>
                <td><?php echo reil_decrypt($row['AccNumber']); ?></td>
                <td class="t-action">
                  <button class="btn btn-sm btn-outline-secondary mb-2" type="button" onclick="updateBank('<?php echo $row['Bnkid']; ?>')"><i class="bi bi-repeat"></i> Update</button>
                  <button class="btn  btn-sm btn-outline-danger" type="button" onclick="mdldelBank('<?php echo $row['Bnkid']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
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
			