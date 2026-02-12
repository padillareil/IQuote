/*Javascript Clock*/
$(document).ready(function(){
  loadsetup();
  loadUsertype();
  loadCondition();
  window.setInterval(function () {
    loadResetup();
    accountChecker();
    const now = moment();
    $('#calendar').html(now.format('MMM D, YYYY'));    // Example: Jul 24, 2025
    $('#clock').html(now.format('h:mm:ss A'));         // Example: 9:45:12 PM
    $('#clockvalue').val(now.format('h:mm:ss A'));     // Hidden value
  }, 1000);
});


/*Sidebar Navigation*/
$(document).ready(function(){
   $("#main-menu")
  .find("li.nav-item")
  .find("a.nav-link[name='menu'].active")
  .click();
})
$("#main-menu")
.find("li.nav-item")
.find("a.nav-link[name='menu']")
.on("click", function(){
  $("#main-menu")
  .find("li.nav-item")
  .find("a.nav-link[name='menu']")
  .removeClass("active");
  var $a = $(this);
  var menucode = $a.attr("menucode");
  var $file;
  switch(menucode){
    case "home":
      $maintitle = "Home";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/home/home.php";
    break;
    case "quotations":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/quotations/quotations.php";
    break;
    case "accounts":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/accounts/accounts.php";
    break;
    case "acc-approver":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/acc-approver/acc-approver.php";
    break;
  case "acc-branch":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/acc-branch/acc-branch.php";
    break;
    case "acc-encoder":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/acc-encoder/acc-encoder.php";
    break;
    case "ho-encoder":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/ho-encoder/ho-encoder.php";
    break;
    case "settings":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/settings/settings.php";
    break;
  }
    var spinner = gen_spinner("spinner-border-sm", "text-primary");
    $("#main-content").html(spinner);
    $.post($file, function(data){
      $("#main-title").html($maintitle);
      $("#main-breadcrumb").html($mainbreadcrumb);
      $("#main-content").html(data);
      $a.addClass("active");
    })
  })

/*Function to setup new account*/
  function loadsetup() {
    var SetupStat = $("#setup-account").val();
    if (SetupStat == 'N') {
      $("#mdl-setup-account").modal("show");
    } else {
      $("#mdl-setup-account").modal("hide");
    }
  }

  function clientLogout() {
    $.post("../actions/logout.php", {}, function(data) {
        if ($.trim(data) == "OK") {
            window.location.assign("index.php");
        }
    });
  }

  /*Function condition for navigation bar*/
  function loadCondition() {
    var UserType = $("#user-role").val();
    if (UserType == 'C') {
      $("#nav-account").addClass("d-none");
    } 
  }


  /* Load Notify */
  $(document).ready(function () {
      loadNotify(); // initial load
      setInterval(function () {
          loadNotify();
      }, 6000);
  });

  /* Function to fetch approved */
  function loadNotify() {
      $.post("../actions/get_notify.php", {}, function (data) {
          let response = JSON.parse(data);

          if ($.trim(response.isSuccess) === "success") {
              if (response.Data.Status === "New") {
                  console.log("New notification:", response.Data);

                  $("#quotation-id").text(response.Data.QNumber);
                  $("#approver-user").text(response.Data.Approver);
                  $("#liveToast").toast("show");

                  // expire this notification after 5 seconds
                  setTimeout(function () {
                      loadupdApprove(response.Data.Notify_id);
                  }, 5000);
              }
          } else {
              console.log("Notification error:", response.Data);
          }
      });
  }

  /* Update notify status */
  function loadupdApprove(Notify_id) {
      var Status = "Expired";
      $.post("../actions/update_notify.php", {
          Notify_id: Notify_id,
          Status: Status
      }, function (data) {
          if ($.trim(data) === "success") {
              console.log("Notification expired:", Notify_id);
              $("#liveToast").toast("hide");
          } else {
              console.log("Update error:", data);
          }
      });
  }


  function loadResetup(){
      $.post("../actions/get_resetup.php",{
      },function(data){
          response = JSON.parse(data);
          if(jQuery.trim(response.isSuccess) == "success"){
              (response.Data.IDMAccess);
              if (response.Data.IDMAccess === '1') {
                $("#modal-reset-pasword").modal('show');
              }
          }else{
              alert(jQuery.trim(response.Data));
          }
      });
  }


  function accountChecker(){
      $.post("../actions/get_checkaccount.php",{
      },function(data){
          response = JSON.parse(data);
          if(jQuery.trim(response.isSuccess) == "success"){
              (response.Data.AccountStatus);
              if (response.Data.AccountStatus === 'DISABLED') {
                $("#mdl-logout-dialog").modal("show");
              }
          }else{
              alert(jQuery.trim(response.Data));
          }
      });
  }

/*Check User type*/
  function loadUsertype(){
    var Usertype = $("#user-type").val();
      $.post("../actions/get_utypeexecutive.php",{
          Usertype : Usertype
      },function(data){
          response = JSON.parse(data);
          if(jQuery.trim(response.isSuccess) == "success"){
              (response.Data.Position);
              if (response.Data.Position === 'Staff') {
                $("#create-account").addClass('d-none');
              }
          }else{
              alert(jQuery.trim(response.Data));
          }
      });
  }