<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin  = $_SESSION['UserName'];
$Admindtls = $conn->prepare("SELECT Bcode FROM USR WHERE UserName = ?");
$Admindtls->execute([$Admin]);
$row = $Admindtls->fetch(PDO::FETCH_ASSOC);

$Bcode = $row ? $row['Bcode'] : null;

// Receive arrays from POST
$Brand                  = $_POST['Brand'];
$Model                  = $_POST['Model'];
$Category               = $_POST['Category'];
$Itemcode               = $_POST['Itemcode'];
$Sellingprice           = $_POST['Sellingprice'];
$Pricelimit             = $_POST['Pricelimit'];
$Quantity               = $_POST['Quantity'];
$Discountperunit         = $_POST['Discountperunit'];
$Discountedamountperunit = $_POST['Discountedamountperunit'];
$GrossTotal             = $_POST['GrossTotal'];
$ManualDiscount         = $_POST['ManualDiscount'];

try {
    $conn->beginTransaction();

    $branchCode = $Bcode; // from session
    $year  = date("Y");
    $month = date("m");
    $day   = date("d");

    // Get last 3-digit counter globally for this branch
    $query_last_global_number = $conn->prepare(
        "SELECT MAX(CAST(SUBSTRING_INDEX(QNumber, '-', -1) AS UNSIGNED)) AS max_counter 
         FROM ordr 
         WHERE QNumber LIKE ?"
    );
    $likePattern = $branchCode . "%";  // all numbers for this branch
    $query_last_global_number->execute([$likePattern]);
    $result = $query_last_global_number->fetch(PDO::FETCH_ASSOC);

    $last_global_counter = isset($result['max_counter']) ? (int)$result['max_counter'] : 0;
    $new_global_counter = $last_global_counter + 1;
    if ($new_global_counter > 999) {
        $new_global_counter = 1;
    }
    $formatted_counter = str_pad($new_global_counter, 3, "0", STR_PAD_LEFT);
    $quotationNumber = sprintf("%s%s%s%s-%s", $branchCode, $year, $month, $day, $formatted_counter);
    $ins_orders = $conn->prepare("
        INSERT INTO ordr (
            BRND, MDL, CATEGORY, ITEMCODE, SRP, FloorPrice,
            QTY, DSCNT, AMNT, TAMOUNT, ManualDiscount, QNumber, UserName
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    // Loop through all items
    $totalItems = count($Brand);
    for ($i = 0; $i < $totalItems; $i++) {
        $ins_orders->execute([
            $Brand[$i],
            $Model[$i],
            $Category[$i],
            $Itemcode[$i],
            $Sellingprice[$i],
            $Pricelimit[$i],
            $Quantity[$i],
            $Discountperunit[$i],
            $Discountedamountperunit[$i],
            $GrossTotal[$i],
            $ManualDiscount[$i],
            $quotationNumber,
            $Admin
        ]);
    }

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollback();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
