<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin          = $_SESSION['UserName'];
$NewPassword    = $_POST['NewPassword'];
$hashedPassword = password_hash($NewPassword, PASSWORD_DEFAULT);

try {
    /*Insert Audit Logs*/
       date_default_timezone_set('Asia/Manila');
       $clientIP = $_SERVER['REMOTE_ADDR'];
       $fullHost = gethostbyaddr($clientIP);
       $Hostname = explode('.', $fullHost)[0];
       $Software = 'IQUOTE';
       $Action = 'Account Security Update';
       $CommitDate = date('Y-m-d');
       $CreatedTime = date('H:i:s');

       $auditlogs = $conn->prepare("
           INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
           VALUES (?, ?, ?, ?, ?, ?)
       ");
       $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);


    $conn->beginTransaction();

    $upd_password = $conn->prepare("UPDATE usr SET PassWord=? WHERE UserName=?");
    $upd_password->execute([$hashedPassword,$Admin]);


    // Update existing user’s profile
    /*$upd_profile = $conn->prepare("UPDATE USR SET Profile = ? WHERE UserName = ?");
    $upd_profile->execute([$relativePath, $Admin]);*/

    


    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    