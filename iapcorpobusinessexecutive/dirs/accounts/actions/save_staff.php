<?php
session_start();
require_once "../../../../config/i_quote.php";

$Admin = $_SESSION['Username'];
$User = $conn->prepare("
  SELECT Region, Address
  FROM user 
  WHERE Username = ?
");
$User->execute([$Admin]);
$row = $User->fetch(PDO::FETCH_ASSOC);

$Fullname       = $_POST['Fullname'];
$Position       = $_POST['Position'];
$Username       = $_POST['Username'];
$Password       = $_POST['Password'];
$Branch         = $_POST['Branch'];
$Role           = 'ST';
$UserType       = 'S';
$AccountSetup   = 'N';
$Status         = 'N';

try {

     /*Insert Audit Logs*/
    date_default_timezone_set('Asia/Manila');
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    $Software = 'IQUOTE';
    $Action = 'Create staff' . $Fullname . $Position . $Branch;
    $CommitDate = date('Y-m-d');
    $CreatedTime = date('H:i:s');

    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
    
    $conn->beginTransaction();

    // Check duplicate
    $check_duplicate = $conn->prepare("
        SELECT COUNT(*)
        FROM user 
        WHERE Fullname = ? AND Branch = ? AND Username = ?
    ");
    $check_duplicate->execute([$Fullname, $Branch , $Username]);
    if ($check_duplicate->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This Account Already Exists.");
    }

    // Insert user
    $ins_user = $conn->prepare("
        INSERT INTO user 
        (Fullname, Position, Username, Password, Branch, Role, UserType, AccountSetup, Status, Region, Address, Manager)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $ins_user->execute([
        $Fullname, 
        $Position, 
        $Username, 
        $Password, 
        $Branch, 
        $Role, 
        $UserType, 
        $AccountSetup, 
        $Status, 
        $row['Region'], 
        $row['Address'],
        $Admin
    ]);





    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
