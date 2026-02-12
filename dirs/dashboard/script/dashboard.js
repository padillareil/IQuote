$(document).ready(function(){
    loadDashboard();
});



function loadDashboard() {
    $.post("dirs/dashboard/components/main.php", {
    }, function (data){
        $("#load_dashboard").html(data);
    });
}




function resetAccount() {
    $("#mdl-reset").modal("show");
}


/*function Start Reset*/
function resetNow(){
    $.post("dirs/dashboard/actions/update_reset.php", {
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-reset").modal('hide');
            loadDashboard();
            console.log('Account resets');   
        }else{
            alert(data); 
        }
    });
}