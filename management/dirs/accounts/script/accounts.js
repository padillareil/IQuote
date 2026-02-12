$(document).ready(function(){
    loadAccounts();
});


function loadAccounts() {
    $.post("dirs/accounts/components/main.php", {
    }, function (data){
        $("#load_accounts").html(data);
        loadBranchdode();
    });
}




/*Function for next form*/
function loadForm2() {
    $('a[href="#payment"]').tab('show');
}

/*Function return form 1*/
function returnForm1() {
    $('a[href="#customer"]').tab('show');
}



function loadFilterModal() {
    $("#").modal("show");
}

/*load to Open Quotation*/
function loadOpenQuotation() {
    $.post("dirs/accounts/accounts.php", {
    }, function (data){
        $("#main-content").html(data);
    });
}



function loadmdlVerify() {
    $("#mdl-verify").modal("show")
}





/*Function create staff account*/
function createStaff() {
    var Fullname    = $("#staff-fullname").val();
    var Position    = $("#staff-position").val();
    var Username    = $("#staff-username").val();
    var Password    = $("#staff-password").val();
    var Branchcode  = $("#branch-code").val();
    var Branch      = $("#branch-assignment").val();

    // Submit via AJAX
    $.post("dirs/accounts/actions/save_staff.php", {
        Fullname: Fullname,
        Position: Position,
        Username: Username,
        Password: Password,
        Branchcode: Branchcode,
        Branch: Branch,
    }, function (data) {
        if ($.trim(data) === "OK") {
            console.log("Staff account created successfully.");
            $("#mdl-create-staff").modal("hide"); 
            loadOpenQuotation();
        } else {
            alert("Error: " + data);
        }
    });
}

/*function createStaff() {
    var Fullname    = $("#staff-fullname").val();
    var Position    = $("#staff-position").val();
    var Username    = $("#staff-username").val();
    var Password    = $("#staff-password").val();
    var Branchcode  = $("#branch-code").val();
    var Branch      = $("#select-branchassignment").val();
    $.post("dirs/accounts/actions/save_staff.php", {
        Fullname: Fullname,
        Position: Position,
        Username: Username,
        Password: Password,
        Branchcode :Branchcode,
        Branch: Branch,
    }, function (data) {
       if ($.trim(data) === "OK") {
           Swal.fire({
               icon: "success",
               title: "Staff Added",
               text: "Staff account created successfully.",
               timer: 2000,
               showConfirmButton: false
           });
           $("#mdl-create-staff").modal("hide"); 
           loadOpenQuotation();
       } else {
           Swal.fire({
               icon: "error",
               title: "Error",
               text: data
           });
       }
    });
}*/



/*Function update control Staff*/
function mdl_UserAccount(UserName){
    $("#mdl-update-account").modal("show");
    $.post("dirs/accounts/actions/get_userperformance.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#user-username").val(response.Data.UserName);
            $("#account-name").text(response.Data.Name);
            $("#number-pending").val(response.Data.Pending);
            $("#number-approved").val(response.Data.Approved);
            $("#number-rejected").val(response.Data.Rejected);
            $("#number-cancelled").val(response.Data.Cancelled);
            $("#number-onhold").val(response.Data.OnHold);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}




/*Function update account*/
function commitEnable(){
    var UserName    = $("#get-usernamestaff").val();
    var Status      = 'ENABLE';
    $.post("dirs/accounts/actions/update_enable.php", {
        UserName : UserName,
        Status     : Status,
    }, function(data){
        if($.trim(data) == "success"){
            $("#mdl-update-account").modal("hide");
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Staff access enabled.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            loadAccounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function update account*/
function disableuser(){
    var UserName            = $("#get-usernamestaff").val();
    $.post("dirs/accounts/actions/update_disable.php", {
        UserName    : UserName,
    }, function(data){
        if($.trim(data) == "success"){
            $("#mdl-update-account").modal("hide");
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Staff access blocked.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            loadAccounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function update account*/
function commitRemove() {
    $("#mdl-remove").modal("show");
}

function goRemove() {
    var UserName = $("#get-usernamestaff").val();
    var Status   = 'REMOVED';

    $.post("dirs/accounts/actions/update_removed.php", {
        UserName: UserName,
        Status: Status,
    }, function(data) {
        if ($.trim(data) == "success") {
            $("#mdl-update-account").modal("hide");
            $("#mdl-remove").modal("hide");
             Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Staff successfully removed.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            loadAccounts();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "Error: " + data
            });
        }
    });
}

function getUsername(UserName) {
    $.post("dirs/accounts/actions/get_username.php", {
        UserName: UserName
    }, function(data) {
        let response = JSON.parse(data);
        if (jQuery.trim(response.isSuccess) === "success") {
            $("#get-usernamestaff").val(response.Data.UserName);
        } else {
            alert(jQuery.trim(response.Data));
        }
    });
}
/*Function load all branches*/
function mdlStaff() {
    $("#mdl-create-staff").modal("show");
    $.post("dirs/accounts/actions/get_branchuser.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var branches = response.Data;
            var $branch = $("#branch-assignment");
            $branch.empty();
            $branch.append('<option selected disabled>Select Branch</option>');

            branches.forEach(function(branch) {
                $branch.append('<option value="' + $.trim(branch.BranchName) + '">' + branch.BranchName + '</option>');
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}

/*Funtion get the bcode of the user*/
function loadBranchdode(){
    $.post("dirs/accounts/actions/get_branchcode.php",{
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#branch-code").val(response.Data.Branchcode);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}