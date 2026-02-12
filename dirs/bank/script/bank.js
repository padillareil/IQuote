$(document).ready(function(){
    load_Banks();
});


function load_Banks() {
    $.post("dirs/bank/components/bank.php", {
    }, function (data){
        $("#load_bank").html(data);
    });
}



function updateBank(Bnkid){
    $("#mld-update-bank").modal("show");
    $.post("dirs/bank/actions/get_bank.php",{
        Bnkid : Bnkid
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#upd-bank").val(response.Data.Bank);
            $("#upd-bakid").val(response.Data.Bnkid);
            $("#upd-accountname").val(response.Data.AccName);
            $("#upd-accountnumber").val(response.Data.AccNumber);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


/*Function save update bank*/
function saveUPDBank(){
    var Bnkid           = $("#upd-bakid").val();
    var Bank            = $("#upd-bank").val();
    var AccName         = $("#upd-accountname").val();
    var AccNumber       = $("#upd-accountnumber").val();

    $.post("dirs/bank/actions/update_bank.php", {
        Bnkid : Bnkid,
        Bank     : Bank,
        AccName         : AccName,
        AccNumber      : AccNumber,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Bank updated.");
            $("#mld-update-bank").modal("hide");
            load_Banks();
        }else{
            alert("Error: " + data);
        }
    });
}

function mdldelBank(Bnkid){
    $("#mld-del-bank").modal("show");
    $.post("dirs/bank/actions/get_bank.php",{
        Bnkid : Bnkid
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#del-bakid").val(response.Data.Bnkid);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Delete bank*/
function deletebank(){
    var Bnkid    = $("#del-bakid").val();

    $.post("dirs/bank/actions/delete_bank.php", {
        Bnkid : Bnkid,
    }, function(data){
        if($.trim(data) == "success"){
            console.log("Bank updated.");
            $("#mld-del-bank").modal("hide");
            load_Banks();
        }else{
            alert("Error: " + data);
        }
    });
}


function mdlCreateBranch() {
    $("#mld-create-bank").modal("show");
}

/*Create branch bank*/
function saveBranchbank(){
    var Branch              = $("#create-branch").val();
    var Bank                = $("#create-bank").val();
    var AccountName         = $("#create-accountname").val();
    var AccountNumber       = $("#create-accountnumber").val();
    var Corporation         = $("#create-corpotype").val();
    var Bankownership       = 'BRNCH';
    var Corpcode = '';
    if (Corporation === 'VIC IMPERIAL APPLIANCE CORPORATION') {
        Corpcode = 'VIAC';
    } else if (Corporation === 'NOLU MARKETING CORPORATION') {
        Corpcode = 'NOLU';
    } else if (Corporation === 'ALPHAMIN COMMERCIAL CORPORATION') {
        Corpcode = 'ACC';
    } else if (Corporation === 'SOLU TRADING CORPORATION') {
        Corpcode = 'SOLU';
    }
    $.post("dirs/bank/actions/save_branchbank.php", {
        Branch : Branch,
        Bank : Bank,
        AccountName : AccountName,
        AccountNumber : AccountNumber,
        Corporation : Corporation,
        Bankownership : Bankownership,
        Corpcode : Corpcode,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Bank added.");
            $("#mld-create-bank").modal("hide");
            load_Banks();
        }else{
            alert("Error: " + data);
        }
    });
}

function mdlCreateCorpobank() {
    $("#mld-corpo-bank").modal("show");
}


/*Create corporate bank*/
function saveCorpbank(){
    var Branch              = $("#create-branchcorp").val();
    var Bank                = $("#create-bankcorp").val();
    var AccountName         = $("#create-accountnamecorp").val();
    var AccountNumber       = $("#create-accountnumbercorp").val();
    var Corporation         = $("#create-corpotypecorp").val();
    var Bankownership       = 'CORP';
    var Corpcode = '';
    if (Corporation === 'VIC IMPERIAL APPLIANCE CORPORATION') {
        Corpcode = 'VIAC';
    } else if (Corporation === 'NOLU MARKETING CORPORATION') {
        Corpcode = 'NOLU';
    } else if (Corporation === 'ALPHAMIN COMMERCIAL CORPORATION') {
        Corpcode = 'ACC';
    } else if (Corporation === 'SOLU TRADING CORPORATION') {
        Corpcode = 'SOLU';
    }
    $.post("dirs/bank/actions/save_corpobank.php", {
        Branch : Branch,
        Bank : Bank,
        AccountName : AccountName,
        AccountNumber : AccountNumber,
        Corporation : Corporation,
        Bankownership : Bankownership,
        Corpcode : Corpcode,
    }, function(data){
        if($.trim(data) == "OK"){
            console.log("Bank added.");
            $("#mld-corpo-bank").modal("hide");
            load_Banks();
        }else{
            alert("Error: " + data);
        }
    });
}


// Function add transfer bank account
function addTransferBank() {
    $("#mdl-add-bnktransfer").modal('show');
}


/*Function Update Bank Transfer Account*/

$("#frm-add-banktransfer").submit(function(event){
    event.preventDefault();

    var Corporation   = $("#bt-corpotype").val();
    var Bank          = $("#bt-bank").val();
    var Accountname   = $("#bt-bankaccountname").val();
    var Accountnumber = $("#bt-accountnumber").val();

    var CorpMap = {
        'VIC IMPERIAL APPLIANCE CORPORATION': 'VIAC',
        'NOLU MARKETING CORPORATION': 'NOLU',
        'ALPHAMIN COMMERCIAL CORPORATION': 'ACC',
        'SOLU TRADING CORPORATION': 'STC'
    };

    var Corpcode = CorpMap[Corporation.toUpperCase()] || '';

    $.post("dirs/bank/actions/save_banktransfer.php", {
        Corporation,
        Bank,
        Accountname,
        Accountnumber,
        Corpcode
    }, function(data){
        if($.trim(data) === "OK") {
            $("#mdl-add-bnktransfer").modal('hide');
            $("#frm-add-banktransfer")[0].reset();
            load_Banks();
            alert('Save successful');
        } else {
            alert(data);
        }
    });
});



/*Function Edit Bank Transfer Account*/
function editBank(RowNum){
    $("#mdl-add-bnktransfer").modal('show');
    $.post("dirs/bank/actions/get_banktransfer.php",{
        RowNum : RowNum
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#btn-save").addClass('d-none').prop('disabled', true);
            $("#btn-edit").removeClass('d-none');
            $("#mdl-title").html('Edit Bank Transfer');
            $("#banktransfer-id").val(response.Data.RowNum);
            $("#bt-bankaccountname").val(response.Data.BankAccountName);
            $("#bt-bank").val(response.Data.Bank);
            $("#bt-accountnumber").val(response.Data.BankAccountNumber);
            $("#bt-corpotype").val(response.Data.Corporation);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function Update Bank Transfer Account*/
function updateBankTransfer() {
    var RowNum = $("#banktransfer-id").val();
    var Corporation = $("#bt-corpotype").val();
    var Bank        = $("#bt-bank").val();
    var Accountname = $("#bt-bankaccountname").val();
    var Accountnumber = $("#bt-accountnumber").val();
    var Corpcode      = '';

    if (Corporation === 'VIC IMPERIAL APPLIANCE CORPORATION') {
        Corpcode = 'VIAC'
    } else if (Corporation === 'NOLU MARKETING CORPORATION') {
        Corpcode = 'NOLU'
    } else if (Corporation === 'ALPHAMIN COMMERCIAL CORPORATION') {
        Corpcode = 'ACC'
    } else if (Corporation === 'SOLU TRADING CORPORATION') {
        Corpcode = 'STC'
    } else {
        Corpcode = ''
    }

    $.post("dirs/bank/actions/update_banktransfer.php", {
        RowNum        : RowNum,
        Corporation   : Corporation,
        Bank          : Bank,
        Accountname   : Accountname,
        Accountnumber : Accountnumber,
        Corpcode      : Corpcode,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            $("#mdl-add-bnktransfer").modal('hide');
            load_Banks(); 
            alert('Update successful');
        } else {
            alert(data);
        }
    });
}

/*Functio to  get  the rtownumber*/
function deleteBank(RowNum){
    $("#mld-del-transferbank").modal('show');
    $.post("dirs/bank/actions/get_banktransfer.php",{
        RowNum : RowNum
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#banktransfer-id").val(response.Data.RowNum);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}

/*Function to delete bank*/
function delTransferBank(){
    var RowNum = $("#banktransfer-id").val();
    $.post("dirs/bank/actions/delete_banktransfer.php", {
        RowNum : RowNum
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#mld-del-transferbank").modal('hide');
            load_Banks();
            alert('Delete success');   
        }else{
            alert(data); 
        }
    });
}
