<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin          = $_SESSION['UserName'];
$Admindetails = $conn->prepare("
  SELECT Landline, Mobile
  FROM usr
  WHERE Username = ?
");
$Admindetails->execute([ $Admin ]);
$row = $Admindetails->fetch(PDO::FETCH_ASSOC);

$Mobile     = $row['Mobile'];
$Landline   = $row['Landline'];


$Fullname       = strtoupper($_POST['Fullname']);
$UPosition      = $_POST['Position']; 
$Username       = $_POST['Username'];
$Password       = $_POST['Password']; 
$Branchcode     = $_POST['Branchcode'];
$Branch         = $_POST['Branch'];

$Role           = 'HBU';
$AccountStatus  = 'ENABLE';
$AccountType    = 'Head Office Encoder';
$Position       = 'Staff'; 
$Region         = 'Panay'; 
$Corporation    = 'VIAC'; 
$IDMAccess      = 1;
$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);


try {
    /*Insert Audit Logs*/
       date_default_timezone_set('Asia/Manila');
       $CommitDate = date('Y-m-d');
       $CreatedTime = date('H:i:s');
       $clientIP = $_SERVER['REMOTE_ADDR'];
       $fullHost = gethostbyaddr($clientIP);
       $Hostname = explode('.', $fullHost)[0];
       $Software = 'IQUOTE';
       $Action = "Create Staff - $Fullname - $Position - $Branch";

       $auditlogs = $conn->prepare("
           INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
           VALUES (?, ?, ?, ?, ?, ?)
       ");
       $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
       
    $conn->beginTransaction();

    // Check duplicate
    $check_duplicate = $conn->prepare("
        SELECT COUNT(*)
        FROM usr 
        WHERE Name = ? AND Branch = ? AND Username = ? AND Role = ?
    ");
    $check_duplicate->execute([$Fullname, $Branch, $Username, $Role]);
    if ($check_duplicate->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This Account Already Exists.");
    }
 

    // Insert user (make sure usr table has both Position and UPosition columns!)
    $ins_user = $conn->prepare("
        INSERT INTO usr 
        (Name, Position, UPosition, Username, Password, Branch, Bcode, Role, AccountType, Landline, Mobile, Createdby, Corporation, Region, AccountStatus, IDMAccess)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $ins_user->execute([
        $Fullname, 
        $Position,   // fixed CNCMANAGER
        $UPosition,  // dynamic user position
        $Username, 
        $hashedPassword, 
        $Branch, 
        $Branchcode,
        $Role, 
        $AccountType,
        $Landline,
        $Mobile,
        $Admin,
        $Corporation,
        $Region,
        $AccountStatus,
        $IDMAccess 
    ]);

    

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
