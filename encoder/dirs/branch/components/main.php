<div class="mb-2 d-flex justify-content-between align-items-center">
	<button class="btn btn-outline-secondary mb-2" type="button" onclick="mdladdBranch()">Add New Branch</button>
	<input type="search" name="search-branch" id="search-branch" class="form-control w-25" placeholder="Search...">
</div>

<div class="mt-2">
    <div class="table-responsive overscroll-auto" style="height: 60vh;">
      <table class="table table-sm table-bordered table-hover" >
        <thead>
          <tr class="table-secondary text-center">
            <th>Branch code</th>
            <th>Branch</th>
            <th>Address</th>
            <th>Area</th>
            <th>Coporate Code</th>
            <th>Company</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="text-center" id="branches-table" >
          
        </tbody>
      </table>
  </div>

  <script>
    $("#search-branch").on("keydown", function(e) {
        if (e.key === "Enter") {
            loadImperialBranch();
        }
    });
  </script>

  