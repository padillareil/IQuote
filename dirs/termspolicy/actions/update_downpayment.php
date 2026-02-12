<?php
require_once "../../../config/local_db.php";

$DP_id              = $_POST['DP_id'];
$Downpayment        = $_POST['Downpayment'];

try {
    $conn->beginTransaction();

    $upd_downpayment = $conn->prepare("UPDATE dwnpyment SET DPayment=? WHERE DP_id =?");
    $upd_downpayment->execute([$Downpayment,$DP_id]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    