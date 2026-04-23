$(document).ready(function(){
    loadAllQuoation();
});


function loadAllQuoation() {
    $.post("dirs/quotation_list/components/main.php", {
    }, function (data){
        $("#load_AllQuotations").html(data);
        loadIAPBranch();
        loadApprovedQuotation();
    });
}


/*Load Imperial branches*/
function loadIAPBranch() {
  $.post("dirs/quotation_list/actions/get_branch.php", {}, function (data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
      const branches = response.Data;
      $("#select-branch").html("<option selected>----</option>");
      branches.forEach((branch) => {
        $("#select-branch").append(
          $("<option>", {
            value: branch.Branch,
            text: branch.Branch,
          }),
        );
      });
    } else {
      alert($.trim(response.Data));
    }
  });
}


/*Function to review Quotation Content*/
function viewQuotation() {
  $("#mdl-review-quotation").modal('show');
}