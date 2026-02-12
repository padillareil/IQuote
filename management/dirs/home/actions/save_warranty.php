<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin  = $_SESSION['UserName'];

// Get branch code
$Admindtls = $conn->prepare("SELECT Bcode FROM USR WHERE UserName = ?");
$Admindtls->execute([$Admin]);
$row = $Admindtls->fetch(PDO::FETCH_ASSOC);
$Bcode = $row ? $row['Bcode'] : null;

// Warranties array from POST
$WarrantyArray = $_POST['Warranty'];

try {
    $conn->beginTransaction();

    // Generate QNumber
    $branchCode = $Bcode; // from session
    $year  = date("Y");
    $month = date("m");
    $day   = date("d");

    // Get last 3-digit counter globally for this branch
    $query_last_global_number = $conn->prepare(
        "SELECT MAX(CAST(SUBSTRING_INDEX(QNumber, '-', -1) AS UNSIGNED)) AS max_counter 
         FROM warranty 
         WHERE QNumber LIKE ?"
    );
    $likePattern = $branchCode . "%";  
    $query_last_global_number->execute([$likePattern]);
    $result = $query_last_global_number->fetch(PDO::FETCH_ASSOC);
    $last_global_counter = isset($result['max_counter']) ? (int)$result['max_counter'] : 0;
    $new_global_counter = $last_global_counter + 1;
    if ($new_global_counter > 999) {
        $new_global_counter = 1;
    }
    $formatted_counter = str_pad($new_global_counter, 3, "0", STR_PAD_LEFT);
    $quotationNumber = sprintf("%s%s%s%s-%s", $branchCode, $year, $month, $day, $formatted_counter);


    $ins_warranty = $conn->prepare("INSERT INTO warranty (WRRNTY, UserName, QNumber) VALUES (?, ?, ?)");
    foreach($WarrantyArray as $w) {
        $w = trim($w);
        if($w !== "") {
            $ins_warranty->execute([$w, $Admin, $quotationNumber]);
        }
    }

    $conn->commit();
    echo "OK";

} catch(PDOException $e) {
    $conn->rollback();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
