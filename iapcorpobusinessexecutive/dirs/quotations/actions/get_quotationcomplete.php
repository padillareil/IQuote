<?php
session_start();
require_once "../../../../config/local_db.php";

$QNUMBER = $_POST['QNUMBER'];
$response = array();

try {


    date_default_timezone_set('Asia/Manila');
    $CommitDate  = date('Y-m-d');
    $CreatedTime = date('H:i:s');
    $Software    = 'IQUOTE';
    $Action      = "Review Quotation - $QNUMBER";
    $Admin    = $_SESSION['UserName']; 


    // Get client and user details
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];

    // --- Audit Log ---
    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);

    $stmt = $conn->prepare("EXEC dbo.[COMPLETEQUOTE_PROCEDURE] ?;");
    $stmt->execute([$QNUMBER]);

    // --- 1st Result: Quotation Header ---
    $header = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$header) {
        throw new Exception("No quotation found.");
    }

    $customer = array(
        "Customer"      => $header["Customer"],
        "TIN"           => $header["TIN"],
        "Status"        => $header["Status"],
        "Company"       => $header["Company"],
        "CustomerType"       => $header["CustomerType"] ?? '',
        "Province"      => $header["Province"],
        "Municipality"  => $header["Municipality"],
        "Barangay"      => $header["Barangay"],
        "Street"        => $header["Street"],
        "ZipCode"       => $header["ZipCode"],
        "Name"          => $header["Name"],
        "Position"      => $header["Position"],
        "QNumber"       => $header["QNumber"],
        "Branch"        => $header["Branch"],
        "UserName"      => $header["UserName"],
        "Landmark"      => $header["Landmark"],
        "CreatedDate"   => $header["CreatedDate"],
        "PTERMS"        => $header["PTERMS"],
        "BANK"          => $header["BANK"],
        "ACCOUNTNAME"   => $header["ACCOUNTNAME"],
        "ACCNUM"        => $header["ACCNUM"],
        "TERMS"         => $header["TERMS"],
        "Remarks"       => $header["Remarks"],
        "Downpayment"   => $header["Downpayment"],
        "ContactNumber" => $header["ContactNumber"],
        "DeliveryCharge"=> $header["DeliveryCharge"],
        "GrandTotal"    => $header["GrandTotal"],
        "Orders"        => [],
        "Terms"         => [],
        "Warranties"    => []
    );

    // --- 2nd Result: Orders ---
    if ($stmt->nextRowset()) {
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($orders as $row) {
            $customer["Orders"][] = array(
                "ORDR_ID"         => $row["ORDR_ID"],
                "Brand"           => $row["Brand"],
                "Model"           => $row["Model"],
                "SellingPrice"    => $row["SellingPrice"],
                "CATEGORY"        => $row["CATEGORY"],
                "Quantity"        => $row["Quantity"],
                "DiscountedAmount"=> $row["DiscountedAmount"],
                "Discount"        => $row["Discount"],
                "TotalAmount"     => $row["TotalAmount"],
                "ManualDiscount"  => ($row["ManualDiscount"] == 0 ? "" : $row["ManualDiscount"]),
                "PriceLimit"      => $row["PriceLimit"],
                "PriceLimitSum"   => $row["PriceLimitSum"]
            );
        }
    }

    // --- 3rd Result: Terms ---
    if ($stmt->nextRowset()) {
        $terms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($terms as $row) {
            $customer["Terms"][] = array(
                "TRMS_ID"        => $row["TRMS_ID"],
                "TermsCondition" => $row["TermsCondition"]
            );
        }
    }

    // --- 4th Result: Warranties ---
    if ($stmt->nextRowset()) {
        $warranties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($warranties as $row) {
            $customer["Warranties"][] = array(
                "WRRNTY_ID" => $row["WRRNTY_ID"],
                "Warranty"  => $row["Warranty"]
            );
        }
    }

    $response = array(
        "isSuccess" => "success",
        "Data" => $customer
    );

} catch (Exception $e) {
    $response = array(
        "isSuccess" => "Failed",
        "Data" => "<b>Error:</b> " . $e->getMessage()
    );
}

header('Content-Type: application/json');
echo json_encode($response);

?>
