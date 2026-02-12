<?php
require_once "../../../config/local_db.php";

$Pay_id             = $_POST['Pay_id'];
$PaymentTerm        = $_POST['PaymentTerm'];
$PaymentPeriod      = $_POST['PaymentPeriod'];

try {
    $conn->beginTransaction();

    $upd_payterms = $conn->prepare("UPDATE instlment SET PayTerm=?,PayPeriod=? WHERE Pay_id =?");
    $upd_payterms->execute([$PaymentTerm,$PaymentPeriod,$Pay_id]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    