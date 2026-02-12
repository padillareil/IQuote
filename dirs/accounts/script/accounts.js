$(document).ready(function(){
    load_Accounts();
    loadAllBranch();
});



function load_Accounts() {
    $.post("dirs/accounts/components/main.php", {
    }, function (data){
        $("#load_accounts").html(data);
    });
}


/*Function show modal for create account headoffice*/
function mdl_createho(argument) {
    $("#mdl_createho").modal("show");
}

/*Function create account*/
function saveAccountHO(){
    var Bcode       = $("#ho-code").val();
    var Name        = $("#ho-name").val();
    var UPosition   = $("#ho-position").val();
    var Landline    = $("#ho-landline").val();
    var Mobile      = $("#ho-mobile").val();
    var Username    = $("#ho-username").val();
    var Password    = $("#ho-password").val();
    let Role = '';
        if (Bcode === 'HO') {
            Role = 'HA';
        } else if (Bcode === 'ONLN') {
            Role = 'ONLN';
        } else if (Bcode === 'ICBU') {
            Role = 'ICBU';
        }

    $.post("dirs/accounts/actions/save_account.php", {
        Bcode       : Bcode,
        Name        : Name,
        UPosition   : UPosition,
        Landline    : Landline,
        Mobile      : Mobile,
        Username    : Username,
        Password    : Password,
        Role        : Role,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Account added.");
            $("#mdl_createho").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function Modals*/


function mdlRecovery(UserName) {
    $("#mdl-account-recovery").modal("show");
    $.post("dirs/accounts/actions/get_username.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#upd-name").val(response.Data.Name);
            $("#upd-username").val(response.Data.UserName);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

function mdlUpload(UserName) {
    $("#mdl-upload-signature").modal("show");
    $.post("dirs/accounts/actions/get_username.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#sig-username").val(response.Data.UserName);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

function mdlUpdate(UserName) {
    $("#mdl-upd-details").modal("show");
    $.post("dirs/accounts/actions/get_username.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#ua-username").val(response.Data.UserName);
            $("#ua-fullname").val(response.Data.Name);
            $("#ua-position").val(response.Data.UPosition);
            $("#ua-landline").val(response.Data.Landline);
             $("#ua-mobile").val(response.Data.Mobile);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

function mdlEnable(UserName) {
    $("#mdl-enable").modal("show");
    $.post("dirs/accounts/actions/get_username.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#en-username").val(response.Data.UserName);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

function mdlBlock(UserName) {
    $("#mdl-block").modal("show");
    $.post("dirs/accounts/actions/get_username.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#blk-username").val(response.Data.UserName);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

function mdlDelete(UserName) {
    $("#mdl-delete").modal("show");
    $.post("dirs/accounts/actions/get_username.php",{
        UserName : UserName
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#del-username").val(response.Data.UserName);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function save update password*/
function saveAccRecovery() {
    var Username        = $("#upd-username").val();
    var Newpassword     = $("#upd-newpassword").val();

    $.post("dirs/accounts/actions/update_newpassword.php", {
        Username        : Username,
        Newpassword     : Newpassword,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Password changes.");
            $("#mdl-account-recovery").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}


/*Function Upload Signature*/
function updateSignature() {
    var Username = $("#sig-username").val();
    var fileInput = $("#upload-signature")[0];
    var file = fileInput.files[0];

    if (!file) {
        alert("Please select a file to upload.");
        return;
    }

    var formData = new FormData();
    formData.append("upload-signature", file);   // must match PHP
    formData.append("UserName", Username);

    $.ajax({
        url: "dirs/accounts/actions/update_signature.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if ($.trim(data) === "OK") {
                alert("Signature uploaded.");
                $("#mdl-upload-signature").modal("hide");
                load_Accounts();
            } else {
                alert("Error: " + data);
            }
        },
        error: function(xhr, status, error) {
            alert("Upload failed: " + error);
        }
    });
}



/*Function save update user deatils*/
function updateAccount() {
    var Username        = $("#ua-username").val();
    var Fullname        = $("#ua-fullname").val();
    var Position        = $("#ua-position").val();
    var Landline        = $("#ua-landline").val();
    var Mobile          = $("#ua-mobile").val();

    $.post("dirs/accounts/actions/update_userdetails.php", {
        Username        : Username,
        Fullname     : Fullname,
        Position     : Position,
        Landline        : Landline,
        Mobile     : Mobile,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("User details changes.");
            $("#mdl-upd-details").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function enable user*/
function enableUser() {
    var Username        = $("#en-username").val();
    var AccountStatus   = 'ENABLE';

    $.post("dirs/accounts/actions/update_access.php", {
        Username        : Username,
        AccountStatus     : AccountStatus,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("enable changes.");
            $("#mdl-enable").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function disable user*/
function disableUser() {
    var Username        = $("#blk-username").val();
    var AccountStatus   = 'DISABLED';
    $.post("dirs/accounts/actions/update_access.php", {
        Username        : Username,
        AccountStatus     : AccountStatus,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("block changes.");
            $("#mdl-block").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function update and delete user*/
function deleteuser() {
    var Username        = $("#del-username").val();
    $.post("dirs/accounts/actions/update_removeuser.php", {
        Username        : Username,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("delete changes.");
            $("#mdl-delete").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}




/*Create Account admin*/
function createAdmin() {
    $("#mdl-create-admin").modal("show");
}

/*Function save admin*/
function saveAdmin() {
    var Fullname        = $("#admin-name").val();
    var Username        = $("#admin-username").val();
    var Password        = $("#admin-password").val();
    var Position        = 'SA';
    $.post("dirs/accounts/actions/save_admin.php", {
        Fullname        : Fullname,
        Username        : Username,
        Password     : Password,
        Position     : Position,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Admin Created.");
            $("#mdl-create-admin").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}


function createRM() {
    $("#mdl-create-regionalmanager").modal("show");
    loadregions();
}


function loadregions() {
    $.post("dirs/accounts/actions/get_regions.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var branches = response.Data;
            var $Region = $("#regional-region");
            $Region.empty();
            $Region.append('<option selected disabled>Select Region</option>');

            branches.forEach(function(branch) {
                $Region.append('<option value="' + $.trim(branch.Region) + '">' + branch.Region + '</option>');
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}


/*Function save regional manager*/
function saveRegionalmanager() {
    var Fullname        = $("#regional-name").val();
    var UPosition        = $("#regional-position").val();
    var Region          = $("#regional-region").val();
    var Landline        = $("#regional-landline").val();
    var Mobile          = $("#regional-mobile").val();
    var Username        = $("#regional-username").val();
    var Password        = $("#regional-password").val();
    var Position        = 'Regional Manager';
    $.post("dirs/accounts/actions/save_regionalm.php", {
        Fullname        : Fullname,
        UPosition       : UPosition,
        Region          : Region,
        Landline        : Landline,
        Mobile          : Mobile,
        Username        : Username,
        Password        : Password,
        Position        : Position,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Admin Created.");
            $("#mdl-create-regionalmanager").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Create Director Account*/
function createDirector() {
    $("#mdl-create-director").modal("show");
}

function saveDirector() {
    var Fullname        = $("#director-name").val();
    var UPosition       = $("#director-position").val();
    var Landline        = $("#director-landline").val();
    var Mobile          = $("#director-mobile").val();
    var Username        = $("#director-username").val();
    var Password        = $("#director-password").val();
    var Position        = 'Director';
    $.post("dirs/accounts/actions/save_director.php", {
        Fullname        : Fullname,
        UPosition       : UPosition,
        Landline        : Landline,
        Mobile          : Mobile,
        Username        : Username,
        Password        : Password,
        Position        : Position,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Director Created.");
            $("#mdl-create-director").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Branch manager*/
function createBRanch() {
    $("#mdl-create-banchmanager").modal("show");
}



function loadAllBranch() {
    $.post("dirs/accounts/actions/get_branchuser.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var branches = response.Data;
            var $branch = $("#branch-asigned");
            $branch.empty();
            $branch.append('<option selected disabled>Select Branch</option>');

            branches.forEach(function(branch) {
                $branch.append('<option value="' + $.trim(branch.BranchName) + '">' + branch.BranchName + '</option>');
            });

            $branch.off("change").on("change", function() {
                var selectedBranch = $(this).val();
                if (selectedBranch) {
                    loadBranchcode(selectedBranch);
                }
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}

function loadBranchcode(BranchName) {
    $.post("dirs/accounts/actions/get_branchcode.php", {
        Branch: BranchName
    }, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            $("#branch-code").val(response.Data.BranchCode);
        } else {
            alert($.trim(response.Data));
        }
    });
}


/*Function create branch account*/
function saveBranchaccount() {
    var Bcode           = $("#branch-code").val();
    var Fullname        = $("#branch-name").val();
    var UPosition       = $("#branch-position").val();
    var Branch          = $("#branch-asigned").val();
    var Username        = $("#branch-username").val();
    var Password        = $("#branch-password").val();
    var Position        = 'BA';
    $.post("dirs/accounts/actions/save_branchmanager.php", {
        Bcode           : Bcode,
        Fullname        : Fullname,
        UPosition       : UPosition,
        Branch          : Branch,
        Username        : Username,
        Password        : Password,
        Position        : Position,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Branch Manager Created.");
            $("#mdl-create-banchmanager").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}


/*System Audit*/
function createAudit() {
    $("#mdl-create-audit").modal("show");
}


/*Function create branch systems audit*/
function saveAudit() {
    var Fullname        = $("#audit-fullname").val();
    var UPosition       = $("#audit-position").val();
    var Username        = $("#audit-username").val();
    var Password        = $("#audit-password").val();
    var Position        = 'Audit';
    $.post("dirs/accounts/actions/save_audit.php", {
        Fullname     : Fullname,
        UPosition    : UPosition,
        Username     : Username,
        Password     : Password,
        Position     : Position,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("System Audit Created.");
            $("#mdl-create-audit").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}


/*System Audit*/
function mdlCoordinator() {
    $("#mdl-create-coordinator").modal("show");
}


/*Function create branch systems cordinator*/
function saveCoordinator() {
    var Fullname        = $("#cordinator-fullname").val();
    var UPosition       = $("#cordinator-position").val();
    var Username        = $("#cordinator-username").val();
    var Password        = $("#cordinator-password").val();
    var Position        = 'Coordinator';
    $.post("dirs/accounts/actions/save_audit.php", {
        Fullname     : Fullname,
        UPosition    : UPosition,
        Username     : Username,
        Password     : Password,
        Position     : Position,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("System Coordinator Created.");
            $("#mdl-create-coordinator").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Function to add encoder Account*/
function mdlEncoder() {
    $("#mdl-add-encoder").modal('show');
}

$("#frm-add-encoder").submit(function(event){
    event.preventDefault();

    var Fullname   = $("#encoder-fullname").val();
    var Position   = $("#encoder-role").val();
    var UPosition  = $("#encoder-position").val();
    var Username   = $("#encoder-username").val();
    var Password   = $("#encoder-password").val();
    
    $.post("dirs/accounts/actions/save_audit.php", {
        Fullname     : Fullname,
        UPosition    : UPosition,
        Position     : Position,
        Username     : Username,
        Password     : Password,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("System Encoder Created.");
            $("#mdl-add-encoder").modal("hide");
            load_Accounts();
        }else{
            alert("Error: " + data);
        }
    });
});