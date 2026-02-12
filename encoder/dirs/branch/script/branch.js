$(document).ready(function(){
    loadIAPBranches();
});



function loadIAPBranches() {
    $.post("dirs/branch/components/main.php", {
    }, function (data){
        $("#load_IAP_branch").html(data);
        loadImperialBranch();
    });
}


function mdladdBranch() {
    $("#mdl-add-branch").modal('show');
}



var CurrentPage = 1;
var PageSize = 100;
var display = $("#branches-table");
function loadImperialBranch(page = 1, status = null) {
    var Search = $("#search-branch").val();
    $.post("dirs/branch/actions/get_branches.php", {
        CurrentPage: page,
        PageSize: PageSize,
        Search : Search,
    }, function(data) {
        let response;
        try {
            response = JSON.parse(data);
        } catch (e) {
            toastr.error("Server error.", "Error");
            return;
        }

        if ($.trim(response.isSuccess) === "success") {
            displayBranches(response.Data);
            CurrentPage = page;
        } else {
            toastr.error($.trim(response.Data), "Error");
        }
    });
}
function displayBranches(data) {
    const display = $("#branches-table");
    display.empty();

    if (!data || data.length === 0) {
        display.html(`
            <tr>
                <td colspan="7" class="text-center text-muted py-3">
                    <i class="bi bi-file-earmark-text text-lg"></i><br>
                    No Record Found.
                </td>
            </tr>
        `);
        return;
    }

    data.forEach(brnch => {
        display.append(`
            <tr>
                <td>${brnch.BranchCode}</td>
                <td>${brnch.Branch}</td>
                <td>${brnch.Address}</td>
                <td>${brnch.Area}</td>
                <td>${brnch.CompanyCode}</td>
                <td>${brnch.Company}</td>
                <td class="t-action col-2">
                    <button class="btn btn-outline-primary" type="button" title="Edit Branch" onclick="mdlEdit('${brnch.Branch_id}')">Edit</button>
                    <button class="btn btn-outline-danger" type="button" title="Delete Branch" onclick="mdlDel('${brnch.Branch_id}')">Remove</button>
                </td>
            </tr>
        `);
    });
}


/* Pagination + Fetch Blocked Accounts */
$("#btn-preview").on("click", function() {
    if (CurrentPage > 1) {
        loadImperialBranch(CurrentPage - 1);
    } else {
        console.log("You're already on the first page.");
    }
});


$("#btn-next").on("click", function() {
    loadImperialBranch(CurrentPage + 1);
});


/*Function prompt before delete*/
function mdlDel(Branch_id){
    $("#mdl-remove-branch").modal("show");
    $.post("dirs/branch/actions/get_branchid.php",{
        Branch_id : Branch_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#branch-id").val(response.Data.Branch_id);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function remove branch*/
function removeBranch(){
    var Branchid = $("#branch-id").val();
    $.post("dirs/branch/actions/delete_branch.php", {
        Branchid : Branchid
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#modal-add-student").modal('hide');
            mdladdBranch();
            $("#mdl-edit-branch").modal("hide");
            Swal.fire({
                icon: 'success',
                title: 'New Branch Added',
                text: 'Success.',
                timer: 3000,
                showConfirmButton: false
            });   
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data
            });
        }
    });
}


/*Function prompt before edit*/
function mdlEdit(Branch_id){
    $("#mdl-edit-branch").modal("show");
    $.post("dirs/branch/actions/get_branchid.php",{
        Branch_id : Branch_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#branch-id").val(response.Data.Branch_id);
            $("#edit-branch-coder").val(response.Data.BranchCode);
            $("#edit-branch").val(response.Data.Branch);
            $("#edit-address").val(response.Data.Address);
            $("#edit-area").val(response.Data.Area);
            $("#edit-company-corpo").val(response.Data.Company);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function remove branch*/
function removeBranch(){
    var Branchid = $("#branch-id").val();
    $.post("dirs/branch/actions/delete_branch.php", {
        Branchid : Branchid
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-remove-branch").modal("hide");
            loadIAPBranches();
            Swal.fire({
                icon: 'success',
                title: 'New Branch Added',
                text: 'Success.',
                timer: 3000,
                showConfirmButton: false
            });   
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data
            });
        }
    });
}
