/*Login user*/
/*$("#frm-login").on("submit", function(e){
  e.preventDefault();
  var $frm = $("#frm-login");
  var Username = $frm.find("input[name='username']").val();
  var Password = $frm.find("input[name='user-password']").val();
  $.post("../../actions/login.php",{
    Username  : Username,
    Password  : Password
  }, function(data){
    if($.trim(data) == "OK"){
        window.location.assign("index.php");
    }else{
          toast_alert("error", data);
    }
  })
})*/



/*Function toggle show password*/
function loadshowPssword() {
  var passwordInput = $("#user-password");
  var toggleIcon = $("#toggle-icon");

  var isPassword = passwordInput.attr("type") === "password";
  passwordInput.attr("type", isPassword ? "text" : "password");

  toggleIcon.toggleClass("bi-eye bi-eye-slash");
}


$("#frm-login").on("submit", function (event) {
  event.preventDefault();

  var $frm = $(this);
  var Username = $frm.find("input[name='user-username']").val().trim();
  var Password = $frm.find("input[name='user-password']").val().trim();

  $.post("actions/login.php", { 
    Username: Username, 
    Password: Password 
  }, function (data) {
    var response = JSON.parse(data);

    if (response.isSuccess === "OK") {
      $frm[0].reset();

      var Status = response.Data.AccountStatus;

      if (Status === "DISABLED") {
        alert("Please Contact System Administrator for account recovery.");
        return; // stop execution, no redirect
      }

      var role = response.Data.Role; 
      if (role === "Admin" || role === "ONLN") {
        window.location.assign("manager/index.php");
      } else if (role === "HA" || role === "CNC" || role === "AR" || role === "ICBU") {
        window.location.assign("executive/index.php");
      } else if (role === "SA") {
        window.location.assign("index.php");
      } else if (role === "RM") {
        window.location.assign("area_mgr/index.php");
      } else if (role === "BOSS") {
        window.location.assign("management/index.php");
      } else if (role === "HBU") {
        window.location.assign("iapcorpobusinessexecutive/index.php");
      } else if (role === "Audit") {
        window.location.assign("audit/index.php");
      } else if (role === "Coordinator") {
        window.location.assign("coordinator/index.php");
      } else if (role === "EN" || role === "TR") {
        window.location.assign("encoder/index.php");
      } else {
        window.location.assign("client/index.php");
      }

    } else {
       console.log("Login failed:", response.Message);
      $("#user-username").addClass("input-error");
      $("#user-password").addClass("input-error");
      $("#login-error").removeClass("d-none");
    }
  });
});


