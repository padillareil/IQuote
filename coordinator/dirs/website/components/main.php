<div class="container">
	<div class="card shadow-sm">
		<div class="card-header">
			<button class="btn btn-outline-secondary" type="button" onclick="mdlWeblink()">Add Website Link</button>
		</div>
		<div class="card-body">
			<?php 
			require_once '../../../../config/local_db.php';

			$Expiry = $conn->prepare("
			    SELECT
			        Web_id,
			        Web_url,
			        Username
			    FROM WEBSITE_CONTROL
			");
			$Expiry->execute();

			$rows = $Expiry->fetchAll();
			?>

			<table class="table table-hover table-bordered text-center">
			  <thead>
			    <tr>
			      <th>Weblink (URL)</th>
			      <th>Authority</th>
			      <th>Action</th>
			    </tr>
			  </thead>

			  <tbody>
			    <?php if (count($rows) > 0): ?>
			      <?php foreach ($rows as $row): ?>
			        <tr>
			          <td><?php echo $row['Web_url'];  ?></td>
			          <td><?php echo $row['Username'];  ?></td>
			          <td class="t-action">
			            <button class="btn btn-sm btn-outline-danger" onclick="editWeblink('<?php echo $row['Web_id']; ?>')">Edit</button>
			            <button class="btn btn-sm btn-outline-secondary" onclick="deleteWeblink('<?php echo $row['Web_id']; ?>')">Delete</button>
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