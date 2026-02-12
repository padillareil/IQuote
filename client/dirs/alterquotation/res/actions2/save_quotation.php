<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin = $_SESSION['UserName'];

// Fetch user info
$Admindtls = $conn->prepare("SELECT Signature, Name, Bcode, Branch, Corporation, UPosition, UserName, Region FROM USR WHERE UserName = ?");
$Admindtls->execute([$Admin]);
$row = $Admindtls->fetch(PDO::FETCH_ASSOC);

$Signature     = $row['Signature'];
$Name          = $row['Name'];
$Bcode         = $row['Bcode'];
$UserBranch    = $row['Branch'];
$Corpo         = $row['Corporation'];
$Position      = $row['UPosition'];
$Region        = $row['Region'];


$Customer   = $_POST['Customer'];
$Contact    = $_POST['Contact'];
$Tin        = $_POST['Tin'];
$Company    = $_POST['Company'];
$Province   = $_POST['Province'];
$Municipality = $_POST['Municipality'];
$Barangay = preg_replace('/\s+/', ' ', trim($_POST['Barangay']));
$Street     = $_POST['Street'];
$Zipcode    = $_POST['Zipcode'];
$Landmark   = $_POST['Landmark'];
$Branch     = $_POST['Branch'];
$Remarks    = $_POST['Remarks'];
$GrandTotal = str_replace(',', '', $_POST['GrandTotal']);
$DeliveryCharge = (float) str_replace(',', '', $_POST['DeliveryCharge'] ?? 0);
$Bank          = $_POST['Bank'];
$AccountName   = $_POST['AccountName'];
$AccountNumber = $_POST['AccountNumber'];
$PaymentMode   = $_POST['PaymentMode'];
$Installment   = $_POST['Installment'];
$Downpayment   = $_POST['Downpayment'];
$Code             = $_POST['Code'];
$PRVCode          = $_POST['PRVCode'];
$TCCode           = $_POST['TCCode'];
$PrintStatus   = 0;
$QSTATUS       = 'PENDING';

// Decode JSON arrays
$OrdersArray   = json_decode($_POST['Orders'] ?? '[]', true);
$TermsArray    = json_decode($_POST['Termscondition'] ?? '[]', true);
$WarrantyArray = json_decode($_POST['Warranty'] ?? '[]', true);

