<?php
  require_once "../../../../config/local_db.php";

  $UserName     = $_POST['UserName'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_bankdetails = $conn->prepare("
      SELECT UserName
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