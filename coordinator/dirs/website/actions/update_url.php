<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin          = $_SESSION['UserName'];
$Web_id         = $_POST['Web_id'];
$Web_url        = $_POST['Web_url'];

try {
    /*Insert Audit Logs*/
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    $Software = 'IQUOTE';
    $Action = 'Update Website URL - ' . $Admin;
    $CommitDate = date('Y-m-d');
    $CreatedTime = date('H:i:s');

    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);

    $conn->beginTransaction();
   

    $upd_website = $conn->prepare("UPDATE WEBSITE_CONTROL SET Web_url=? WHERE Web_id=?");
    $upd_website->execute([$Web_url,$Web_id]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    