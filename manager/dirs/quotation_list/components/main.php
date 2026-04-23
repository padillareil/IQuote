<!-- Nav Pills -->
<ul class="nav nav-pills nav-fill justify-content-center d-none">
  <li class="nav-item">
    <a class="nav-link active" data-bs-toggle="tab" href="#inbox">Customer</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="tab" href="#edit">Edit</a>
  </li>
</ul>
<div class="mb-2 mt-2">
  <div class="card shadow-sm border-0 bg-light">
    <div class="card-body d-flex align-items-center">
      <div class="me-3">
        <img src="../assets/image/icon/logo.png" alt="iQuote Logo" style="width: 8vh; height: 8vh; border-radius: 8px;">
      </div>
      <div>
        <h4 class="mb-1 fw-bold text-danger">Verified Quotation</h4>
      </div>
    </div>
  </div>
</div>
<div class="card shadow-lg">
	<div class="card-header border-0 bg-white py-3 px-4">
	    <div class="row">
	    	<div class="col-md-10">
	          <input type="search" name="search-quotation" id="search-quotation" class="form-control py-2 col-md-12 shadow-none" placeholder="Search...">
	    	</div>
	    	<div class="col-md-2">
	    		<div class="input-group input-group-sm">
	    		    <select class="form-select py-2 shadow-none fw-semibold" id="select-branch">
	    		    </select>
	    		</div>
	    	</div>
	    </div>
	</div>
	
	<div class="card-body overflow-auto" style="height: 65vh;">
	    <ul class="list-unstyled p-3 m-0" id="display_approved_quotations">
	        <li class="d-flex justify-content-between align-items-center bg-white border rounded-3 p-4 mb-3 shadow-sm" onclick="viewQuotation()">
	            
	            <div class="d-flex align-items-start gap-3">
	                <div class="text-muted font-monospace pt-1" style="min-width: 30px;">
	                    1
	                </div>

	                <div class="d-flex flex-column gap-1">
	                    <div>
	                        <span class="fs-5 text-dark">Ref No: HO20260226-082</span>
	                    </div>
	                    
	                    <div class="fs-6">
	                        <span class="text-muted">Customer:</span>
	                        <span class="text-secondary fw-semibold">Global Tech Solutions</span>
	                        <div class="mt-1">
	                            <span class="badge bg-success">APPROVED</span>
	                        </div>
	                    </div>
	                </div>
	            </div>

	            <div class="text-end d-flex flex-column gap-1">
	                <div>
	                    <small class="text-uppercase text-muted" style="font-size: 0.75rem;">Grand Total</small>
	                    <div class="fs-4 text-darker">₱125,500.00</div>
	                </div>
	                
	                <div class="fs-6 text-muted">
	                    <p class="m-0" title="Approver">Reviewed by: <span class="fw-semibold text-dark">Alex Chen</span></p>
	                    <p class="m-0 small" title="Date Approved">April 20, 2026 
	                </div>
	            </div>

	        </li>
	    </ul>
	</div>



	<div class="card-footer">
	    <nav>
	        <ul class="pagination" id="pagination-in_activeuser">
	            <li class="page-item" id="li-prev-in_activeuser">
	                <a class="page-link" href="#" id="btn-preview-in_activeuser">Previous</a>
	            </li>
	            <li class="page-item" id="li-next-in_activeuser">
	                <a class="page-link" href="#" id="btn-next-in_activeuser">Next</a>
	            </li>
	        </ul>
	    </nav>
	    <div id="page-info-in_activeuser" class="mt-3 small text-muted"></div>
	</div>

</div>



