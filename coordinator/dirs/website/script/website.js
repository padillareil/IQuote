$(document).ready(function(){
    load_Website();
});



function load_Website() {
    $.post("dirs/website/components/main.php", {
    }, function (data){
        $("#loadWebsite").html(data);
    });
}



function mdlWeblink() {
    $("#mdl-web-link").modal("show");
}

/*Function save Expiration Control*/
$("#frm-add-weblink").submit(function(event){
    event.preventDefault();

    var Web_url    = $("#web-link").val().trim();

    $.post("dirs/website/actions/save_weblink.php", {
        Web_url    : Web_url
    }, function(data){
        if($.trim(data) == "OK"){
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Website URL saved Successfully.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            $("#mdl-web-link").modal("hide");
            load_Website();
            $("#frm-add-weblink")[0].reset(); 
        }else{
            alert(data);
        }
    });
});



function editWeblink(Web_id){
    $("#mdl-edit-link").modal("show");
    $.post("dirs/website/actions/get_weblink.php",{
        Web_id : Web_id
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#web_id").val(response.Data.Web_id);
            $("#editweb-link").val(response.Data.Web_url);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function Update Expiration*/
$("#frm-edit-weblink").submit(function(event){
    event.preventDefault();
    var Web_id    = $("#web_id").val().trim();
    var Web_url   = $("#editweb-link").val().trim();

    $.post("dirs/website/actions/update_url.php", {
        Web_id   : Web_id,
        Web_url  : Web_url,
    }, function(data){
        if($.trim(data) == "success"){
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Website Link Updated Successfully.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            $("#mdl-edit-link").modal("hide");
            load_Website();
            $("#frm-edit-weblink")[0].reset(); // optional: clear form
        }else{
            alert(data);
        }
    });
});


/*Function Delete control*/
function deleteWeblink(Web_id){
    $.post("dirs/website/actions/delete_url.php", {
        Web_id : Web_id
    },function(data){
        if(jQuery.trim(data) == "success"){
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: "Website Deleted Successfully.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            load_Website();
        }else{
            alert(data); 
        }
    });
}



