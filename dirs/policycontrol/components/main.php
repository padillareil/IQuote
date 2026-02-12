<button class="btn btn-outline-secondary" type="button" title="Create Terms & Condition" onclick="createTerms()">Create Policy</button>

<div class="card shadow-sm mt-2">
	<div class="card-body">
		<?php
		require_once '../../../config/local_db.php';

		$Termscondition = $conn->prepare("
		    SELECT TRMSCON, Termdid 
		    FROM trmscondition
		    ORDER BY Termdid ASC 
		");
		$Termscondition->execute();
		$rows = $Termscondition->fetchAll(PDO::FETCH_ASSOC);
		?>

		<div class="card shadow-sm mt-2">
		  <div class="card-body">
		    <div class="table-responsive" id="bank-branches" style="height: 75vh;">
		      <table class="table table-sm table-bordered table-hover" >
		        <thead>
		          <tr class="table-secondary text-center">
		            <th>Terms and condition</th>
		            <th></th>
		          </tr>
		        </thead>
		        <tbody class="text-center">
		          <?php if (count($rows) > 0): ?>
		            <?php foreach ($rows as $row): ?>
		              <tr>
		                <td><?php echo $row['TRMSCON']; ?></td>
		                <td class="t-action">
		                  <button class="btn btn-sm btn-outline-secondary mb-2" type="button" onclick="updateTerms('<?php echo $row['Termdid']; ?>')"><i class="bi bi-repeat"></i> Update</button>
		                  <button class="btn  btn-sm btn-outline-danger" type="button" onclick="mdldelTerms('<?php echo $row['Termdid']; ?>')"><i class="bi bi-trash"></i>  Remove</button>
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