<script>
	function formatDate(dateStr) {
	  if (!dateStr) return "";
	  const d = new Date(dateStr);
	  const month = String(d.getMonth() + 1).padStart(2, "0");
	  const day = String(d.getDate()).padStart(2, "0");
	  const year = d.getFullYear();
	  return `${month}/${day}/${year}`;
	}


	function formatComma(number) {
	  if (number == null) return "";
	  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}




	var CurrentPage = 1;
	var PageSize = 10;
	var totalPages = 1;
	var isPackageMode = false;
	var selectedItems = [];


	function loadApprovedQuotation(page = 1) {
	    CurrentPage = page; 
	    var display = $("#display_approved_quotations");
	    display.html(`
	            <tr>
	                <td colspan="6" class="p-5 text-center text-muted">
	                    <div class="spinner-border text-dark"></div>
	                    <div class="mt-2">Loading...</div>
	                </td>
	            </tr>
	    `);
	    var Search = $("#search-quotation").val();
	    var Branch = $("#select-branch").val();
	    $.post("dirs/quotation_list/actions/get_quotelist_pagination.php", {
	        CurrentPage,
	        PageSize,
	        Search,
	        Branch
	    }, function (data) {
	        let response;

	        try {
	            response = JSON.parse(data);
	        } catch (e) {
	            display.html(`<div class="text-dark text-center py-4">Server Error</div>`);
	            return;
	        }
	        if ($.trim(response.isSuccess) === "success") {
	            QuoteListContent(response.Data);
	            totalPages = (response.Data && response.Data.length > 0)
	                ? parseInt(response.Data[0].TotalPages)
	                : 1;

	                QuotePageNumber();
	                QuotePaginationUi();
	        } else {
	            emptyStateQuote("Quotation List was empty.");
	        }
	    });
	}


	function QuoteListContent(data) {
	    const display = $("#display_approved_quotations");
	    if (!data || data.length === 0) {
	        showEmptyStateQuote("No available.");
	        return;
	    }
	    display.empty();

	    data.forEach(bev => {
	        display.append(`
	           <li class="quotation-item d-flex justify-content-between align-items-center bg-white border rounded-3 p-4 mb-2 shadow-sm"
	               onclick="viewQuotation('${bev.QNumber}')">
	               <div class="d-flex align-items-start gap-3">
	                   <div class="text-muted font-monospace pt-1" style="min-width: 30px;">
	                       ${bev.OrderNumber}
	                   </div>

	                   <div class="d-flex flex-column gap-1">
	                       <div>
	                           <span class="fs-5 text-dark">Ref No: ${bev.QNumber}</span>
	                       </div>
	                       
	                       <div class="fs-6">
	                           <span class="text-muted">Customer:</span>
	                           <span class="text-secondary fw-semibold">${bev.Customer}</span>
	                           <div class="mt-1">
	                               <span class="badge bg-success">${bev.QSTATUS}</span>
	                           </div>
	                       </div>
	                   </div>
	               </div>

	               <div class="text-end d-flex flex-column gap-1">
	                   <div>
	                       <h5 class="text-muted" style="font-size: 0.75rem;">Grand Total</h5>
	                       <div class="fs-4 text-darker">₱${formatComma(bev.GrandTotal)}</div>
	                   </div>
	                   
	                   <div class="fs-6 text-muted">
	                       <p class="m-0" title="Approver">Reviewed by: <span class="fw-semibold text-dark">${bev.Approver}</span></p>
	                       <p class="m-0 small" title="Date Approved">${formatDate(bev.ApprovedDate)}
	                   </div>
	               </div>

	           </li>
	        `);
	    });
	}

	/*Function for no record of beverages*/
	function emptyStateQuote(message) {
	    $("#display_approved_quotations").html(`
	        <li class="d-flex flex-column justify-content-center align-items-center bg-white border rounded-3 p-5 mb-3 shadow-sm text-center">
            	<i class="bi bi-card-list fs-1 text-muted mb-3"></i>
            	<div class="fs-5 text-dark">No Quotation Available</div>
            	<div class="small text-muted mt-1">${message}</div>
        	</li>
	    `);
	}

	/*Function for no record of beverages*/
	function showEmptyStateQuote(message) {
	    $("#display_approved_quotations").html(`
	        <li class="d-flex flex-column justify-content-center align-items-center bg-white border rounded-3 p-5 mb-3 shadow-sm text-center">
	            <i class="bi bi-search fs-1 text-muted mb-3"></i>
	            <div class="fs-5 text-dark">No Record Found</div>
	            <div class="small text-muted mt-1">${message}</div>

        	</li>
	    `);
	}


	/*Function to count page number page 1 of and so on*/
	function QuotePaginationUi() {
	    $("#page-info-in_activeuser").text("Page " + CurrentPage + " of " + totalPages);
	    if (CurrentPage <= 1) {
	        $("#li-prev-in_activeuser").addClass("disabled");
	    } else {
	        $("#li-prev-in_activeuser").removeClass("disabled");
	    }

	    if (CurrentPage >= totalPages) {
	        $("#li-next-in_activeuser").addClass("disabled");
	    } else {
	        $("#li-next-in_activeuser").removeClass("disabled");
	    }
	}


	/*Function to build list of pagination*/
	function QuotePageNumber() {
	    $("#pagination-in_activeuser li.page-number-in_activeuser").remove();
	    let prevLi = $("#li-prev-in_activeuser");
	    let maxVisible = 5;
	    let start = Math.max(1, CurrentPage - 2);
	    let end = Math.min(totalPages, start + maxVisible - 1);
	    if (end - start < maxVisible - 1) {
	        start = Math.max(1, end - maxVisible + 1);
	    }
	    if (start > 1) {
	        insertPageBreakfast(1, prevLi);
	        prevLi = prevLi.next();

	        if (start > 2) {
	            prevLi.after(`<li class="page-item page-number-in_activeuser disabled"><span class="page-link">...</span></li>`);
	            prevLi = prevLi.next();
	        }
	    }
	    for (let i = start; i <= end; i++) {
	        insertPageBreakfast(i, prevLi);
	        prevLi = prevLi.next();
	    }
	    if (end < totalPages) {
	        if (end < totalPages - 1) {
	            prevLi.after(`<li class="page-item page-number-in_activeuser disabled"><span class="page-link">...</span></li>`);
	            prevLi = prevLi.next();
	        }
	        insertPageBreakfast(totalPages, prevLi);
	    }
	    function insertPageBreakfast(i, ref) {
	        let activeClass = (i === CurrentPage) ? "active" : "";

	        let li = `
	            <li class="page-item page-number-in_activeuser ${activeClass}">
	                <a class="page-link" href="#" data-page="${i}">${i}</a>
	            </li>
	        `;

	        $(li).insertAfter(ref);
	    }
	}

	/*inclusionlist*/
	$("#search-quotation").on("keydown", function(e) {
	    if (e.key === "Enter") {
	        loadApprovedQuotation();
	    }
	});

	  /* Pagination + Fetch Blocked Accounts */
	  $("#btn-preview-in_activeuser").on("click", function(e) {
	      e.preventDefault();

	      if (CurrentPage > 1) {
	          loadApprovedQuotation(CurrentPage - 1);
	      }
	  });

	/*Function load all important tags tickets*/
	  $("#btn-next-in_activeuser").on("click", function(e) {
	      e.preventDefault();

	      if (CurrentPage < totalPages) {
	          loadApprovedQuotation(CurrentPage + 1);
	      }
	  });

	  $("#select-branch").on("change", function() {
	      CurrentPage = 1;
	      const branch = $(this).val();
	      loadApprovedQuotation(CurrentPage, branch);
	  });


	  $(document).on("click", "#pagination-in_activeuser .page-link", function(e) {
	      e.preventDefault();
	      var page = $(this).data("page");
	      if (page && page !== CurrentPage) {
	          loadApprovedQuotation(page);
	      }
	  });
</script>


<style>
	.quotation-item {
	    cursor: pointer;
	    transition: all 0.2s ease;
	}

	.quotation-item:hover {
	    transform: translateY(-2px);
	    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
	    background-color: #f8f9fa; /* subtle light hover */
	}

	.quotation-item:active {
	    transform: scale(0.98);
	}
</style>