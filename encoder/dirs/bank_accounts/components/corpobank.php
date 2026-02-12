<div class="card shadow-sm">
  <div class="card-body">
    <div class="mb-2 d-flex justify-content-between align-items-center">
      <button class="btn btn-outline-secondary mb-2" onclick="addCorpBranch()">Add New Bank</button>
      <input type="search" id="search-corp-bank" class="form-control w-25" placeholder="Search...">
    </div>
    <div class="table-responsive overscroll-auto" style="height:60vh;">
      <table class="table text-center table-bordered table-hover">
        <thead>
          <tr class="table-secondary text-center">
           <th>Bank</th>
           <th>Account name</th>
           <th>Account number</th>
           <th>Actions</th>
          </tr>
        </thead>
        <tbody id="corp-bank-table"></tbody>
      </table>
    </div>
  </div>
  <div class="card-footer d-flex justify-content-between">
    <button class="btn btn-outline-secondary" type="button" id="btn-preview-corpo">Preview</button>
    <button class="btn btn-outline-secondary" type="button" id="btn-next-corpo">Next</button>
  </div>
</div>

<script>
  $("#search-corp-bank").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadCorporate();
      }
  });
  /* Pagination + Fetch Blocked Accounts */
  $("#btn-preview-corpo").on("click", function() {
      if (CurrentPage > 1) {
          loadCorporate(CurrentPage - 1);
      } else {
          console.log("You're already on the first page.");
      }
  });


  $("#btn-next-corpo").on("click", function() {
      loadCorporate(CurrentPage + 1);
  });


</script>