<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin          = $_SESSION['UserName'];
$Fullname = strtoupper($_POST['Fullname']);
$UPosition      = $_POST['Position']; 
$Username       = $_POST['Username'];
$Password       = $_POST['Password']; 
$Branchcode     = $_POST['Branchcode'];
$Branch         = $_POST['Branch'];
$Contact        = $_POST['Contact']?? '';
$Email          = $_POST['Email']?? '';
$Role           = 'HBU';
$AccountStatus  = 'ENABLE';
$AccountType    = 'Head Office Branch';
$Position       = 'CNCMANAGER'; 
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
       $Action = "Create Staff - $Fullname - $UPosition - $Branch";

       $auditlogs = $conn->prepare("
           INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
           VALUES (?, ?, ?, ?, ?, ?)
       ");
       $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);



    $conn->beginTransaction();

    // Check duplicate
    $check_duplicate = $conn->prepare("
        SELECT *
        FROM USR 
        WHERE Name = ? OR Username = ?
    ");
    $check_duplicate->execute([$Fullname, $Username]);
    if ($check_duplicate->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This Account Already Exists.");
    }


    $get_contacts = $conn->prepare("
      SELECT Telephone, Mobile
      FROM contacts 
      WHERE Branch = ?
    ");
    $get_contacts->execute([$Branch]);
    $row = $get_contacts->fetch(PDO::FETCH_ASSOC);

    $Landline   = $row['Telephone'];
    $Mobile     = $row['Mobile'];

    // Fetch branch details
    $get_branch = $conn->prepare("
      SELECT Companycode, Address, Area
      FROM branches 
      WHERE Branch = ?
    ");
    $get_branch->execute([$Branch]);
    $row = $get_branch->fetch(PDO::FETCH_ASSOC);

    $Corpcode   = $row['Companycode'];
    $Address    = $row['Address'];
    $Area       = $row['Area'];

    // Insert user (make sure usr table has both Position and UPosition columns!)
    $ins_user = $conn->prepare("
        INSERT INTO usr 
        (Name, Position, UPosition, Username, Password, Branch, Bcode, Role, AccountType, Landline, Mobile, Createdby, Corporation, Address, Region, AccountStatus, IDMAccess, Email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
        $Contact,
        $Admin,
        $Corpcode,
        $Address,
        $Area,
        $AccountStatus,
        $IDMAccess,
        $Email
    ]);


  


    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
