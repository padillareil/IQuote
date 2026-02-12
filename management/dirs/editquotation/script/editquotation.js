$(document).ready(function(){
    loadEditQuotation();
    
});


function loadEditQuotation() {
    $.post("dirs/editquotation/components/main.php", {
    }, function (data){
        $("#load_editquotation").html(data);
    });
}




/*Function for next form*/
function loadForm2() {
    $('a[href="#payment"]').tab('show');
}

/*Function return form 1*/
function returnForm1() {
    $('a[href="#customer"]').tab('show');
}


/*Function for next form*/
function loadForm3() {
    $('a[href="#order"]').tab('show');
}


/*Function return form 1*/
function returnForm2() {
    $('a[href="#payment"]').tab('show');
}


/*Function for next form*/
function loadForm4() {
    $('a[href="#termscondition"]').tab('show');
}


/*Function return form 1*/
function returnForm3() {
    $('a[href="#payment"]').tab('show');
}


/*Function for next form*/
function loadForm4() {
    $('a[href="#termscondition"]').tab('show');
}


/*Function return form 1*/
function returnForm5() {
    $('a[href="#order"]').tab('show');
}


/*Function for next form*/
function loadForm5() {
    $('a[href="#warranty"]').tab('show');
}


/*Function return form 1*/
function returnForm6() {
    $('a[href="#termscondition"]').tab('show');
}


/*Function for next form*/
function loadForm6() {
    $('a[href="#remarks"]').tab('show');
}


/*Function return form 1*/
function returnForm7() {
    $('a[href="#warranty"]').tab('show');
}





/*Function modal for Manual Discount*/
function loadMauanDiscount() {
    $("#mdl-manual-discount").modal("show");
}



function loadInbox() {
    $.post("dirs/quotations/quotations.php", {
    }, function (data){
        $("#main-content").html(data);
        loadEditQuotation();
    });
}

/*Function approval prompt*/
function mdlApproval() {
  $("#mdl-approval-dialog").modal("show");
}

/*Function reject prompt*/
function mdlReject() {
  $("#mdl-reject-permission").modal("show");
}

function commitreject() {
  $("#mdl-reject-permission").modal('hide');
  $("#mdl-reject-dialog").modal("show");
}

function mdlOnhold() {
  $("#mdl-onhold-dialog").modal("show");
}


/*Function return to sales orders*/
function returnQuotations() {
    $.post("dirs/quotations/quotations.php", {
    }, function (data){
        $("#load_quotations").html(data);
    });
}


/*Function Approved Quotation*/
function commitApproved() {
    var DeliveryCharge = $("#edit-deliverycharge").val();
    var GrandTotal     = $("#edit-grandtotal").val();
    var QNumber        = $("#edit-qnumber").val();
    var PreparedUser  = $("#preparedby-user").val();

    /* For Item Orders */
    let OrdersData = [];

    $(".edit-item-order").each(function () {
        let orderId        = $(this).find(".order-id").val();
        let manualDiscount = $(this).find(".edit-manualdiscount").val();
        let discount       = $(this).find(".edit-discountperunit").val();
        let grossTotal     = $(this).find(".edit-grosstotal").val();
        let discountedamountperunit     = $(this).find(".edit-discountedamountperunit").val();
        OrdersData.push({
            id: orderId,
            manualDiscount: manualDiscount,
            discount: discount,
            grossTotal: grossTotal,
            discountedamountperunit: discountedamountperunit
        });
    });

    /* For Terms and condition */
    let TermsData = [];

    $(".termscondition").each(function () {
        let termsId  = $(this).find(".terms-id").val();
        let termsVal = $(this).find(".edit-termscondition").val().trim();

        if (termsVal !== "") {
            TermsData.push({
                id: termsId,
                value: termsVal
            });
        }
    });

    /* For Warranty */
    let WarrantyData = [];

    $(".warranty").each(function () {
        let warrantyId  = $(this).find(".warranty-id").val();
        let warrantyVal = $(this).find(".edit-warranty").val().trim();

        if (warrantyVal !== "") {
            WarrantyData.push({
                id: warrantyId,
                value: warrantyVal
            });
        }
    });

    let Status = "APPROVED";

    $.post("dirs/editquotation/actions/update_quotapproved.php", {
        DeliveryCharge: DeliveryCharge,
        GrandTotal: GrandTotal,
        QNumber : QNumber,
        PreparedUser :PreparedUser,
        Orders: JSON.stringify(OrdersData),
        Terms: JSON.stringify(TermsData),
        Warranty: JSON.stringify(WarrantyData),
        Status: Status
    }, function (data) {
        if ($.trim(data) == "success") {
           /* console.log("Quotation Approved.");*/
            $("#mdl-approval-dialog").modal("hide");
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Quotation approved.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            returnQuotations();
        } else {
            alert("Error: " + data);
        }
    });
}

/*Function Reject quotation*/
function commitReject(){
    var QNumber     = $("#edit-qnumber").val();
    var Feedback    = $("#reject-comment").val();
    var Status      = 'REJECTED';
    $.post("dirs/editquotation/actions/update_reject.php", {
        QNumber : QNumber,
        Feedback : Feedback,
        Status : Status
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-reject-dialog").modal('hide');
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Quotation rejected.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            returnQuotations();
            /*console.log('delete success');   */
        }else{
            alert(data); 
        }
    });
}

/*Function Reject quotation*/
function commitOnhold(){
    var QNumber     = $("#edit-qnumber").val();
    var Comment     = $("#onhold-reason").val();
    var Feedback    = $("#additional-remarks").val();
    var Status      = 'ON HOLD';
    $.post("dirs/editquotation/actions/update_onhold.php", {
        QNumber : QNumber,
        Comment : Comment,
        Feedback : Feedback,
        Status : Status
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-onhold-dialog").modal('hide');
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Quotation on hold.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            returnQuotations();
          /*  console.log('delete success');   */
        }else{
            alert(data); 
        }
    });
}


/*Function genereated link*/
function mdllink(){
    var QNumber     = $("#edit-qnumber").val();
    $.post("dirs/editquotation/actions/get_referencenumber.php",{
        QNumber : QNumber
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#generate-link").val(response.Data.QNumber);
            $("#mdl-generate-link").modal("show");
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function copy reference number*/
function copyData() {
    var input = document.getElementById("generate-link");
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value)
        .then(() => {
            $("#mdl-generate-link").modal("hide");
        })
        .catch(err => {
            console.error("Failed to copy: ", err);
        });
}


/*Function show modal cancel*/
function mdlCancel() {
    $("#mdl-cancel-dialog").modal("show");
}

/*Function Cancel quotation*/
function commitCancel(){
    var QNumber     = $("#edit-qnumber").val();
    var Comment    = $("#cancel-reason").val();
    var Feedback     = $("#cancel-comment").val();
    var Status      = 'CANCELLED';
    $.post("dirs/editquotation/actions/update_cancel.php", {
        QNumber : QNumber,
        Comment : Comment,
        Feedback : Feedback,
        Status : Status
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-cancel-dialog").modal('hide');
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Quotation cancelled.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            returnQuotations();
          /*  console.log('cancel success');   */
        }else{
            alert(data); 
        }
    });
}
