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
$Role           = 'CNC';
$AccountStatus  = 'ENABLE';
$AccountType    = 'Branch Account';
$Position       = 'CNCMANAGER'; 
$IDMAccess      = 1;
$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);


try {
    date_default_timezone_set('Asia/Manila');
    $CommitDate  = date('Y-m-d');
    $CreatedTime = date('H:i:s');
    $Software    = 'IQUOTE';
    $Action      = "Create Staff - $Username - $UPosition - $Branch";
    $Admin       = $_SESSION['UserName']; 
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

    /*Check and find user in the branch to prevent duplicate*/
    $check_branch = $conn->prepare("
        SELECT COUNT(*)
        FROM usr 
        WHERE Branch = ? AND Createdby = ?
    ");
    $check_branch->execute([$Branch, $Admin]);

    if ($check_branch->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This Account Already assigned in this branch.");
    }


    // Fetch contact
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
        (Name, Position, UPosition, Username, Password, Branch, Bcode, Role, AccountType, Landline, Mobile, Createdby, Corporation, Address, Region, AccountStatus, IDMAccess)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
        $Corpcode,
        $Address,
        $Area,
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
