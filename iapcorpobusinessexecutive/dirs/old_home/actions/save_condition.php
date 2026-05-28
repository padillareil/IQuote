<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin  = $_SESSION['UserName'];

// Get branch code
$Admindtls = $conn->prepare("SELECT Bcode FROM USR WHERE UserName = ?");
$Admindtls->execute([$Admin]);
$row = $Admindtls->fetch(PDO::FETCH_ASSOC);
$Bcode = $row ? $row['Bcode'] : null;

// Terms & Conditions array from POST
$TermsArray = $_POST['Termscondition'];

try {
    $conn->beginTransaction();

    $branchCode = $Bcode; // from session
    $year  = date("Y");
    $month = date("m");
    $day   = date("d");

    // Get last 3-digit counter globally for this branch
    $query_last_global_number = $conn->prepare(
        "SELECT MAX(CAST(SUBSTRING_INDEX(QNumber, '-', -1) AS UNSIGNED)) AS max_counter 
         FROM terms 
         WHERE QNumber LIKE ?"
    );
    $likePattern = $branchCode . "%";  // all numbers for this branch
    $query_last_global_number->execute([$likePattern]);
    $result = $query_last_global_number->fetch(PDO::FETCH_ASSOC);

    $last_global_counter = isset($result['max_counter']) ? (int)$result['max_counter'] : 0;
    $new_global_counter = $last_global_counter + 1;

    // Reset if exceeds 999
    if ($new_global_counter > 999) {
        $new_global_counter = 1;
    }
    // Format counter as 3 digits
    $formatted_counter = str_pad($new_global_counter, 3, "0", STR_PAD_LEFT);
    // Final quotation number: branch + YYYYMMDD + 3-digit counter
    $quotationNumber = sprintf("%s%s%s%s-%s", $branchCode, $year, $month, $day, $formatted_counter);

    // Insert each term as a separate row
    $ins_termscondition = $conn->prepare("INSERT INTO terms (TRMS, UserName, QNumber) VALUES (?, ?, ?)");
    foreach($TermsArray as $t) {
        $t = trim($t);
        if($t !== "") {
            $ins_termscondition->execute([$t, $Admin, $quotationNumber]);
        }
    }

    $conn->commit();
    echo "OK";

} catch(PDOException $e) {
    $conn->rollback();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
