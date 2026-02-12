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
function mdlFindings(QNumber){
    $("#mdl-findings").modal("show");
    $.post("dirs/home/actions/get_qnumber.php",{
        QNumber : QNumber
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#q-number").val(response.Data.QNumber);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function save findings*/
function saveFinginds(){
    var QNumber     = $("#q-number").val();
    $.post("dirs/home/actions/save_findings.php", {
        QNumber : QNumber
    }, function(data){
        if($.trim(data) == "OK"){
            $("#mdl-findings").modal("hide");
            loadQuotations();
            loadDashboard();
        }else{
            alert("Error: " + data);
            $("#mdl-findings").modal("hide");
        }
    });
}

/*Function show Attachment*/
function mdlAttachment(QNumber) {
    $("#mdl-attachment").modal("show");

    $.post("dirs/home/actions/get_qnumber.php", { QNumber: QNumber }, function (data) {
        let response = JSON.parse(data);

        if ($.trim(response.isSuccess) === "success") {
            let attachmentPath = response.Data.Attachment; 
            if (attachmentPath && attachmentPath !== "") {
                $("#show-attachment").attr("src", "" + attachmentPath);
            } else {
                $("#show-attachment").attr("src", "../assets/image/logo/qtlogo.png");
            }

        } else {
            alert($.trim(response.Data));
        }
    });
}


