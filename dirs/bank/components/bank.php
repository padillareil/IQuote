<div class="card shadow-sm">
	<div class="card-header">
		<ul class="nav nav-tabs">
		  <li class="nav-item">
		    <a class="nav-link active" data-bs-toggle="tab" href="#branch-bank">Bank Account - Branch</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" data-bs-toggle="tab" href="#corporate-bank">Corporate Bank Accounts</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" data-bs-toggle="tab" href="#bank-transfer">Head Office-Bank Transfer</a>
		  </li>
		</ul>
	</div>
	<div class="card-body">
		<div class="tab-content mt-3">
		  <div class="tab-pane fade show active" id="branch-bank">
		    <?php include 'branch_banks.php'; ?>
		  </div>
		  <div class="tab-pane fade" id="corporate-bank">
		    <?php include 'corporate_banks.php'; ?>
		    
		  </div>
		  <div class="tab-pane fade" id="bank-transfer">
		    <?php include 'head_office_banks.php'; ?>
		  </div>
		</div>
	</div>
</div>

<script>
  $(document).ready(function() {
      OverlayScrollbars(document.getElementById("bank-branches"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      });
  });

  $(document).ready(function() {
      OverlayScrollbars(document.getElementById("bank-corpo"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      });
  });


  $(document).ready(function(){
        $("#search-branchbank").on("keyup", function(){
            var value = $(this).val().toLowerCase();
            $("#bank-branches-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

  $(document).ready(function(){
        $("#search-corpbank").on("keyup", function(){
            var value = $(this).val().toLowerCase();
            $("#bank-corpo-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

  $(document).ready(function(){
    $("#search-transferbank").on("keyup", function(){
      var value = $(this).val().toLowerCase();
      $("#bank-transfer tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>
