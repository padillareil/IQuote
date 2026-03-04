$(document).ready(function(){
    load_alterquote();
});


function load_alterquote() {
    $.post("dirs/alterquotation/components/main.php", {
    }, function (data){
        $("#load_alterquotation").html(data);
    });
}

