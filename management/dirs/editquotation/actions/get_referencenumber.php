<?php
  session_start();
  require_once "../../../../config/local_db.php";

  $QNumber     = $_POST['QNumber'];
  $response    = array();

try {
  date_default_timezone_set('Asia/Manila');
  $CommitDate  = date('Y-m-d');
  $CreatedTime = date('H:i:s');
  $Software    = 'IQUOTE';
  $Action      = "Verify Quotation - $QNumber";
  $Admin    = $_SESSION['UserName']; 


  // Get client and user details
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

    

    $fetch_link = $conn->prepare("
      SELECT QNumber
      FROM qtation 
      WHERE QNumber = ?
    ");
    $fetch_link->execute([ $QNumber ]);
    $get_link = $fetch_link->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_link
  );
  echo json_encode($response);

}catch (PDOException $e){
  $conn->rollback();
  $response = array(
    "isSuccess" => 'Failed',
    "Data" => "<b>Error. Please Contact System Developer. <br/></b>".$e->getMessage()
  );
  echo json_encode($response);
}
?>

