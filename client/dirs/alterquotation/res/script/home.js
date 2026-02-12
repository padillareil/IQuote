$(document).ready(function(){
    loadHome();
});


function loadHome() {
    $.post("dirs/home/components/home.php", {
    }, function (data){
        $("#load_home").html(data);
        loadAllBranch();
        loadInstallment();
        loadDownpayment();
        loadCustomers();
    });
}


/*Function for next form*/
function loadForm2() {
    $('a[href="#payment"]').tab('show');
    $("#other-fields").removeClass('d-none');
 
}


/*Function return form 1*/
function returnForm1() {
    $('a[href="#customer"]').tab('show');
    resetPage2fields();
}


/*Function for next form*/
function loadForm3() {
    $('a[href="#order"]').tab('show');
}


/*Function return form 1*/
function returnForm2() {
    $('a[href="#payment"]').tab('show');
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


function mdlSubmit() {
    $("#mdl-submit").modal("show");
}




/*Function modal for Manual Discount*/
/*function loadMauanDiscount() {
    $("#mdl-manual-discount").modal("show");
}*/


function loadAllBranch() {
    $.post("dirs/home/actions/get_branchuser.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var branches = response.Data;
            var $branch = $("#branch");
            $branch.empty();
            $branch.append('<option selected disabled>Select Branch</option>');

            branches.forEach(function(branch) {
                $branch.append('<option value="' + $.trim(branch.BranchName) + '">' + branch.BranchName + '</option>');
            });

            $branch.off("change").on("change", function() {
                var selectedBranch = $(this).val();
                $("#bank").empty().append('<option selected disabled>Select Bank</option>');
                $("#bank-accountname").val('');
                $("#bank-accountnumber").val('');
                loadCorpCode(selectedBranch);
            });

        } else {
            alert($.trim(response.Data));
        }
    });
}


