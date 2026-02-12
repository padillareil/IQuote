$(document).ready(function(){
    loadExpiry();
});



function loadExpiry() {
    $.post("dirs/expiry/components/main.php", {
    }, function (data){
        $("#loadExpiryControl").html(data);
    });
}



function createExpiry() {
    $("#mdl-create-expiry").modal("show");
}

/*Function save Expiration Control*/
$("#frm-expiry").submit(function(event){
    event.preventDefault();

    var CustomerType    = $("#customer-type").val().trim();
    var Type            = $("#expiry-type").val().trim();
    var ExpiryDays      = $("#expiration").val().trim();

    $.post("dirs/expiry/actions/save_expiry.php", {
        CustomerType    : CustomerType,
        Type            : Type,
        ExpiryDays      : ExpiryDays,
    }, function(data){
        if($.trim(data) == "OK"){
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Expiry Created Successfully.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            $("#mdl-create-expiry").modal("hide");
            loadExpiry();
            $("#frm-expiry")[0].reset(); // optional: clear form
        }else{
            alert(data);
        }
    });
});



function editExpiry(CustomerType){
    $("#mdl-edit-expiry").modal("show");
    $.post("dirs/expiry/actions/get_editexpiry.php",{
        CustomerType : CustomerType
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#edit-csutomertype").val(response.Data.CustomerType);
            $("#edit-expiration").val(response.Data.ExpiryDays);
            $("#edit-expiry-type").val(response.Data.Type);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function Update Expiration*/
$("#frm-edit-expiry").submit(function(event){
    event.preventDefault();
    var CustomerType    = $("#edit-csutomertype").val().trim();
    var Type            = $("#edit-expiry-type").val().trim();
    var ExpiryDays      = $("#edit-expiration").val().trim();

    $.post("dirs/expiry/actions/update_expiry.php", {
        CustomerType    : CustomerType,
        Type            : Type,
        ExpiryDays      : ExpiryDays,
    }, function(data){
        if($.trim(data) == "success"){
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Expiry Updated Successfully.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            $("#mdl-edit-expiry").modal("hide");
            loadExpiry();
            $("#frm-edit-expiry")[0].reset(); // optional: clear form
        }else{
            alert(data);
        }
    });
});


/*Function Delete control*/
function deleteExpiry(CustomerType){
    $.post("dirs/expiry/actions/delete_expiry.php", {
        CustomerType : CustomerType
    },function(data){
        if(jQuery.trim(data) == "success"){
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Expiry Deleted Successfully.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            loadExpiry();
        }else{
            alert(data); 
        }
    });
}



