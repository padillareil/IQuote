$(document).ready(function(){
    loadPDFHeader();
});



function loadPDFHeader() {
    $.post("dirs/pdfheaders/components/main.php", {
    }, function (data){
        $("#load_pdfheaders").html(data);
    });
}



function loadHeaderImage(Header_id){
    $.post("dirs/pdfheaders/actions/get_image.php", {
        Header_id : Header_id
    }, function(data){
        response = JSON.parse(data);
        if($.trim(response.isSuccess) === "success"){
            $("#preview-image").attr("src", response.Data.ImageHeader);
            $("#image-id").val(response.Data.Header_id);
        } else {
            alert($.trim(response.Data));
        }
    });
}


function updateDetailsHeader(Header_id){
    $("#mdl-upload-header").modal("show");
    $.post("dirs/pdfheaders/actions/get_image.php", {
        Header_id : Header_id
    }, function(data){
        response = JSON.parse(data);
        if($.trim(response.isSuccess) === "success"){
            $("#image-preview").attr("src", response.Data.ImageHeader);
            $("#image-id").val(response.Data.Header_id);
            $("#pdf-corporation").val(response.Data.Corpo);
            $("#btn-save").addClass('d-none');
            $("#btn-update").removeClass('d-none');

        } else {
            alert($.trim(response.Data));
        }
    });
}


/*Fucntion update header*/
function updateHeader() {
    var Corporation = $("#pdf-corporation").val();
    var Header_id = $("#image-id").val();
    var Corpocode = '';

    if (Corporation === 'SOLU TRADING CORPORATION') {
        Corpocode = 'STC';
    } else if (Corporation === 'NOLU MARKETING CORPORATION') {
        Corpocode = 'NOLU';
    } else if (Corporation === 'ALPHAMIN COMMERCIAL CORPORATION') {
        Corpocode = 'ACC';
    } else if (Corporation === 'VIC IMPERIAL APPLIANCE CORPORATION') {
        Corpocode = 'VIAC';
    }

    var fileInput = $("#upload-image-pdfheader")[0];
    var file = fileInput.files[0];

    if (!file) {
        alert("Please select a file to upload.");
        return;
    }

    var formData = new FormData();
    formData.append("Profile", file);
    formData.append("Corporation", Corporation);
    formData.append("Header_id", Header_id);
    formData.append("Corpocode", Corpocode);

    $.ajax({
        url: "dirs/pdfheaders/actions/update_header.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if ($.trim(data) === "OK") {
                console.log("Profile uploaded.");
                $("#mdl-upload-header").modal("hide");
                loadPDFHeader();
            } else {
                alert("Error: " + data);
            }
        }
    });
}



function createPDFHEADER() {
    $("#mdl-upload-header").modal("show");
}

/*Function Upload Profile*/
function uploadHeader() {
    var Corporation = $("#pdf-corporation").val();
    var Corpocode = '';

    if (Corporation === 'SOLU TRADING CORPORATION') {
        Corpocode = 'STC';
    } else if (Corporation === 'NOLU MARKETING CORPORATION') {
        Corpocode = 'NOLU';
    } else if (Corporation === 'ALPHAMIN COMMERCIAL CORPORATION') {
        Corpocode = 'ACC';
    } else if (Corporation === 'VIC IMPERIAL APPLIANCE CORPORATION') {
        Corpocode = 'VIAC';
    }

    var fileInput = $("#upload-image-pdfheader")[0];
    var file = fileInput.files[0];

    if (!file) {
        alert("Please select a file to upload.");
        return;
    }

    var formData = new FormData();
    formData.append("Profile", file);
    formData.append("Corporation", Corporation);
    formData.append("Corpocode", Corpocode);

    $.ajax({
        url: "dirs/pdfheaders/actions/save_pdfheader.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if ($.trim(data) === "OK") {
                console.log("Profile uploaded.");
                $("#mdl-upload-header").modal("hide");
                loadPDFHeader();
            } else {
                alert("Error: " + data);
            }
        }
    });
}



function mdlDeleteHeader(Header_id){
    $("#mdl-delete-header").modal("show");
    $.post("dirs/pdfheaders/actions/get_image.php", {
        Header_id : Header_id
    }, function(data){
        response = JSON.parse(data);
        if($.trim(response.isSuccess) === "success"){
            $("#del-header").val(response.Data.Header_id);

        } else {
            alert($.trim(response.Data));
        }
    });
}


/*function delete*/
function delHeader(){
    var Header_id = $("#del-header").val();
    $.post("dirs/pdfheaders/actions/delete_header.php", {
        Header_id : Header_id
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-delete-header").modal('hide');
            loadPDFHeader();
            console.log('delete success');   
        }else{
            alert(data); 
        }
    });
}   