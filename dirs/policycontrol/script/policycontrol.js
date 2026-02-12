$(document).ready(function(){
    load_Policy();
});



function load_Policy() {
    $.post("dirs/policycontrol/components/main.php", {
    }, function (data){
        $("#load_policy").html(data);
    });
}



/*Function fetch id */
function updateTerms(Termdid){
    $("#mdl-upd-policy").modal("show");
    $.post("dirs/policycontrol/actions/get_policy.php",{
        Termdid : Termdid
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#terms-id").val(response.Data.Termdid);
            $("#upd-policy").val(response.Data.TRMSCON);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function update terms condition policy*/
function updateTerms(){
    var Termdid     = $("#terms-id").val();
    var TRMSCON     = $("#upd-policy").val();

    $.post("dirs/policycontrol/actions/update_policy.php", {
        Termdid     : Termdid,
        TRMSCON     : TRMSCON,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Update success.");
            $("#mdl-upd-policy").modal("hide");
            load_Policy();
        }else{
            alert("Error: " + data);
        }
    });
}


/*Function prompt to delete the policy*/
function mdldelTerms(Termdid){
    $("#mdl-del-terms").modal("show");
    $.post("dirs/policycontrol/actions/get_policy.php",{
        Termdid : Termdid
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#del-termsid").val(response.Data.Termdid);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function Delete Policy*/
function delTerms(){
    var Termdid = $("#del-termsid").val();
    $.post("dirs/policycontrol/actions/delete_policy.php", {
        Termdid : Termdid
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mdl-del-terms").modal('hide');
            load_Policy();
            console.log('delete terms');   
        }else{
            alert(data); 
        }
    });
}


function createTerms() {
    $("#mdl-create-policy").modal("show");
}

/*Function Create Policy*/
function saveCreateTerms(){
    var Termscondition = $("#create-policy").val();
    $.post("dirs/policycontrol/actions/save_terms.php", {
        Termscondition : Termscondition
    },function(data){
        if(jQuery.trim(data) == "OK"){
            $("#mdl-create-policy").modal('hide');
            load_Policy();
            console.log('save terms');   
        }else{
            alert(data); 
        }
    });
}