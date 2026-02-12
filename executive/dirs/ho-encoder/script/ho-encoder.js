$(document).ready(function(){
    load_CNCManager();
});



function load_CNCManager() {
    $.post("dirs/ho-encoder/components/main.php", {
    }, function (data){
        $("#load_HO_Encoder").html(data);
    });
}

function mdlStaffHo() {
    $("#mdl-create-hostaff").modal("show");
}

/*Funtion get the bcode of the user*/
/*function loadBranchdode(){
    $.post("dirs/accounts/actions/get_branchcode.php",{
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#branch-code").val(response.Data.Branchcode);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}*/

function createHeadOfficeStaff() {
    var Fullname    = $("#ho-fullname").val();
    var Position    = $("#ho-position").val();
    var Username    = $("#ho-username").val();
    var Password    = $("#ho-password").val();
    var Branchcode  = 'HO';
    var Branch      = 'ICBU';

    // Submit via AJAX
    $.post("dirs/ho-encoder/actions/save_staff.php", {
        Fullname: Fullname,
        Position: Position,
        Username: Username,
        Password: Password,
        Branchcode: Branchcode,
        Branch: Branch,
    }, function (data) {
        if ($.trim(data) === "OK") {
           /* console.log("Staff head office created successfully.");*/
            $("#mdl-create-hostaff").modal("hide"); 
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Head Office Staff successfully created.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            load_CNCManager();
        } else {
            alert("Error: " + data);
        }
    });
}



function mdl_UserAccount(UserName){
    $("#mdl-update-accountho").modal("show");
    $.post("dirs/ho-encoder/actions/get_userperformance.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#user-usernameho").val(response.Data.UserName);
            $("#account-nameho").text(response.Data.Name);
            $("#number-pendingho").val(response.Data.Pending);
            $("#number-approvedho").val(response.Data.Approved);
            $("#number-rejectedho").val(response.Data.Rejected);
            $("#number-cancelledho").val(response.Data.Cancelled);
            $("#number-onholdho").val(response.Data.OnHold);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}




/*Function update account*/
function commitEnableHO(){
    var UserName    = $("#get-username").val();
    var Status      = 'ENABLE';
    $.post("dirs/ho-encoder/actions/update_enable.php", {
        UserName : UserName,
        Status     : Status,
    }, function(data){
        if($.trim(data) == "success"){
            $("#mdl-update-accountho").modal("hide");
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Head Office Staff access enabled.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            load_CNCManager();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function update account*/
function disableuserHO(){
    var UserName            = $("#get-username").val();
    $.post("dirs/ho-encoder/actions/update_disable.php", {
        UserName    : UserName,
    }, function(data){
        if($.trim(data) == "success"){
            $("#mdl-update-accountho").modal("hide");
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Head Office Staff access blocked.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            load_CNCManager();
        }else{
            alert("Error: " + data);
        }
    });
}


/*Function update account*/
function commitRemoveHO() {
    $("#mdl-remove").modal("show");
}

function goRemove() {
    var UserName = $("#get-username").val();
    var Status   = 'REMOVED';

    $.post("dirs/ho-encoder/actions/update_removed.php", {
        UserName: UserName,
        Status: Status,
    }, function(data) {
        if ($.trim(data) == "success") {
            $("#mdl-update-accountho").modal("hide");
            $("#mdl-remove").modal("hide");
            Swal.fire({
                icon: 'success',
                title: 'Account Removed',
                text: 'Account has been successfully removed.',
                timer: 2000,
                showConfirmButton: false
            });

            load_CNCManager();
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
    $.post("dirs/ho-encoder/actions/get_username.php", {
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