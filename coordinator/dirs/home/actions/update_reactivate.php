<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin          = $_SESSION['UserName'];
$QNumber        = $_POST['QNumber'];
$CustomerType   = $_POST['CustomerType'];
$Remarks        = $_POST['Remarks'];
$Status         = 'APPROVED';

try {
    date_default_timezone_set('Asia/Manila');
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    $Software = 'IQUOTE';
    $Action = 'Re-activate Quotation - ' . $Admin;
    $CommitDate = date('Y-m-d');
    $CreatedTime = date('H:i:s');

    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);

    $conn->beginTransaction();

    /*Set Date and Tme*/
    $Expiration = "";
    if ($CustomerType == 'CORPORATE GOVERNMENT') {
        // +30 days for Corporate Government
        $Expiration = date('Y-m-d', strtotime('+30 days'));
    } else {
        // +7 days for others
        $Expiration = date('Y-m-d', strtotime('+7 days'));
    }


      /*Update Reactivate*/
      $upd_reactivate = $conn->prepare("UPDATE QTATION SET QSTATUS = ?, Expiry=? WHERE QNumber=?");
      $upd_reactivate->execute([$Status,$Expiration,$QNumber]);


      /*Insert Reactivate LoGS*/
       $logs = $conn->prepare("INSERT INTO REACTIVATE_LOGS
        (Username, Remarks,DocDate
          )VALUES(?,?,?)");
       $logs->execute([$Admin,$Remarks, $CommitDate]);

        /*reactivateion Logs*/
       $logs = $conn->prepare("INSERT INTO REACTIVATION_LOGS
        (QNumber, ReActivation_Date, Username, Reason
          )VALUES(?,?,?,?)");
       $logs->execute([$QNumber,$CommitDate, $Admin, $Remarks]);


    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    