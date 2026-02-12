
<div class="row g-2">
	<div class="col-md-6">
		<button class="btn btn-outline-secondary mb-2" type="button" onclick="createPDFHEADER()">Create PDF Header</button>
		<div class="card shadow-sm">
			<div class="card-body">
				<?php
				require_once '../../../config/local_db.php';

				$PDFHeader = $conn->prepare("
				    SELECT Header_id, Corpo, CorpCode
				    FROM crpheader
				    ORDER BY Header_id ASC 
				");
				$PDFHeader->execute();
				$rows = $PDFHeader->fetchAll(PDO::FETCH_ASSOC);
				?>

				<div class="card shadow-sm mt-2">
				  <div class="card-body">
				    <div class="table-responsive" id="load-branches" style="height: 75vh;">
				      <table class="table table-bordered table-hover" >
				        <thead class="table-secondary text-center">
				          <tr>
				            <th>Corpcode</th>
				            <th>Corporation</th>
				            <th></th>
				          </tr>
				        </thead>
				        <tbody class="text-center">
				          <?php if (count($rows) > 0): ?>
				            <?php foreach ($rows as $row): ?>
				              <tr onclick="loadHeaderImage('<?php echo $row['Header_id']; ?>')">
				                <td><?php echo $row['CorpCode']; ?></td>
				                <td><?php echo $row['Corpo']; ?></td>
				                <td class="t-action">
				                  <button class="btn btn-outline-secondary" type="button" onclick="updateDetailsHeader('<?php echo $row['Header_id']; ?>')"><i class="bi bi-repeat"></i> Update</button>
				                  <button class="btn btn-outline-danger" type="button" onclick="mdlDeleteHeader('<?php echo $row['Header_id']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
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
		<div class="card shadow-sm">
			<div class="card-body d-flex justify-content-center align-items-center">
			    <img src="#" alt="PDF Header" class="img-fluid h-100 w-auto" id="preview-image">
			    <input type="hidden" id="image-id">
			</div>
		</div>
	</div>
</div>