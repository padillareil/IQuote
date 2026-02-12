$(document).ready(function(){
    load_UserSettings();
});



function load_UserSettings() {
    $.post("dirs/settings/components/main.php", {
    }, function (data){
        $("#load_Settings").html(data);
        load_quotation();
        loadProfile();
    });
}


/*Load info user quotation*/
function load_quotation(){
    $.post("dirs/settings/actions/get_quotation.php",{
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#account-name").text(response.Data.Name);
            $("#number-pending").text(response.Data.Pending);
            $("#number-approved").text(response.Data.Approved);
            $("#number-rejected").text(response.Data.Rejected);
            $("#number-cancelled").text(response.Data.Cancelled);
            $("#number-onhold").text(response.Data.OnHold);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function show modal for change password*/
function mdl_account() {
    $("#mdl_show_account").modal("show");
}


/*Function update password*/
function saveNewPassword() {
    var NewPassword     = $("#setnew-password").val().trim();
    var ConfirmPassword = $("#setconfirm-password").val().trim();
    if (NewPassword === "" || ConfirmPassword === "") {
        Swal.fire({
            icon: "warning",
            title: "Missing Fields",
            text: "Please fill out fields.",
        });
        return;
    }
    if (NewPassword !== ConfirmPassword) {
        Swal.fire({
            icon: "error",
            title: "Password Mismatch",
            text: "Password doesn't matched.",
        });
        return;
    }
    $.post("dirs/settings/actions/update_password.php", {
        NewPassword: NewPassword,
    }, function(data) {
        if ($.trim(data) === "success") {
           /* console.log("Password changed successfully.");*/
            $("#mdl_show_account").modal("hide");
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Password successfully changed.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            load_UserSettings();
        } else {
            console.log("Password update error:", data);
        }
    });
}

/*Function fetch user information*/
// function loadProfile() {
//     $.post("dirs/settings/actions/get_profile.php", {}, function(data) {
//         let response = typeof data === "object" ? data : JSON.parse(data);
//         if ($.trim(response.isSuccess) === "success") {
//             let userData = response.Data;
//             let profileImg;
//             if (userData && userData.Profile) {
//                 profileImg = "data:image/jpeg;base64," + userData.Profile;
//             } else {
//                 profileImg = "../assets/image/avatar/noimage.avif";
//             }
//             $("#profile-image").attr("src", profileImg);
//             $("#user-fullname").text(userData.Name || "N/A");
//             $("#user-position").text(userData.Position || "N/A");
            
//         } else {
//             console.error("Fetch Error:", response.Data);
//         }
//     });
// }
function loadProfile(){
    $.post("dirs/settings/actions/get_profile.php", {}, function(data){
        let response = JSON.parse(data);

        if ($.trim(response.isSuccess) === "success") {
            $("#user-fullname").text(response.Data.Name);
            $("#user-position").text(response.Data.Position);
            if (
                response.Data.Profile &&
                response.Data.Profile.trim() !== ""
            ) {
                $("#profile-image").attr("src","data:image/jpeg;base64," + response.Data.Profile);
            } else {
                $("#profile-image").attr("src","../assets/image/avatar/noimage.avif");
            }
        } else {
            $("#profile-image").attr("src","../assets/image/avatar/noimage.avif"
            );
            alert($.trim(response.Data));
        }
    });
}


/*Function upload profile*/
function uploadProfile() {
    $("#modal-profile").modal("show");
}

// /*Function Upload Profile*/
// function commitUploadImage() {
//     var fileInput = $("#upload-image-profile")[0];
//     var file = fileInput.files[0];

//     if (!file) {
//         alert("Please select a file to upload.");
//         return;
//     }
//     var formData = new FormData();
//     formData.append("Profile", file);
//     $.ajax({
//         url: "dirs/settings/actions/update_profile.php",
//         type: "POST",
//         data: formData,
//         processData: false, 
//         contentType: false, 
//         success: function(data) {
//             if ($.trim(data) === "OK") {
//                 console.log("Profile uploaded.");
//                 $("#mdl-upload-profile").modal("hide");
//                 Swal.fire({
//                     toast: true,
//                     position: "top-end",
//                     icon: "success",
//                     title: "Profile uploaded successfully.",
//                     showConfirmButton: false,
//                     timer: 3000,
//                     timerProgressBar: true
//                 });
//                 load_UserSettings();
//             } else {
//                 alert("Error: " + data);
//             }
//         },
//         error: function(xhr, status, error) {
//             alert("Upload failed: " + error);
//         }
//     });
// }
