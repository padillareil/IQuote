 $(document).ready(function () {
   $("#togglePassword").on("click", function () {
     const input = $("#create-password");
     const type = input.attr("type") === "password" ? "text" : "password";
     input.attr("type", type);
     $(this).toggleClass("bi-eye bi-eye-slash");
   });
 });


 $("#frm_signup").on("submit", function (event) {
     event.preventDefault();

     var Username    = $("#create-username").val();
     var Password    = $("#create-password").val();
     var Role        = $("#create-role").val();

     // Determine which API to call
     $.post("actions/signup_online.php", {
         Username: Username,
         Password: Password,
         // AccountType: AccountType,
         Role: Role
     }, function(data) {
         if (jQuery.trim(data) === "OK") {
             Swal.fire({
                 icon: 'success',
                 title: 'Account Created',
                 timer: 1000,
                 showConfirmButton: false
             });
         } else {
             Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: $.trim(data),
                 timer: 3000,
                 showConfirmButton: false
             });
         }
     });
 });


 