try {
    $conn->beginTransaction();


    $Contactnumber = $conn->prepare("SELECT Telephone, Mobile FROM contacts WHERE Branch = ?");
    $Contactnumber->execute([$Branch]);
    $row = $Contactnumber->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $Landline = $row['Telephone'];
        $Mobile      = $row['Mobile'];
    }


    /*Fetch Corporate Bank*/
    $CorporateBankaccount = $conn->prepare("SELECT Bank, AccName, AccNumber FROM bnk WHERE BnkOwnership = 'CORP' AND Corpcode = ?");
    $CorporateBankaccount->execute([$Corpo]);
    $row = $CorporateBankaccount->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $CorporateBank          = $row['Bank'];
        $CorporateAccountName   = $row['AccName'];
        $CorporateAccNumber     = $row['AccNumber'];
    }


    /*Fetch Branch Bank*/
    $BranchBankAccount = $conn->prepare("SELECT Bank, AccName, AccNumber FROM bnk WHERE BnkOwnership = 'BRNCH' AND Branch = ?");
    $BranchBankAccount->execute([$UserBranch]);
    $row = $BranchBankAccount->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $BranchBank          = $row['Bank'];
        $BranchAccountName   = $row['AccName'];
        $BranchAccNumber     = $row['AccNumber'];
    }

    /*Fetch Branch*/
    $BranchDetail = $conn->prepare("SELECT Address FROM branches WHERE Branch = ?");
    $BranchDetail->execute([$Branch]);
    $row = $BranchDetail->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $Address          = $row['Address'];
    }



    // 1. Insert quotation (without QNumber)
    $stmt = $conn->prepare("INSERT INTO QTATION 
        (
            CSTMER, 
            CNUMBER,
            TIN,
            CMPNY, 
            PVINCE,
            MUNICPLTY,
            BRGY,
            STRT, 
            ZIPCODE,
            Landmark,
            Branch,
            RMARKS,
            Name,
            PSignature,
            CREATED_DATE,
            GTOTAL,
            DCHARGE,
            PTERMS,
            BANK,
            ACCOUNTNAME,
            ACCNUM,
            TERMS,
            DWNPYMENT,
            Landline,
            Mobile,
            CorpBank,
            CorpAccountName,
            CorpAccountNumber,
            CashBank,
            CashAccountName,
            CashAccountNumber,
            Position,
            Bcode,
            UserName,
            Region,
            Corpcode,
            BranchAddress,
            PRINTSTATUS,
            QSTATUS
            )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $Customer, 
        $Contact,
        $Tin,
        $Company, 
        $Province,
        $Municipality,
        $Barangay,
        $Street, 
        $Zipcode,
        $Landmark,
        $Branch,   
        $Remarks,
        $Name,
        $Signature,
        $GrandTotal,
        $DeliveryCharge,
        $PaymentMode,
        $Bank,
        $AccountName,
        $AccountNumber,
        $Installment,
        $Downpayment,
        $Landline,
        $Mobile,
        $CorporateBank,
        $CorporateAccountName,
        $CorporateAccNumber,
        $BranchBank,
        $BranchAccountName,
        $BranchAccNumber,
        $Position,
        $Bcode,
        $Admin,
        $Region,
        $Corpo,
        $Address,
        $PrintStatus,
        $QSTATUS
    ]);

    // Generate QNumber: Bcode + YYYYMMDD + sequential ID
    $v_qid = $conn->lastInsertId();
    $quotationNumber = $Bcode . date('Ymd') . '-' . str_pad($v_qid, 3, '0', STR_PAD_LEFT);

    // Update quotation with generated QNumber
    $upd = $conn->prepare("UPDATE QTATION SET QNumber = ? WHERE QID = ?");
    $upd->execute([$quotationNumber, $v_qid]);


    $ins_customer = $conn->prepare("INSERT INTO CUSDTLS (
        CSTMER, 
        CNUMBER, 
        TIN, 
        CMPNY, 
        PVINCE, 
        MUNICPLTY, 
        BRGY, 
        STRT, 
        ZipCode, 
        Landmark,
        UserName,
        Code,
        PRVCode,
        TCCode,
        QNumber
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $ins_customer->execute([
        $Customer,
        $Contact,
        $Tin,
        $Company,
        $Province,
        $Municipality,
        $Barangay,
        $Street,
        $Zipcode,
        $Landmark,
        $Admin,
        $Code,
        $PRVCode,
        $TCCode,
        $quotationNumber
    ]);

    // 2. Insert Orders row by row
    $ins_order = $conn->prepare("
        INSERT INTO ordr 
        (BRND, MDL, CATEGORY, ITEMCODE, SRP, FloorPrice, QTY, DSCNT, AMNT, TAMOUNT, ManualDiscount, QNumber, UserName)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($OrdersArray as $order) {
        // Clean and cast numeric fields
        $srp             = (float) str_replace(',', '', $order['Sellingprice'] ?? 0);
        $floorPrice      = (float) str_replace(',', '', $order['Pricelimit'] ?? 0);
        $qty             = (int)   ($order['Quantity'] ?? 0);
        $discount        = (float) str_replace(',', '', $order['Discountperunit'] ?? 0);
        $discAmount      = (float) str_replace(',', '', $order['Discountedamountperunit'] ?? 0);
        $grossTotal      = (float) str_replace(',', '', $order['GrossTotal'] ?? 0);
        $manualDiscount  = (float) str_replace(',', '', $order['ManualDiscount'] ?? 0);

        // Execute insert
        $ins_order->execute([
            $order['Brand']       ?? '',
            $order['Model']       ?? '',
            $order['Category']    ?? '',
            $order['Itemcode']    ?? '',
            $srp,
            $floorPrice,
            $qty,
            $discount,
            $discAmount,
            $grossTotal,
            $manualDiscount,
            $quotationNumber,
            $Admin
        ]);
    }


    // 3. Insert Terms row by row
    $ins_terms = $conn->prepare("INSERT INTO terms (TRMS, UserName, QNumber) VALUES (?, ?, ?)");
    foreach ($TermsArray as $t) {
        $t = trim($t);
        if ($t !== '') $ins_terms->execute([$t, $Admin, $quotationNumber]);
    }

    // 4. Insert Warranty row by row
    $ins_warranty = $conn->prepare("INSERT INTO warranty (WRRNTY, UserName, QNumber) VALUES (?, ?, ?)");
    foreach ($WarrantyArray as $w) {
        $w = trim($w);
        if ($w !== '') $ins_warranty->execute([$w, $Admin, $quotationNumber]);
    }


   

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
?>
