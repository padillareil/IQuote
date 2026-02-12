/*Javascript Clock*/
$(document).ready(function(){
  window.setInterval(function () {
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
    case "dashboard":
      $maintitle = "Dashboard";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/dashboard/dashboard.php";
    break;
    case "accounts":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/accounts/accounts.php";
    break;
    case "policycontrol":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/policycontrol/policycontrol.php";
    break;
    case "bank":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/bank/bank.php";
    break;
    case "termspolicy":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/termspolicy/termspolicy.php";
    break;
    case "pdfheaders":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/pdfheaders/pdfheaders.php";
    break;
    case "contacts":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/contacts/contacts.php";
    break;
    case "branch":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/branch/branch.php";
    break;
    case "maintenance":
      $maintitle = "";
      $mainbreadcrumb = `
        <li class="breadcrumb-item active"></li>
      `;
      $file = "dirs/maintenance/maintenance.php";
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



function Logout() {
  $.post("actions/logout.php", {}, function(data) {
      if ($.trim(data) == "OK") {
          window.location.assign("index.php");
      }
  });
}


