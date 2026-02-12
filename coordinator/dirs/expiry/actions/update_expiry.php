<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin          = $_SESSION['UserName'];
$CustomerType   = $_POST['CustomerType'];
$Type           = $_POST['Type'];
$ExpiryDays     = $_POST['ExpiryDays'];

try {
    /*Insert Audit Logs*/
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    $Software = 'IQUOTE';
    $Action = 'Update Expiry Control - ' . $Admin;
    $CommitDate = date('Y-m-d');
    $CreatedTime = date('H:i:s');

    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
    
    $conn->beginTransaction();
    $upd_expiry = $conn->prepare("UPDATE EXPIRATION_CONTROL SET Type=?,ExpiryDays=? WHERE CustomerType=?");
    $upd_expiry->execute([$Type,$ExpiryDays,$CustomerType]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    