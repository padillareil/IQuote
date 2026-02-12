$(document).ready(function(){
    loadTermsPolciy();
});



function loadTermsPolciy() {
    $.post("dirs/termspolicy/components/main.php", {
    }, function (data){
        $("#load_termspolicy").html(data);
    });
}

function createPaymentTerm() {
    $("#mld-create-payterm").modal("show");
}

/*Function create payment term*/
function savePaymentPeriod(){
    var PaymentTerm         = $("#create-payterm").val();
    var PaymentPeriod       = $("#create-payperiod").val();

    $.post("dirs/termspolicy/actions/save_paymentterms.php", {
        PaymentTerm : PaymentTerm,
        PaymentPeriod     : PaymentPeriod,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Payment terms added.");
            $("#mld-create-payterm").modal("hide");
            loadTermsPolciy();
        }else{
            alert("Error: " + data);
        }
    });
}


/*function get payment terms*/
function updatePayterm(Pay_id){
    $("#mld-create-payterm").modal("show");
    $.post("dirs/termspolicy/actions/get_payment.php",{
        Pay_id : Pay_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#create-payterm").val(response.Data.PayTerm);
            $("#create-payperiod").val(response.Data.PayPeriod);
            $("#pay-id").val(response.Data.Pay_id);
            $("#btn-save").addClass("d-none");
            $("#btn-update").removeClass("d-none");

            $("#label-payterms").text("Update Payment Term")
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function delete*/
function mdldelPayment(Pay_id){
    $("#mdl-delete-payterm").modal("show");
    $.post("dirs/termspolicy/actions/get_payment.php",{
        Pay_id : Pay_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#del-payterm").val(response.Data.Pay_id);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function update payement terms*/
function delBranch(){
    var Pay_id   = $("#del-payterm").val();
    $.post("dirs/termspolicy/actions/delete_paymentterms.php", {
        Pay_id : Pay_id,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Payment terms deleted.");
            $("#mdl-delete-payterm").modal("hide");
            loadTermsPolciy();
        }else{
            alert("Error: " + data);
        }
    });
}


/*Function update payement terms*/
function updatePaymentPeriod(){
    var Pay_id              = $("#pay-id").val();
    var PaymentTerm         = $("#create-payterm").val();
    var PaymentPeriod       = $("#create-payperiod").val();

    $.post("dirs/termspolicy/actions/update_payterms.php", {
        PaymentTerm : PaymentTerm,
        PaymentPeriod     : PaymentPeriod,
        Pay_id     : Pay_id,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Payment terms updated.");
            $("#mld-create-payterm").modal("hide");
            loadTermsPolciy();
        }else{
            alert("Error: " + data);
        }
    });
}



function createDownpayment() {
    $("#mld-create-downpayment").modal("show");
}


/*Function create downpayment */
function saveDownpayment(){
    var Downpaymentvalue = $.trim($("#create-downpayment").val());
    var Percentsymbol = "%";
    if (Downpaymentvalue.endsWith("%")) {
        Downpaymentvalue = Downpaymentvalue.slice(0, -1);
    }
    var Downpayment = Downpaymentvalue + Percentsymbol;

    $.post("dirs/termspolicy/actions/save_downpayment.php", {
        Downpayment : Downpayment
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Downpayment added.");
            $("#mld-create-downpayment").modal("hide");
            loadTermsPolciy();
        }else{
            alert("Error: " + data);
        }
    });
}


/*function get payment terms*/
function updateDownpayment(DP_id){
    $("#mld-create-downpayment").modal("show");
    $.post("dirs/termspolicy/actions/get_downpayment.php", {
        DP_id: DP_id
    }, function(data){
        response = JSON.parse(data);
        if($.trim(response.isSuccess) === "success"){
            var dpValue = response.Data.DPayment.replace("%", "");
            $("#create-downpayment").val(dpValue);
            $("#dp-id").val(response.Data.DP_id);
            $("#btn-savedp").addClass("d-none");
            $("#btn-updatedp").removeClass("d-none");

            $("#label-downpayment").text("Update Downpayment");
        } else {
            alert($.trim(response.Data));
        }
    });
}


/*Function update downpayment*/
function updatedDownpayment(){
    var DP_id               = $("#dp-id").val();
    var Downpaymentvalue    = $.trim($("#create-downpayment").val());
    var Percentsymbol = "%";
    if (Downpaymentvalue.endsWith("%")) {
        Downpaymentvalue = Downpaymentvalue.slice(0, -1);
    }
    var Downpayment = Downpaymentvalue + Percentsymbol;
    $.post("dirs/termspolicy/actions/update_downpayment.php", {
        DP_id  : DP_id ,
        Downpayment     : Downpayment,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Downpayment updated.");
            $("#mld-create-downpayment").modal("hide");
            loadTermsPolciy();
        }else{
            alert("Error: " + data);
        }
    });
}


/*Function delete*/
function mdldelDownpayment(DP_id){
    $("#mdl-delete-downpayment").modal("show");
    $.post("dirs/termspolicy/actions/get_downpayment.php",{
        DP_id : DP_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#del-dpid").val(response.Data.DP_id);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function update payement terms*/
function delDwnpayment(){
    var DP_id   = $("#del-dpid").val();
    $.post("dirs/termspolicy/actions/delete_downpayment.php", {
        DP_id : DP_id,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Downpayment deleted.");
            $("#mdl-delete-downpayment").modal("hide");
            loadTermsPolciy();
        }else{
            alert("Error: " + data);
        }
    });
}