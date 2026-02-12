<?php
  require_once "../../../../config/local_db.php";
  session_start();

  $UserName     = $_SESSION['UserName'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_bankdetails = $conn->prepare("
      SELECT Bcode
      FROM USR 
      WHERE UserName  = ?
    ");
    $fetch_bankdetails->execute([ $UserName ]);
    $get_bank = $fetch_bankdetails->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_bank
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