/*Function fetch all Installment*/
function loadInstallment() {
    $.post("dirs/home/actions/get_installment.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var installments = response.Data;
            var $select = $("#installment-period");
            $select.empty();
            $select.append('<option selected disabled></option>');

            installments.forEach(function(instllment) {
                var text = instllment.PayTerm + " - " + instllment.PayPeriod;
                $select.append(
                    '<option value="' + text + '">' + text + '</option>'
                );
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}



/* Function fetch all downpayment */
function loadDownpayment() {
    $.post("dirs/home/actions/get_dwnpayment.php", {}, function(data) {
        var response = JSON.parse(data);
        if ($.trim(response.isSuccess) === "success") {
            var downpayment = response.Data;
            var $select = $("#downpayment-select");
            $select.empty();
            $select.append('<option selected disabled></option>');

            downpayment.forEach(function(item) {
                var text = item.DPayment; // the displayed text
                $select.append(
                    '<option value="' + $.trim(item.DPayment).toLowerCase() + '">' + text + '</option>'
                );
            });
        } else {
            alert($.trim(response.Data));
        }
    });
}

/*Function load corpcode*/
function loadCorpCode(BranchName){
    $.post("dirs/home/actions/get_corpcode.php", { Branch: BranchName }, function(data){
        var response = JSON.parse(data);

        if($.trim(response.isSuccess) == "success"){
            $("#corporation-branch").val(response.Data.CompanyCode);
            var CustomerType  = $("#customertype").val();
            if (CustomerType === 'Corporate') {
                loadBankCorporate_check();
                loadBankCorporate_trasnfer();
            } else if (CustomerType === 'Personal') {
                loadBankPersonal_check();
                loadBankPersonal_transfer();
            }
        } else {
            alert($.trim(response.Data));
        }
    });
}


/*Bank Check account*/
function loadBankCorporate_check(){
    var Corpcode = $("#corporation-branch").val();
    $.post("dirs/home/actions/get_bankcorpo.php", {
        Corpcode: Corpcode
    }, function(data){
        let response = JSON.parse(data);

        if ($.trim(response.isSuccess) == "success") {
            let $bankSelect = $("#bank");
            $bankSelect.empty();
            $bankSelect.append('<option selected disabled>Select Bank</option>');

            $.each(response.Data, function(index, item){
                $bankSelect.append(
                    $("<option>", {
                        value: item.Bank,  
                        text: item.Bank,   
                        "data-accountname": item.AccountName,
                        "data-accountnumber": item.AccountNumber
                    })
                );
            });
            $bankSelect.off('change').on('change', function(){
                let selected = $(this).find("option:selected");
                $("#bank-accountname").val(selected.data("accountname"));
                $("#bank-accountnumber").val(selected.data("accountnumber"));
            });

        } else {
            alert($.trim(response.Data));
        }
    });
}


function loadBankPersonal_check(){
    var Branch = $("#branch").val();
    $.post("dirs/home/actions/get_bankpersonal.php", {
        Branch: Branch
    }, function(data){
        let response = JSON.parse(data);

        if ($.trim(response.isSuccess) == "success") {
            let $bankSelectbranch = $("#bank");
            $bankSelectbranch.empty();
            $bankSelectbranch.append('<option selected disabled>Select Bank</option>');

            $.each(response.Data, function(index, item){
                $bankSelectbranch.append(
                    $("<option>", {
                        value: item.Bank,  
                        text: item.Bank,   
                        "data-accountname": item.AccountName,
                        "data-accountnumber": item.AccountNumber
                    })
                );
            });
            $bankSelectbranch.off('change').on('change', function(){
                let selected = $(this).find("option:selected");
                $("#bank-accountname").val(selected.data("accountname"));
                $("#bank-accountnumber").val(selected.data("accountnumber"));
            });

        } else {
            alert($.trim(response.Data));
        }
    });
}



/*Bank Transfer Corpo account*/
function loadBankCorporate_trasnfer(){
    var Corpcode = $("#corporation-branch").val();
    $.post("dirs/home/actions/get_bankcorpo.php", {
        Corpcode: Corpcode
    }, function(data){
        let response = JSON.parse(data);

        if ($.trim(response.isSuccess) == "success") {
            let $bankSelect = $("#transfer-bank");
            $bankSelect.empty();
            $bankSelect.append('<option selected disabled>Select Bank</option>');

            $.each(response.Data, function(index, item){
                $bankSelect.append(
                    $("<option>", {
                        value: item.Bank,  
                        text: item.Bank,   
                        "data-accountname": item.AccountName,
                        "data-accountnumber": item.AccountNumber
                    })
                );
            });
            $bankSelect.off('change').on('change', function(){
                let selected = $(this).find("option:selected");
                $("#transfer-bank-accountname").val(selected.data("accountname"));
                $("#transfer-bank-accountnumber").val(selected.data("accountnumber"));
            });

        } else {
            alert($.trim(response.Data));
        }
    });
}

/*Function fetch bank trasnfer personal*/
function loadBankPersonal_transfer(){
    $.post("dirs/home/actions/get_bankpersonaltransfer.php", {
    }, function(data){
        let response = JSON.parse(data);
        if ($.trim(response.isSuccess) == "success") {
            let $bankSelectbranch = $("#transfer-bank");
            $bankSelectbranch.empty();
            $bankSelectbranch.append('<option selected disabled>Select Bank</option>');

            $.each(response.Data, function(index, item){
                $bankSelectbranch.append(
                    $("<option>", {
                        value: item.Bank,  
                        text: item.Bank,   
                        "data-accountname": item.AccountName,
                        "data-accountnumber": item.AccountNumber
                    })
                );
            });
            $bankSelectbranch.off('change').on('change', function(){
                let selected = $(this).find("option:selected");
                $("#transfer-bank-accountname").val(selected.data("accountname"));
                $("#transfer-bank-accountnumber").val(selected.data("accountnumber"));
            });

        } else {
            alert($.trim(response.Data));
        }
    });
}



/*function reset second page*/
function resetPage2fields() {
    $("#mode-payment").val("Cash");
    $("#branch").val("");
    $("#bank").val("");
    $("#bank-accountname").val("");
    $("#bank-accountnumber").val("");
    $("#transfer-bank").val("");
    $("#transfer-bank-accountname").val("");
    $("#transfer-bank-accountnumber").val("");
    $("#installment-period").val("");
    $("#downpayment-select").val("");
    $("#installment, #downpayment, #checkterms, #accountnumber-check, #accountname-check, #banktransfer, #accountnumber-form, #accountname-form")
        .addClass("d-none");
}




/*Function submit Quotaion*/
/*function save_quotaion() {
    var Customer     = $("#customer-name").val();
    var Contact      = $("#contactnumber").val();
    var Tin          = $("#tinumber").val();
    var CustomerType = $("#customertype").val();
    var Company      = "";

    if (CustomerType === "Corporate") {
        Company = $("#companyname").val();
    } else if (CustomerType === "Personal") {
        Company = "Personal";
    }  

    var Bank = "";
    var AccountName = "";
    var AccountNumber = "";
    if ($("#bank-accountname").length && $("#bank-accountname").val()) {
        Bank = $("#bank option:selected").val();
        AccountName = $("#bank-accountname").val();
        AccountNumber = $("#bank-accountnumber").val();
    }
    if ($("#transfer-bank-accountname").length && $("#transfer-bank-accountname").val()) {
        Bank = $("#transfer-bank option:selected").val();
        AccountName = $("#transfer-bank-accountname").val();
        AccountNumber = $("#transfer-bank-accountnumber").val();
    }

    var PaymentMode = $("#mode-payment").val();
    var Installment = $("#installment-period").val();
    var Downpayment = $("#downpayment-select").val();


    var Province      = $("#province option:selected").text();
    var Municipality  = $("#municipality option:selected").text();
    var Barangay      = $("#barangay option:selected").text();
    var Street       = $("#street").val();
    var Zipcode      = $("#zipcode").val();
    var Landmark     = $("#landmark").val();
    var Branch       = $("#branch").val();
    var Remarks      = $("#remarks").val();
    var GrandTotal      = $("#grandtotal").val();
    var DeliveryCharge  = $("#deliverycharge").val();

    var Code        = $("#provincecode").val();
    var PRVCode     = $("#municipalcode").val();
    var TCCode      = $("#barangaycode").val();
    $.post("dirs/home/actions/save_quotation.php", {
        Customer     : Customer,
        Contact      : Contact,
        Tin          : Tin,
        Company      : Company,
        Province     : Province,
        Municipality : Municipality,
        Barangay     : Barangay,
        Street       : Street,
        Zipcode      : Zipcode,
        Landmark     : Landmark,
        Branch       : Branch,
        Remarks      : Remarks,
        GrandTotal      : GrandTotal,
        DeliveryCharge  : DeliveryCharge,
        Bank : Bank,
        AccountName : AccountName,
        AccountNumber : AccountNumber,
        PaymentMode : PaymentMode,
        Installment : Installment,
        Downpayment : Downpayment,
        Code : Code,
        PRVCode : PRVCode,
        TCCode : TCCode,
    }, function(data){
        if($.trim(data) == "OK"){
            save_orders();
            save_termscondition();
            save_warranty();
        } else {
            alert("Error: " + data);
        }
    });
}*/

/*Function submit orders*/
/*function save_orders() {
    var brand = [];
    var model = []; // singular
    var category = [];
    var itemcode = [];
    var sellingprice = [];
    var pricelimit = [];
    var quantity = [];
    var discountperunit = [];
    var discountedamountperunit = [];
    var grosstotal = [];
    var manualdiscount = [];

    $(".order-form").each(function() {
        brand.push($(this).find(".brand").val());
        model.push($(this).find(".model").val()); // corrected
        category.push($(this).find(".category").val());
        itemcode.push($(this).find(".itemcode").val());
        sellingprice.push($(this).find(".sellingprice").val());
        pricelimit.push($(this).find(".price-limit").val());
        quantity.push($(this).find(".quantity").val());
        discountperunit.push($(this).find(".discountperunit").val());
        discountedamountperunit.push($(this).find(".discountedamountperunit").val());
        grosstotal.push($(this).find(".grosstotal").val());
        manualdiscount.push($(this).find(".manualdiscount").val());
    });

    $.post("dirs/home/actions/save_order.php", {
        Brand           : brand,
        Model           : model,
        Category        : category,
        Itemcode        : itemcode,
        Sellingprice    : sellingprice,
        Pricelimit      : pricelimit,
        Quantity        : quantity,
        Discountperunit : discountperunit,
        Discountedamountperunit     : discountedamountperunit,
        GrossTotal      : grosstotal,
        ManualDiscount  : manualdiscount
    }, function(data){
        if($.trim(data) == "OK"){
            loadHome();
        } else {
            alert("Error: " + data);
        }
    });
}*/

/*Save Terms and Condition*/
/*function save_termscondition() {
    var Termscondition = [];
    $(".termscondition").each(function() {
        var val = $(this).val().trim();
        if (val !== "") {       
            Termscondition.push(val);
        }
    });

    $.post("dirs/home/actions/save_condition.php", {
        Termscondition: Termscondition,
    }, function(data){
        if($.trim(data) == "OK"){
        } else {
            alert("Error: " + data);
        }
    });
}
*/
/*Save Warranty*/
/*function save_warranty() {
    var Warranty = [];
    $(".warranty").each(function() {
        var val = $(this).val().trim();
        if (val !== "") {       
            Warranty.push(val);
        }
    });
    $.post("dirs/home/actions/save_warranty.php", {
        Warranty: Warranty,
    }, function(data){
        if($.trim(data) == "OK"){
            // optionally do something on success
        } else {
            alert("Error: " + data);
        }
    });
}
*/

function save_quotaion() {
    var Customer     = $("#customer-name").val();
    var Contact      = $("#contactnumber").val();
    var Tin          = $("#tinumber").val();
    var CustomerType = $("#customertype").val();
    var Company      = CustomerType === "Corporate" ? $("#companyname").val() : "Personal";
    var Bank = "", AccountName = "", AccountNumber = "";
    if ($("#bank-accountname").length && $("#bank-accountname").val()) {
        Bank = $("#bank option:selected").val();
        AccountName = $("#bank-accountname").val();
        AccountNumber = $("#bank-accountnumber").val();
    } else if ($("#transfer-bank-accountname").length && $("#transfer-bank-accountname").val()) {
        Bank = $("#transfer-bank option:selected").val();
        AccountName = $("#transfer-bank-accountname").val();
        AccountNumber = $("#transfer-bank-accountnumber").val();
    }
    var PaymentMode = $("#mode-payment").val();
    var Installment = $("#installment-period").val();
    var Downpayment = $("#downpayment-select").val();
    var Province      = $("#province option:selected").text();
    var Municipality  = $("#municipality option:selected").text();
    var Barangay      = $("#barangay option:selected").text();
    var Street        = $("#street").val();
    var Zipcode       = $("#zipcode").val();
    var Landmark      = $("#landmark").val();
    var Branch        = $("#branch").val();
    var Remarks       = $("#quote-remarks").val();
    var GrandTotal    = $("#grandtotal").val();
    var DeliveryCharge= $("#deliverycharge").val();
    var Code   = $("#provincecode").val();
    var PRVCode= $("#municipalcode").val();
    var TCCode = $("#barangaycode").val();
    var Orders = [];
    $(".order-form").each(function() {
        Orders.push({
            Brand: $(this).find(".brand").val(),
            Model: $(this).find(".model").val(),
            Category: $(this).find(".category").val(),
            Itemcode: $(this).find(".itemcode").val(),
            Sellingprice: $(this).find(".sellingprice").val(),
            Pricelimit: $(this).find(".price-limit").val(),
            Quantity: $(this).find(".quantity").val(),
            Discountperunit: $(this).find(".discountperunit").val(),
            Discountedamountperunit: $(this).find(".discountedamountperunit").val(),
            GrossTotal: $(this).find(".grosstotal").val(),
            ManualDiscount: $(this).find(".manualdiscount").val()
        });
    });
    var Termscondition = [];
    $(".termscondition").each(function() {
        var val = $(this).val().trim();
        if (val !== "") Termscondition.push(val);
    });

    var Warranty = [];
    $(".warranty").each(function() {
        var val = $(this).val().trim();
        if (val !== "") Warranty.push(val);
    });

    $.ajax({
        url: "dirs/home/actions/save_quotation.php",
        type: "POST",
        data: {
            Customer: Customer,
            Contact: Contact,
            Tin: Tin,
            Company: Company,
            Province: Province,
            Municipality: Municipality,
            Barangay: Barangay,
            Street: Street,
            Zipcode: Zipcode,
            Landmark: Landmark,
            Branch: Branch,
            Remarks: Remarks,
            GrandTotal: GrandTotal,
            DeliveryCharge: DeliveryCharge,
            Bank: Bank,
            AccountName: AccountName,
            AccountNumber: AccountNumber,
            PaymentMode: PaymentMode,
            Installment: Installment,
            Downpayment: Downpayment,
            Code: Code,
            PRVCode: PRVCode,
            TCCode: TCCode,
            Orders: JSON.stringify(Orders),
            Termscondition: JSON.stringify(Termscondition),
            Warranty: JSON.stringify(Warranty)
        },
        success: function(res) {
            if($.trim(res) === "OK") {
                console.log("Quotation saved successfully!");
                loadHome();
            } else {
                alert("Error: " + res);
            }
        },
        error: function(xhr, status, err) {
            alert("AJAX error: " + err);
        }
    });

}


/*Fetch customers*/
function loadCustomers() {
    $.post("dirs/home/actions/get_customer.php", {}, function(data) {
        let response = JSON.parse(data);

        if ($.trim(response.isSuccess) === "success") {
            let $customerSelect = $("#prev-customers");
            $customerSelect.empty();
            $customerSelect.append('<option selected disabled>Select Customer</option>');

            $.each(response.Data, function(index, item) {
                $customerSelect.append(
                    $("<option>", {
                        value: item.Customer,      
                        text: item.Customer,       
                        "data-contact": item.ContactNumber,
                        "data-tin": item.TIN,
                        "data-company": item.Company,
                        "data-province": item.Province,
                        "data-municipality": item.Municipality,
                        "data-barangay": item.Barangay,
                        "data-street": item.Street,
                        "data-zipcode": item.ZipCode,
                        "data-landmark": item.Landmark,
                        "data-provincecode": item.Code,
                        "data-municipalitycode": item.PRVCode,
                        "data-barangaycode": item.TCode
                    })
                );
            });

            $customerSelect.off("change").on("change", function() {
                let selected = $(this).find("option:selected");

                $("#customer-name").val(selected.text()); 
                $("#contactnumber").val(selected.data("contact"));
                $("#tinumber").val(selected.data("tin"));

                // Company logic
                if (selected.data("company") === "Personal") {
                    // Personal customer
                    $("#customertype").val("Personal");
                    $("#customer-company").addClass("d-none"); 
                    $("#customer-company input").val("");      
                } else {
                    // Corporate customer
                    $("#customertype").val("Corporate");
                    $("#customer-company").removeClass("d-none"); 
                    $("#customer-company input").val(selected.data("company")); 
                }


                // Province
                var provinceVal = selected.data("province");
                $("#province").empty().append(
                    $("<option>", { value: provinceVal, text: provinceVal, selected: true })
                );

                // Municipality
                var municipalityVal = selected.data("municipality");
                $("#municipality").empty().append(
                    $("<option>", { value: municipalityVal, text: municipalityVal, selected: true })
                );

                // Barangay
                var barangayVal = selected.data("barangay");
                $("#barangay").empty().append(
                    $("<option>", { value: barangayVal, text: barangayVal, selected: true })
                );

                // Other address fields
                $("#street").val(selected.data("street"));
                $("#zipcode").val(selected.data("zipcode"));
                $("#landmark").val(selected.data("landmark"));

                // Hidden codes (if you use them later)
                $("#provincecode").val(selected.data("provincecode"));
                $("#municipalcode").val(selected.data("municipalitycode"));
                $("#barangaycode").val(selected.data("barangaycode"));
            });


        } else {
            alert($.trim(response.Data));
        }
    });
}
