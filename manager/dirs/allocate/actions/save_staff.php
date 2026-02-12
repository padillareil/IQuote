<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin          = $_SESSION['UserName'];
$admin = $conn->prepare("
  SELECT Branch, Corporation, Mobile, Landline, Bcode, Region
  FROM usr 
  WHERE UserName = ?
");
$admin->execute([$Admin]);
$row = $admin->fetch(PDO::FETCH_ASSOC);

$Branch         = $row['Branch'];
$Corporation    = $row['Corporation'];
$Bcode          = $row['Bcode'];
$Region         = $row['Region'];


$Fullname       = strtoupper($_POST['Fullname']);
$UPosition      = $_POST['Position']; 
$Username       = $_POST['Username'];
$Password       = $_POST['Password']; 
$Branchcode     = $_POST['Branchcode'];
$AccountType     = $_POST['AccountType'];
/*$Branch         = $_POST['Branch'];*/
$Role           = 'HBU';
$AccountStatus  = 'ENABLE';
$IDMAccess      = 1;

$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

try {

    date_default_timezone_set('Asia/Manila');
    $CommitDate = date('Y-m-d');
    $CreatedTime = date('H:i:s');
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    $Software = 'SERVICE';
    $Action = "Create Staff - $Fullname - $UPosition";

    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG  (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
    
    $conn->beginTransaction();

    // Check duplicate
    $check_duplicate = $conn->prepare("
        SELECT *
        FROM usr 
        WHERE Name = ? OR Username = ?
    ");
    $check_duplicate->execute([$Fullname, $Username]);
    if ($check_duplicate->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This Account Already Exists.");
    }

    /*Check and find user in the branch to prevent duplicate*/
  /*  $check_branch = $conn->prepare("
        SELECT COUNT(*)
        FROM usr 
        WHERE Branch = ? AND Createdby = ?
    ");
    $check_branch->execute([$Branch, $Admin]);

    if ($check_branch->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This Account Already assigned in this branch.");
    }
*/

    // Fetch contact
    $param = ($Branch === 'ONLN') ? $Bcode : $Branch;

    $get_contacts = $conn->prepare("
      SELECT Telephone, Mobile
      FROM contacts 
      WHERE Branch = ?
    ");
    $get_contacts->execute([$param]);
    $row = $get_contacts->fetch(PDO::FETCH_ASSOC);

    $Landline = $row['Telephone'] ?? null;
    $Mobile   = $row['Mobile'] ?? null;


    // Fetch branch details
  /*  $get_branch = $conn->prepare("
      SELECT Companycode, Address, Area
      FROM branches 
      WHERE Branch = ?
    ");
    $get_branch->execute([$Branch]);
    $row = $get_branch->fetch(PDO::FETCH_ASSOC);

    $Corpcode   = $row['Companycode'];
    $Address    = $row['Address'];
    $Area       = $row['Area'];*/

    // Insert user (make sure usr table has both Position and UPosition columns!)
    $ins_user = $conn->prepare("
        INSERT INTO usr 
        (Name, Position, UPosition, Username, Password, Branch, Bcode, Role, Landline, Mobile, Createdby, Corporation, AccountStatus,IDMAccess, AccountType , Mode,Region )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)
    ");
    $ins_user->execute([
        $Fullname, 
        $UPosition,   // fixed CNCMANAGER
        $UPosition,  // dynamic user position
        $Username, 
        $hashedPassword, 
        $Bcode, 
        $Branchcode,
        $Role, 
        $Landline,
        $Mobile,
        $Admin,
        $Corporation,
        $AccountStatus,
        $IDMAccess,
        $AccountType,
        $IDMAccess,
        $Region  
    ]);

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
