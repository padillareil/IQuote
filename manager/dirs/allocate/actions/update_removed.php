<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin              = $_SESSION['UserName'];
$UserName           = $_POST['UserName'];
$Status             = $_POST['Status'];

try {
    date_default_timezone_set('Asia/Manila');
    /*Insert Audit Logs*/
       $clientIP = $_SERVER['REMOTE_ADDR'];
       $fullHost = gethostbyaddr($clientIP);
       $Hostname = explode('.', $fullHost)[0];
       $Software = 'IQUOTE';
       $Action = "Removed Staff - $UserName";
       $CommitDate = date('Y-m-d');
       $CreatedTime = date('H:i:s');


       $auditlogs = $conn->prepare("
           INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
           VALUES (?, ?, ?, ?, ?, ?)
       ");
       $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);

    $approvedDate = date('Y-m-d H:i:s');


    $fetch_user = $conn->prepare("SELECT UserName, Name, Branch, UPosition FROM usr WHERE UserName = ?");
    $fetch_user->execute([ $UserName ]);
    $row = $fetch_user->fetch(PDO::FETCH_ASSOC);

    $UsrName   = $row['UserName'];
    $Name       = $row['Name'];
    $Branch     = $row['Branch'];
    $Position  = $row['UPosition'];


    $insert_user = $conn->prepare("INSERT INTO remove_usr
        (Username, Name, Branch, Position, Deletedby, DocRemoved)VALUES(?,?,?,?,?,?)");
    $insert_user->execute([$UsrName, $Name, $Branch, $Position, $Admin, $approvedDate]);
    
    $conn->beginTransaction();

   


    /*Delete user after insrting the removed user to table remove_usr*/
    $del_user= $conn->prepare("DELETE FROM usr WHERE UserName=?");
    $del_user->execute([ $UserName ]);

    

    
    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    