 <div class="card shadow-sm">
    <div class="card-body">
      <div class="mb-2 d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-secondary mb-2" onclick="addHOBranch()">Add New Bank</button>
        <input type="search" id="search-branch-bank" class="form-control w-25" placeholder="Search...">
      </div>
      <div class="table-responsive overscroll-auto" style="height:60vh;">
        <table class="table text-center table-bordered table-hover">
          <thead>
            <tr class="table-secondary text-center">
              <th>Branch</th>
              <th>Bank</th>
              <th>Account name</th>
              <th>Account number</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="ho-branch-table"></tbody>
        </table>
      </div>
      <div class="card-footer d-flex justify-content-between">
        <button class="btn btn-outline-secondary" type="button" id="btn-preview-branch-bnk">Preview</button>
        <button class="btn btn-outline-secondary" type="button" id="btn-next-branch-bnk">Next</button>
      </div>
    </div>
  </div>

  <script>
    $("#search-branch-bank").on("keydown", function(e) {
        if (e.key === "Enter") {
            loadBranchBanks();
        }
    });
    /* Pagination + Fetch Blocked Accounts */
    $("#btn-preview-branch-bnk").on("click", function() {
        if (CurrentPage > 1) {
            loadBranchBanks(CurrentPage - 1);
        } else {
            console.log("You're already on the first page.");
        }
    });


    $("#btn-next-branch-bnk").on("click", function() {
        loadBranchBanks(CurrentPage + 1);
    });


  </script>