$(document).ready(function(){
    loadHome();
    
});


function loadHome() {
    $.post("dirs/quotations/components/main.php", {
    }, function (data){
        $("#load_quotations").html(data);
        loadBranches();
        loadStoreBranches();
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



function loadFilterModal() {
    $("#").modal("show");
}

/*load to Open Quotation*/
/*function loadOpenQuotation() {
    $.post("dirs/editquotation/editquotation.php", {
    }, function (data){
        $("#main-content").html(data);
    });
}
*/


function loadmdlVerify() {
    $("#mdl-verify").modal("show")
}

function mdlDateRange() {
    $("#mdl-set-daterange").modal("show");
}

/*Function to load all branches*/
function loadBranches() {
    $.post("dirs/quotations/actions/get_branches.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var branches = response.Data;
            var $branch = $("#filter-branch");
            $branch.empty();
            $branch.append('<option selected disabled>Select Branch</option>');

            branches.forEach(function(branch) {
                $branch.append('<option value="' + $.trim(branch.BranchName) + '">' + branch.BranchName + '</option>');
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}

/*Function load Filter branch*/
function mdlFilterBranches() {
    $("#mdl-select-branch").modal("show");
}
/*Function load all Branches*/
function loadStoreBranches() {
    $.post("dirs/quotations/actions/get_branches.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var branches = response.Data;
            var $branch = $("#filter-storebranch");
            $branch.empty();
            $branch.append('<option selected disabled>Select Branch</option>');

            branches.forEach(function(branch) {
                $branch.append('<option value="' + $.trim(branch.BranchName) + '">' + branch.BranchName + '</option>');
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}

/*Function show quotation information */
function loadInformationStatus(QNUMBER){
    $.post("dirs/quotations/actions/get_quotationinfo.php",{
        QNUMBER : QNUMBER
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            if (response.Data.QSTATUS === 'REJECTED') {
                $("#mdl-quote-status").modal("show");
                $("#qutation-info").val(response.Data.FEEDBACK);
            }else if (response.Data.QSTATUS === 'ON HOLD') {
                $("#mdl-quote-status").modal("show");
                $("#qutation-info").val(response.Data.Comment + " - " + response.Data.FEEDBACK);
            }
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}




/*Function show the status of the quotation*/
function loadSeeDetails(QNUMBER){
    $("#mdl-quotestatus-dialog").modal("show");
    $.post("dirs/quotations/actions/get_quotestatus.php",{
        QNUMBER : QNUMBER
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#onhold-reasonstatus").val(response.Data.Comment);
            $("#additional-remarksstatus").val(response.Data.FEEDBACK);

            if (response.Data.QSTATUS === 'REJECTED') {
                 $("#onhold-reasonfield").addClass('d-none');
            }
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}








/*Function for next form*/
function EditloadForm2() {
    $('a[href="#payment"]').tab('show');
}

/*Function return form 1*/
function EditreturnForm1() {
    $('a[href="#customer"]').tab('show');
}


/*Function for next form*/
function EditloadForm3() {
    $('a[href="#order"]').tab('show');
}


/*Function return form 1*/
function EditreturnForm2() {
    $('a[href="#payment"]').tab('show');
}


/*Function for next form*/
function EditloadForm4() {
    $('a[href="#termscondition"]').tab('show');
}


/*Function return form 1*/
function EditreturnForm3() {
    $('a[href="#payment"]').tab('show');
}


/*Function for next form*/
function EditloadForm4() {
    $('a[href="#termscondition"]').tab('show');
}


/*Function return form 1*/
function EditreturnForm5() {
    $('a[href="#order"]').tab('show');
}


/*Function for next form*/
function EditloadForm5() {
    $('a[href="#warranty"]').tab('show');
}


/*Function return form 1*/
function EditreturnForm6() {
    $('a[href="#termscondition"]').tab('show');
}


/*Function for next form*/
function EditloadForm6() {
    $('a[href="#remarks"]').tab('show');
}


/*Function return form 1*/
function EditreturnForm7() {
    $('a[href="#warranty"]').tab('show');
}


