$(document).ready(function(){
    loadBRanches();
});


function loadBRanches() {
    $.post("dirs/branch/components/main.php", {
    }, function (data){
        $("#load_branch").html(data);
    });
}


/*Function fetch data update branch*/
function updateDetails(Branch_id) {
    $("#mdl-updatebranch").modal("show");
    $.post("dirs/branch/actions/get_branchdetails.php",{
        Branch_id : Branch_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#upd-brancid").val(response.Data.Branch_id);
            $("#upd-branchcode").val(response.Data.BranchCode);
            $("#upd-branch").val(response.Data.Branch);
            $("#upd-area").val(response.Data.Area);
            $("#upd-address").val(response.Data.Address);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function delete branch*/
function mdldelBranch(Branch_id) {
    $("#mdl-delete-branch").modal("show");
    $.post("dirs/branch/actions/get_branchdetails.php",{
        Branch_id : Branch_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#del-branch").val(response.Data.Branch_id);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

function delBranch() {
    var Branch_id = $("#del-branch").val();
    $.post("dirs/branch/actions/delete_branch.php", {
        Branch_id : Branch_id
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-delete-branch").modal('hide');
            loadBRanches();
            console.log('delete branch');   
        }else{
            alert(data); 
        }
    });
}

function createBranch() {
   $("#mdl-create-branch").modal("show");
}

/*Function create branch*/
function saveCreateBRanch() {
    var Branch          = $("#create-branch").val();
    var Branchcode      = $("#create-branchcode").val();
    var Area            = $("#create-area").val();
    var Address         = $("#create-address").val();
    var Company         = $("#create-company").val();
    var Companycode = '';
        if (Company === 'Alphamin Commercial Corporation') {
            Companycode = 'ACC';
        }else if (Company === 'Nolu Marketing Corporation') {
            Companycode = 'NOLU';
        } else if (Company ==='Solu Trading Corporation') {
            Companycode = 'SOLU';
        } else if (Company ==='Vic Imperial Appliance Corporation'){
            Companycode = 'VIAC'
        }

    $.post("dirs/branch/actions/save_branch.php", {
        Branch : Branch,
        Branchcode : Branchcode,
        Area : Area,
        Address : Address,
        Company :Company,
        Companycode : Companycode,
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-create-branch").modal('hide');
            loadBRanches();
            console.log('new branch');   
        }else{
            alert(data); 
        }
    });
}


function update_branch() {
    var BranchID    = $("#upd-brancid").val();
    var BranchCode  = $("#upd-branchcode").val();
    var Branch      = $("#upd-branch").val();
    var Region      = $("#upd-area").val();
    var Address     = $("#upd-address").val();

    $.post("dirs/branch/actions/update_branch.php", {
        BranchID   : BranchID,
        BranchCode : BranchCode,
        Branch     : Branch,
        Region         : Region,
        Address      : Address,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            $("#mdl-updatebranch").modal('hide');
            loadBRanches(); 
            alert('Update successful');
        } else {
            alert(data);
        }
    });
}