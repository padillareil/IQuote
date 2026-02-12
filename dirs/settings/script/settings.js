$(document).ready(function(){
    loadSettings();
});


function loadSettings() {
    $.post("dirs/settings/components/main.php", {
    }, function (data){
        $("#load_settings").html(data);
    });
}



function updatePassword(){
    var NewPassword     = $("#create-newpassword").val();
    var ConfirmPassword = $("#confirm-password").val();
    var ErrorMessage    = $("#error-message");

    ErrorMessage.addClass("d-none");
    if (NewPassword !== ConfirmPassword) {
        ErrorMessage.text("Passwords do not match.").removeClass("d-none");
        return;
    }

    if (NewPassword.trim() === "") {
        ErrorMessage.text("Password cannot be empty.").removeClass("d-none");
        return;
    }

    $.post("dirs/settings/actions/update_password.php", {
        Password: NewPassword
    }, function(data){
        if ($.trim(data) === "success") {
            console.log("Password changed.");
            loadSettings();
        } else {
            alert("Error: " + data);
        }
    });
}



/*function clear inputs*/
function clearInputs() {
    $("#create-newpassword").val("");
    $("#confirm-password").val("");
}