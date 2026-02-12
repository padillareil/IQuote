$(document).ready(function(){
    loadIAPBanks();
});



function loadIAPBanks() {
    $.post("dirs/bank_accounts/components/main.php", {
    }, function (data){
        $("#load_bank_accounts").html(data);
        loadBranchBanks();
        loadCorporate();
        loadHeadOfficeBanks();
    });
}




/******************************BANK ACCOUNT BRANCHES*********************************************************/

/*function add Branch Bank Account*/
function addHOBranch() {
    $("#mld-branch-bank").modal('show');
    $.post("dirs/bank_accounts/actions/get_branches.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var branches = response.Data;
            var $branch = $("#create-branch");
            $branch.empty();
            $branch.append('<option selected disabled>Select Branch</option>');

            branches.forEach(function(branch) {
                $branch.append('<option value="' + $.trim(branch.Branch) + '">' + branch.Branch + '</option>');
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}

$("#create-branch").on("change", function() {
    getCorpo(); // call the function
});

/*Function get corporation base on the branch*/
function getCorpo(){
    var Branch = $("#create-branch").val();
    $.post("dirs/bank_accounts/actions/get_corporation.php",{
        Branch : Branch
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#create-corpotype").val(response.Data.Company);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function to get all branch bank accounts*/
var CurrentPage = 1;
var PageSize = 100;
var display = $("#ho-branch-table");
function loadBranchBanks(page = 1, status = null) {
    var Search = $("#search-branch-bank").val();
    var BnkType =  'BRNCH';
    $.post("dirs/bank_accounts/actions/get_branch_banks.php", {
        CurrentPage: page,
        PageSize: PageSize,
        Search : Search,
        BnkType : BnkType,
    }, function(data) {
        let response;
        try {
            response = JSON.parse(data);
        } catch (e) {
            toastr.error("Server error.", "Error");
            return;
        }

        if ($.trim(response.isSuccess) === "success") {
            displayBnkBranch(response.Data);
            CurrentPage = page;
        } else {
            toastr.error($.trim(response.Data), "Error");
        }
    });
}
function displayBnkBranch(data) {
    const display = $("#ho-branch-table");
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
                <td>${brnch.Branch}</td>
                <td>${brnch.Bank}</td>
                <td>${brnch.AccName}</td>
                <td>${brnch.AccNumber}</td>
                <td class="t-action col-2">
                    <button class="btn btn-outline-primary" type="button" title="Edit Branch" onclick="mdlEdit('${brnch.Bnkid}')">Edit</button>
                    <button class="btn btn-outline-danger" type="button" title="Delete Branch" onclick="mdlDel('${brnch.Bnkid}')">Remove</button>
                </td>
            </tr>
        `);
    });
}


/*Function edit branch bank account*/
function mdlEdit(Bnkid) {
    $("#mld-editbranch-bank").modal('show');
    var BnkOwnership = 'BRNCH';
    $.post("dirs/bank_accounts/actions/get_bnkinfo.php",{
        Bnkid : Bnkid,
        BnkOwnership : BnkOwnership
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#bank-id-edit").val(response.Data.Bnkid);
            $("#create-editbank").val(response.Data.Bank);
            $("#create-editaccountname").val(response.Data.AccName);
            $("#create-editaccountnumber").val(response.Data.AccNumber);
            $("#create-editcorpotype").val(response.Data.Corpo);
            $("#create-editbranch").val(response.Data.Branch);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function to prompt before delete*/
function mdlDel(Bnkid) {
    $("#mdl-remove-bank").modal('show');
    var BnkOwnership = 'BRNCH';
    $.post("dirs/bank_accounts/actions/get_bnkinfo.php",{
        Bnkid : Bnkid,
        BnkOwnership : BnkOwnership
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#bank-id-edit").val(response.Data.Bnkid);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


function removeBank(){
    var Bnkid = $("#bank-id-edit").val();
    $.post("dirs/bank_accounts/actions/delete_bank.php", {
        Bnkid : Bnkid
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-remove-bank").modal('hide');
            loadIAPBanks();
            Swal.fire({
                icon: 'success',
                title: 'Successfully removed.',
                text: 'Success.',
                timer: 3000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data
            });
        }
    });
}

/******************************BANK ACCOUNT BRANCHES*********************************************************/

/******************************BANK ACCOUNT COPORATE*********************************************************/
/*Function to get all branch bank accounts*/
var CurrentPage = 1;
var PageSize = 100;
var display = $("#corp-bank-table");
function loadCorporate(page = 1, status = null) {
    var Search = $("#search-corp-bank").val();
    $.post("dirs/bank_accounts/actions/get_corporate_banks.php", {
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
            displayCorporate(response.Data);
            CurrentPage = page;
        } else {
            toastr.error($.trim(response.Data), "Error");
        }
    });
}
function displayCorporate(data) {
    const display = $("#corp-bank-table");
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

    data.forEach(corpo => {
        display.append(`
            <tr>
                <td>${corpo.Bank}</td>
                <td>${corpo.AccName}</td>
                <td>${corpo.AccNumber}</td>
                <td class="t-action col-2">
                    <button class="btn btn-outline-primary" type="button" title="Edit Branch" onclick="mdlEditcorp('${corpo.Bnkid}')">Edit</button>
                    <button class="btn btn-outline-danger" type="button" title="Delete Branch" onclick="mdlDelCorpo('${corpo.Bnkid}')">Remove</button>
                </td>
            </tr>
        `);
    });
}

function addCorpBranch() {
    $('#mdl-add-corpbank').modal('show');
}


function mdlDelCorpo(Bnkid) {
    $("#mdl-remove-bank").modal('show');
    $.post("dirs/bank_accounts/actions/get_bnkdetails.php",{
        Bnkid : Bnkid,
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#bank-id-edit").val(response.Data.Bnkid);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function edit branch bank account*/
function mdlEditcorp(Bnkid) {
    $("#mdl-edit-corpo").modal('show');
    $.post("dirs/bank_accounts/actions/get_bnkdetails.php",{
        Bnkid : Bnkid
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#bank-id-edit").val(response.Data.Bnkid);
            $("#edit-bnkcorpo").val(response.Data.Bank);
            $("#edit-corpoacc").val(response.Data.AccName);
            $("#edit-corpoaccnum").val(response.Data.AccNumber);
            $("#edit-corporate").val(response.Data.Corpo);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}
/******************************BANK ACCOUNT COPORATE*********************************************************/



/******************************BANK ACCOUNT TRANSFER*********************************************************/

function addtransferBank() {
    $("#mdl-add-transfer").modal('show');
}





/*Function to get all branch bank accounts*/
var CurrentPage = 1;
var PageSize = 100;
var display = $("#transfer-bank-table");
function loadHeadOfficeBanks(page = 1, status = null) {
    var Search = $("#search-transfer-bank").val();
    var BnkType =  'Personal';
    $.post("dirs/bank_accounts/actions/get_branch_banks.php", {
        CurrentPage: page,
        PageSize: PageSize,
        Search : Search,
        BnkType : BnkType,
    }, function(data) {
        let response;
        try {
            response = JSON.parse(data);
        } catch (e) {
            toastr.error("Server error.", "Error");
            return;
        }

        if ($.trim(response.isSuccess) === "success") {
            displayHOBnks(response.Data);
            CurrentPage = page;
        } else {
            toastr.error($.trim(response.Data), "Error");
        }
    });
}
function displayHOBnks(data) {
    const display = $("#transfer-bank-table");
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

    data.forEach(corpo => {
        display.append(`
            <tr>
                <td>${corpo.Bank}</td>
                <td>${corpo.AccName}</td>
                <td>${corpo.AccNumber}</td>
                <td class="t-action col-2">
                    <button class="btn btn-outline-primary" type="button" title="Edit Branch" onclick="mdlEditPersonal('${corpo.Bnkid}')">Edit</button>
                    <button class="btn btn-outline-danger" type="button" title="Delete Branch" onclick="mdlDElPersonal('${corpo.Bnkid}')">Remove</button>
                </td>
            </tr>
        `);
    });
}


function mdlDElPersonal(Bnkid) {
    $("#mdl-remove-bank").modal('show');
    var BnkOwnership = 'Personal';
    $.post("dirs/bank_accounts/actions/get_bnkinfo.php",{
        Bnkid : Bnkid,
        BnkOwnership : BnkOwnership
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#bank-id-edit").val(response.Data.Bnkid);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function edit branch bank account*/
function mdlEditPersonal(Bnkid) {
    $("#mdl-edit-transfer").modal('show');
    var BnkOwnership = 'Personal';
    $.post("dirs/bank_accounts/actions/get_bnkinfo.php",{
        Bnkid : Bnkid,
        BnkOwnership : BnkOwnership
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#bank-id-edit").val(response.Data.Bnkid);
            $("#edit-trabank").val(response.Data.Bank);
            $("#edit-traaccountname").val(response.Data.AccName);
            $("#edit-traaccountnumber").val(response.Data.AccNumber);
            $("#edit-tracorpotype").val(response.Data.Corpo);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}
/******************************BANK ACCOUNT TRANSFER*********************************************************/