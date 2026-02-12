<div class="row g-2">
	<div class="col-md-6">
		<button class="btn btn-outline-secondary" type="button" onclick="createPaymentTerm()">Create Payment Term</button>
		<div class="card shadow-sm mt-2">
			<div class="card-body">
				<?php
				require_once '../../../config/local_db.php';

				$Paymenterm = $conn->prepare("
				    SELECT PayTerm, PayPeriod, Pay_id 
				    FROM instlment
				    ORDER BY Pay_id ASC 
				");
				$Paymenterm->execute();
				$rows = $Paymenterm->fetchAll(PDO::FETCH_ASSOC);
				?>

				<div class="card shadow-sm mt-2">
				  <div class="card-body">
				    <div class="table-responsive" id="bank-branches" style="height: 75vh;">
				      <table class="table table-sm table-bordered table-hover" >
				        <thead>
				          <tr class="table-secondary text-center">
				            <th>Payment Terms</th>
				            <th>Payment Period</th>
				            <th></th>
				          </tr>
				        </thead>
				        <tbody class="text-center">
				          <?php if (count($rows) > 0): ?>
				            <?php foreach ($rows as $row): ?>
				              <tr>
				                <td><?php echo $row['PayTerm']; ?></td>
				                <td><?php echo $row['PayPeriod']; ?></td>
				                <td class="t-action">
				                  <button class="btn btn-sm btn-outline-secondary" type="button" onclick="updatePayterm('<?php echo $row['Pay_id']; ?>')"><i class="bi bi-repeat"></i> Update</button>
				                  <button class="btn  btn-sm btn-outline-danger" type="button" onclick="mdldelPayment('<?php echo $row['Pay_id']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
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
			</div>
		</div>
	</div>



	<div class="col-md-6">
		<button class="btn btn-outline-secondary" type="button" onclick="createDownpayment()">Create Downpayment</button>
		<div class="card shadow-sm mt-2">
			<div class="card-body">
				<?php
				require_once '../../../config/local_db.php';

				$Downpayment = $conn->prepare("
				    SELECT DPayment, DP_id 
				    FROM dwnpyment
				    ORDER BY DP_id ASC 
				");
				$Downpayment->execute();
				$rows = $Downpayment->fetchAll(PDO::FETCH_ASSOC);
				?>

				<div class="card shadow-sm mt-2">
				  <div class="card-body">
				    <div class="table-responsive" id="bank-branches" style="height: 75vh;">
				      <table class="table table-sm table-bordered table-hover" >
				        <thead>
				          <tr class="table-secondary text-center">
				            <th>Downpayment</th>
				            <th></th>
				          </tr>
				        </thead>
				        <tbody class="text-center">
				          <?php if (count($rows) > 0): ?>
				            <?php foreach ($rows as $row): ?>
				              <tr>
				                <td><?php echo $row['DPayment']; ?></td>
				                <td class="t-action">
				                  <button class="btn btn-sm btn-outline-secondary" type="button" onclick="updateDownpayment('<?php echo $row['DP_id']; ?>')"><i class="bi bi-repeat"></i> Update</button>
				                  <button class="btn  btn-sm btn-outline-danger" type="button" onclick="mdldelDownpayment('<?php echo $row['DP_id']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
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
			</div>
		</div>
	</div>

</div>