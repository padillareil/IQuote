<?php
session_start();
require_once "../../../config/local_db.php";

$Admin       = $_SESSION['UserName'];
$Bcode       = $_POST['Bcode'];
$UPosition   = $_POST['UPosition'];
$Branch      = $_POST['Branch'];
$Fullname    = strtoupper($_POST['Fullname']);
$Username    = $_POST['Username'];
$Password    = $_POST['Password'];
$Position    = $_POST['Position'];
$Role        = 'Admin';
$AccountStatus = 'ENABLE';
$IDMAccess  = 1;

$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);


try {
    $conn->beginTransaction();

  
    $check_duplicate = $conn->prepare("
        SELECT COUNT(*)
        FROM usr 
        WHERE Name = ? AND Branch = ? AND Username = ?
    ");
    $check_duplicate->execute([$Fullname, $Branch, $Username]);
    if ($check_duplicate->fetchColumn() > 0) {
        $conn->rollBack();
        exit("This Account Already Exists.");
    }

  
    $region = $conn->prepare("
      SELECT Area AS Region, Address
      FROM branches 
      WHERE Branch = ?
    ");
    $region->execute([$Branch]);
    $row = $region->fetch(PDO::FETCH_ASSOC);
    $Region  = $row['Region'] ?? '';
    $Address = $row['Address'] ?? '';

   
    $contact = $conn->prepare("
      SELECT Mobile, Telephone
      FROM contacts 
      WHERE Branch = ?
    ");
    $contact->execute([$Branch]);
    $row = $contact->fetch(PDO::FETCH_ASSOC);
    $Mobile   = $row['Mobile'] ?? '';
    $Landline = $row['Telephone'] ?? '';

 
    $ins_account = $conn->prepare("INSERT INTO usr
        (Bcode, Name, UPosition, Landline, Mobile, Position, Role, AccountStatus, Corporation, Address, Region, Branch, Username, Password, Createdby, IDMAccess)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $ins_account->execute([
        $Bcode,
        $Fullname,
        $UPosition,
        $Landline,
        $Mobile,
        $Position,
        $Role,
        $AccountStatus,
        $Bcode,   
        $Address,
        $Region,
        $Branch,
        $Username,
        $hashedPassword, 
        $Admin,
        $IDMAccess
    ]);

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
