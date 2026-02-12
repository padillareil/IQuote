<div class="card shadow-sm">
  <div class="card-body">
    <div class="mb-2 d-flex justify-content-between align-items-center">
      <button class="btn btn-outline-secondary mb-2" onclick="addtransferBank()">Add New Bank</button>
      <input type="search" id="search-transfer-bank" class="form-control w-25" placeholder="Search...">
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
        <tbody id="transfer-bank-table"></tbody>
      </table>
    </div>
  </div>
  <div class="card-footer d-flex justify-content-between">
    <button class="btn btn-outline-secondary" type="button" id="btn-preview-personal">Preview</button>
    <button class="btn btn-outline-secondary" type="button" id="btn-next-personal">Next</button>
  </div>
</div>

<script>
  $("#search-transfer-bank").on("keydown", function(e) {
      if (e.key === "Enter") {
          loadHeadOfficeBanks();
      }
  });
  /* Pagination + Fetch Blocked Accounts */
  $("#btn-preview-personal").on("click", function() {
      if (CurrentPage > 1) {
          loadHeadOfficeBanks(CurrentPage - 1);
      } else {
          console.log("You're already on the first page.");
      }
  });


  $("#btn-next-personal").on("click", function() {
      loadHeadOfficeBanks(CurrentPage + 1);
  });


</script>