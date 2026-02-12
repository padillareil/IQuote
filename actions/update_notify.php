<?php
require_once "../config/local_db.php";

$Notify_id      = $_POST['Notify_id'];
$Status         = $_POST['Status'];

try {
    $conn->beginTransaction();

    $upd_notify = $conn->prepare("UPDATE NOTIFY SET Status=? WHERE Notify_id=?");
    $upd_notify->execute([$Status,$Notify_id]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    