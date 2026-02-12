<?php
  session_start();
  require_once "../../../../config/local_db.php";
  $Admin = $_SESSION['UserName'];
  $CustomerType  = $_POST['CustomerType'];

try {
  /*Insert Audit Logs*/
  $clientIP = $_SERVER['REMOTE_ADDR'];
  $fullHost = gethostbyaddr($clientIP);
  $Hostname = explode('.', $fullHost)[0];
  $Software = 'IQUOTE';
  $Action = 'Delete Expiry Control - ' . $Admin;
  $CommitDate = date('Y-m-d');
  $CreatedTime = date('H:i:s');

  $auditlogs = $conn->prepare("
      INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
      VALUES (?, ?, ?, ?, ?, ?)
  ");
  $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);

  $conn->beginTransaction();

    $del_expiry= $conn->prepare("DELETE FROM EXPIRATION_CONTROL WHERE CustomerType=?");
    $del_expiry->execute([ $CustomerType ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>