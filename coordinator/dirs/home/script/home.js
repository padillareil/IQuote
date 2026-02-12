$(document).ready(function(){
    loadDashboard();

});



function loadDashboard() {
    $.post("dirs/home/components/main.php", {
    }, function (data){
        $("#load_Home").html(data);
        loadQuotations();
    });
}

/*Function apply findings*/
function mdlReactivate(QNumber){
    $("#mdl-reactivate").modal("show");
    $.post("dirs/home/actions/get_qnumber.php",{
        QNumber : QNumber
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#q-number").val(response.Data.QNumber);
            $("#customertype").val(response.Data.CustomerType);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function update reactivate*/
$("#frm-reactivate").submit(function(event){
    event.preventDefault();
    var QNumber = $("#q-number").val();
    var CustomerType = $("#customertype").val();
    var Remarks = $("#remarks").val();
    $.post("dirs/home/actions/update_reactivate.php", {
        QNumber: QNumber,
        CustomerType : CustomerType,
        Remarks :Remarks,
    }, function(data){
        if($.trim(data) == "OK"){
            $("#mdl-reactivate").modal("hide");
            loadDashboard();
        } else {
            alert("Error: " + data);
            $("#mdl-reactivate").modal("hide");
        }
    });
});

