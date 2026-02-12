<div class="container">
	<div class="card shadow-sm">
		<div class="card-header">
			<button class="btn btn-outline-secondary" type="button" onclick="createExpiry()">Create Expiry</button>
		</div>
		<div class="card-body">
			<?php 
			require_once '../../../../config/local_db.php';

			$Expiry = $conn->prepare("
			    SELECT
			        CustomerType,
			        Type,
			        ExpiryDays
			    FROM EXPIRATION_CONTROL
			");
			$Expiry->execute();

			$rows = $Expiry->fetchAll();
			?>

			<table class="table table-hover table-bordered text-center">
			  <thead>
			    <tr>
			      <th>Customer Type</th>
			      <th>Expiration</th>
			      <th>Type</th>
			      <th>Action</th>
			    </tr>
			  </thead>

			  <tbody>
			    <?php if (count($rows) > 0): ?>
			      <?php foreach ($rows as $row): ?>
			        <tr>
			          <td><?php echo $row['CustomerType'];  ?></td>
			          <td><?php echo $row['ExpiryDays'];  ?></td>
			          <td><?php echo $row['Type'];  ?></td>
			          <td class="t-action">
			            <button class="btn btn-sm btn-outline-danger" onclick="editExpiry('<?php echo $row['CustomerType']; ?>')">Edit</button>
			            <button class="btn btn-sm btn-outline-secondary" onclick="deleteExpiry('<?php echo $row['CustomerType']; ?>')">Delete</button>
			          </td>
			        </tr>
			      <?php endforeach; ?>
			    <?php else: ?>
			      <tr>
			        <td colspan="4" class="p-5 text-center text-muted">No data found.</td>
			      </tr>
			    <?php endif; ?>
			  </tbody>
			</table>





		</div>
	</div>
</div>