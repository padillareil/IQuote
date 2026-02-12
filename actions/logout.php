<?php
session_start();

require_once "../config/local_db.php";

$Admin = isset($_SESSION['UserName']) ? $_SESSION['UserName'] : 'Unknown User';

$clientIP = $_SERVER['REMOTE_ADDR'];
$fullHost = gethostbyaddr($clientIP);
$Hostname = explode('.', $fullHost)[0];
$Software = 'IQUOTE';
$Action = 'LOGOUT - ' . $Admin;

date_default_timezone_set('Asia/Manila');

$CommitDate = date('Y-m-d');
$CreatedTime = date('H:i:s');

try {
    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
    echo "OK";
} catch (PDOException $e) {
    echo "Error inserting audit log: " . $e->getMessage();
}

session_destroy();
?>
