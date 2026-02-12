$(document).ready(function(){
    loadAccounts();
    
});


function loadAccounts() {
    $.post("dirs/accounts/components/main.php", {
    }, function (data){
        $("#load_accounts").html(data);
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

function mdlStaff(){
    $("#mdl-create-staff").modal("show");
    $.post("dirs/accounts/actions/get_userbranch.php",{
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            if (response.Data.Branch !== 'ONLINE' || response.Data.Branch === 'REM') {
                $("#select-branchassignment").addClass("d-none");
            }
            $("#staff-branch").val(response.Data.Branch);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}



/*Function create staff account*/
function createStaff() {
    var Fullname    = $("#staff-fullname").val();
    var Position    = $("#staff-position").val();
    var Username    = $("#staff-username").val();
    var Password    = $("#staff-password").val();
    var Branch      = $("#select-branchassignment").val();
    // Submit via AJAX
    $.post("dirs/accounts/actions/save_staff.php", {
        Fullname: Fullname,
        Position: Position,
        Username: Username,
        Password: Password,
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
}


/*Function update control Staff*/
function mdl_UserAccount(UserName){
    $("#mdl-update-account").modal("show");
    $.post("dirs/accounts/actions/get_useraccount.php",{
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
/*Function access control user*/
function mdlenable() {
    $("#mdl-access-user").modal("show");
    $("#mdl-update-account").modal('hide');
}


/*Function remove user*/
function mdlRemove() {
    $("#mdl-remove-user").modal("show");
    $("#mdl-update-account").modal('hide');
}

/*Function disable user*/
function mdlDisable() {
    $("#mdl-disable-user").modal("show");
    $("#mdl-update-account").modal('hide');
}



/*Function update account*/
function commitEnable(){
    var UserName    = $("#get-username").val();
    var Status      = 'ENABLE';
    $.post("dirs/accounts/actions/update_enable.php", {
        UserName : UserName,
        Status     : Status,
    }, function(data){
        if($.trim(data) == "success"){
            $("#mdl-access-user").modal("hide");
            loadAccounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function update account*/
function commitDisable(){
    var UserName            = $("#get-username").val();
    var Status              = 'DISABLED';
    var AccountReason       = $("#disable-reason");
    $.post("dirs/accounts/actions/update_disable.php", {
        UserName : UserName,
        Status     : Status,
        AccountReason :AccountReason,
    }, function(data){
        if($.trim(data) == "success"){
            $("#mdl-disable-user").modal("hide");
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
    var UserName = $("#get-username").val();
    var Status   = 'REMOVED';

    $.post("dirs/accounts/actions/update_removed.php", {
        UserName: UserName,
        Status: Status,
    }, function(data) {
        if ($.trim(data) == "success") {
            $("#mdl-update-account").modal("hide");
            $("#mdl-remove").modal("hide");
            Swal.fire({
                icon: 'success',
                title: 'Account Removed',
                text: 'Account has been successfully removed.',
                timer: 2000,
                showConfirmButton: false
            });

            loadAllocate();
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
            $("#get-username").val(response.Data.UserName);
        } else {
            alert(jQuery.trim(response.Data));
        }
    });
}
