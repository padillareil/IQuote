<?php
session_start();
require_once "../../../config/local_db.php";

$Admin      = $_SESSION['UserName'];
$IDMAccess  = 1;
try {
    $conn->beginTransaction();

    $upd_reset = $conn->prepare("UPDATE usr SET IDMAccess =? WHERE Role NOT IN ('SA')");
    $upd_reset->execute([$IDMAccess]);



    date_default_timezone_set('Asia/Manila');
    $approvedTime = date('H:i:s');

    date_default_timezone_set('Asia/Manila');
    $approvedDate = date('Y-m-d');


    $insertlogs = $conn->prepare("INSERT INTO accountreset_logs
        (Time, ResetDate, Username
            )VALUES(?,?,?)");
    $insertlogs->execute([$approvedTime, $approvedDate, $Admin]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    