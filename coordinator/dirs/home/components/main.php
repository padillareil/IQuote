<div class="container">
	<div class="card shadow-sm">
		<div class="card-header">
			<h4 class="card-title ml-2">Expired Quotations</h4>
			<input type="search" name="search-quotation" id="search-quotation" class="form-control" placeholder="Search">
		</div>
		<div class="card-body" style="height: 70vh;" id="quotation-container">
		  <div class="table-responsive">
		    <table class="table table-sm table-hover table-bordered align-middle">
		      <thead class="table-light">
		        <tr class="text-center table-secondary">
		          <th>Ref. No.</th>
		          <th>Releasing Branch</th>
		         	<th>Customer Type</th>
		          <th>Customer</th>
		          <th>Prepared By</th>
		          <th>Actions</th>
		        </tr>
		      </thead>
		      <tbody id="display-quotation">
		      </tbody>
		    </table>
		  </div>
		</div>
		<div class="card-footer d-flex justify-content-between">
			<button class="btn btn-outline-secondary" type="button" id="btn-preview">Previous</button>
			<button class="btn btn-outline-secondary" type="button" id="btn-next">Next</button>
		</div>
	</div>
</div>


<!-- Page Loader -->
<!-- <div class="card-body d-flex justify-content-center align-items-center" style="height: 50vh;" id="quotation-container">
  <div class="text-center" id="page-loader">
    <div class="spinner-border text-danger" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <br>
    <small>Loading Please wait...</small>
  </div>
</div>
 -->


<script>
	$(document).ready(function() {
      OverlayScrollbars(document.getElementById("quotation-container"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
      	});
  	});


	/* --- Pagination and Data Fetching --- */
	var currentPage = 1;
	var pageSize = 100; 
	var isLoading = false;

	$("#btn-preview").prop("disabled", true);

	function loadQuotations(page = 1) {
	  if (isLoading) return;


	  isLoading = true;
	  $("#page-loader").show();

	  $.post("dirs/home/actions/get_quotations.php", {

	    CurrentPage: page,
	    PageSize: pageSize
	  })
	  .done(function(data) {
	    let response;
	    try {
	      response = JSON.parse(data);
	    } catch (e) {
	      console.error("Invalid JSON:", data);
	      Swal.fire({
	        icon: "error",
	        title: "Error",
	        text: "Invalid server response."
	      });
	      return;
	    }

	    if ($.trim(response.isSuccess) === "success") {
	      renderPage(response.Data);
	      currentPage = page;
	      $("#btn-preview").prop("disabled", currentPage === 1);
	      $("#btn-next").prop("disabled", response.Data.length < pageSize);
	    } else {
	      Swal.fire({
	        icon: "error",
	        title: "Error",
	        text: $.trim(response.Data)
	      });
	    }
	  })
	  .fail(function() {
	    Swal.fire({
	      icon: "error",
	      title: "Network Error",
	      text: "Failed to fetch quotations."
	    });
	  })
	  .always(function() {
	    isLoading = false;
	    $("#page-loader").hide();
	  });
	}

	/* --- Render Table Rows --- */
	function renderPage(pageData) {
	  const $list = $("#display-quotation");
	  $list.empty();

	  if (!pageData || pageData.length === 0) {
	    $list.append(`
	      <tr>
	        <td colspan="5" class="text-center py-4 text-muted">
	          <i class="bi bi-file-earmark fs-1 d-block mb-2"></i>
	          No Quotation Available
	        </td>
	      </tr>
	    `);
	    return;
	  }

	  pageData.forEach(item => {
	    $list.append(`
	      <tr class='text-center'>
	        <td>${item.QNumber}</td>
	        <td>${item.Branch}</td>
	    		<td>${item.CustomerType}</td>
	        <td>${item.CSTMER}</td>
	        <td>${item.Name}</td>
	        <td>
	          <button class="btn btn-outline-secondary btn-sm" type="button" onclick="mdlReactivate('${item.QNumber}')">
	            Re-activate
	          </button>
	        </td>
	      </tr>
	    `);
	  });
	}

	/* --- Pagination Buttons --- */
	$("#btn-preview").on("click", function() {
	  if (currentPage > 1) loadQuotations(currentPage - 1);
	});

	$("#btn-next").on("click", function() {
	  loadQuotations(currentPage + 1);
	});

	  /*Script for search*/
	  $(document).ready(function () {
	    $('#search-quotation').on('input', function () {
	      const search = $(this).val().toLowerCase();
	      $('#display-quotation a.list-group-item').each(function () {
	        const status = $(this).find('[id="quote-status"]').text().toLowerCase(); // if you have a span for status
	        const rowText = $(this).text().toLowerCase();

	        if (status.includes(search) || rowText.includes(search)) {
	          $(this).show();
	        } else {
	          $(this).hide();
	        }
	      });
	    });
	  });

</script>

