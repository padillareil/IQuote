<?php
session_start();
require_once "../../../../config/local_db.php";

$UserName   = $_POST['UserName'];
$Status      = $_POST['Status'];

try {
    /*Insert Audit Logs*/
    date_default_timezone_set('Asia/Manila');
    $CommitDate  = date('Y-m-d');
    $CreatedTime = date('H:i:s');
    $Software    = 'IQUOTE';
    $Action      = "Enable Access - $UserName";
    $Admin = $_SESSION['UserName'];
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
    
    $conn->beginTransaction();

    $upd_status = $conn->prepare("UPDATE usr SET AccountStatus=? WHERE UserName=?");
    $upd_status->execute([$Status,$UserName]);


   

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    