<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin = $_SESSION['UserName'];
$Approver = $conn->prepare("SELECT Name, UPosition FROM USR WHERE UserName = ?");
$Approver->execute([$Admin]);
$row = $Approver->fetch(PDO::FETCH_ASSOC);

$Name       = $row['Name'];
$Position   = $row['UPosition'];
$QNumber    = $_POST['QNumber'];
$Comment    = $_POST['Comment'];
$Feedback    = $_POST['Feedback'];
$Status     = $_POST['Status'];

try {
     /*Insert Audit Logs*/
    date_default_timezone_set('Asia/Manila');
    $CommitDate = date('Y-m-d');
    $CreatedTime = date('H:i:s');
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    $Software = 'IQUOTE';
    $Action = "Cancelled Quotation - $QNumber";


    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
    $conn->beginTransaction();

    date_default_timezone_set('Asia/Manila');
    $approvedDate = date('Y-m-d H:i:s');

    $upd_reject = $conn->prepare("
        UPDATE qtation 
        SET QStatus=?, Comment=?, FEEDBACK = ?, APPROVER=?, APOSITION=?, Approveddate=?  
        WHERE QNumber=?
    ");
    $upd_reject->execute([
        $Status,
        $Comment,
        $Feedback,
        $Name,
        $Position,
        $approvedDate,
        $QNumber
    ]);

    
    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
