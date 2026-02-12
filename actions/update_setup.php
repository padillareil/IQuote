<?php
session_start();
require_once "../config/local_db.php";

$Admin = $_SESSION['Username'];
$ua = $conn->prepare("
    SELECT ua.Username, ua.Role
    FROM user ua
    WHERE ua.Username = ?
");
$ua->execute([$Admin]);
$user = $ua->fetch(PDO::FETCH_ASSOC);

$Password     = $_POST['Password'];
$RecQuestion  = $_POST['RecQuestion'];
$RecAnswer    = $_POST['RecAnswer'];
$LogDetails   = $_POST['LogDetails'];
$AccountSetup = 'Y';

try {
    $conn->beginTransaction();

    date_default_timezone_set('Asia/Manila');
    $DocumentDate = date('Y-m-d');
    $DocumentTime = date('H:i:s');

    // Update user account
    $upd_account = $conn->prepare("
        UPDATE user 
        SET Password=?, RecQuestion=?, RecAnswer=?, AccountSetup=? 
        WHERE Username=?
    ");
    $upd_account->execute([$Password, $RecQuestion, $RecAnswer, $AccountSetup, $Admin]);

    // Insert activity logs
    $ins_acitiviylogs = $conn->prepare("
        INSERT INTO activitylogs (Username, Role, LogDetails, DocumentDate, DocumentTime)
        VALUES (?,?,?,?,?)
    ");
    $ins_acitiviylogs->execute([$user['Username'], $user['Role'], $LogDetails, $DocumentDate, $DocumentTime]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
