$(document).ready(function(){
    loadContacts();
});


function loadContacts() {
    $.post("dirs/contacts/components/main.php", {
    }, function (data){
        $("#load_Contacts").html(data);
    });
}



function createContact() {
    $("#mdl-create-contact").modal("show");
}

/*Function save contact number*/
function saveContactnumber(){
    var Branch      = $("#create-branch").val();
    var Telephone   = $("#create-telephone").val();
    var Mobile      = $("#create-mobile").val();
    var Network     = $("#create-mobilenetwork").val();

    $.post("dirs/contacts/actions/save_contact.php", {
        Branch        : Branch,
        Telephone     : Telephone,
        Mobile        : Mobile,
        Network        : Network,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Contact added.");
            $("#mdl-create-contact").modal("hide");
            loadContacts();
        }else{
            alert("Error: " + data);
        }
    });
}

/*Update contact number details*/
function updateContact(TID){
    $("#mdl-create-contact").modal("show");
    $.post("dirs/contacts/actions/get_contacts.php",{
        TID : TID
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#upd-tid").val(response.Data.TID);
            $("#create-branch").val(response.Data.Branch);
            $("#create-mobile").val(response.Data.Mobile);
            $("#create-telephone").val(response.Data.Telephone);
            $("#create-mobilenetwork").val(response.Data.Network);
            $("#btn-save").addClass("d-none");
            $("#btn-update").removeClass("d-none");
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}



/*Function update contact number*/
function updatedContact(){
    var Branch      = $("#create-branch").val();
    var Telephone   = $("#create-telephone").val();
    var Mobile      = $("#create-mobile").val();
    var Network     = $("#create-mobilenetwork").val();
    var TID         = $("#upd-tid").val();

    $.post("dirs/contacts/actions/update_contact.php", {
        Branch        : Branch,
        Telephone     : Telephone,
        Mobile        : Mobile,
        Network        : Network,
        TID             : TID,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Contact added.");
            $("#mdl-create-contact").modal("hide");
            loadContacts();
        }else{
            alert("Error: " + data);
        }
    });
}


/*Function get delete contact number*/
function mdldelContact(TID){
    $("#mdl-delete-contact").modal("show");
    $.post("dirs/contacts/actions/get_contacts.php",{
        TID : TID
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#del-contact").val(response.Data.TID);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function delete contact number*/
function delContact(){
    var TID  = $("#del-contact").val();

    $.post("dirs/contacts/actions/delete_contact.php", {
        TID  : TID,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Contact deleted.");
            $("#mdl-delete-contact").modal("hide");
            loadContacts();
        }else{
            alert("Error: " + data);
        }
    });
}