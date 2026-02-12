<?php
  require_once "../../../../config/local_db.php";

  $CustomerType     = $_POST['CustomerType'];
  $response    = array();

try {
  $conn->beginTransaction();

    $expiry = $conn->prepare("
      SELECT CustomerType, Type,ExpiryDays
      FROM EXPIRATION_CONTROL
      WHERE CustomerType = ?
    ");
    $expiry->execute([ $CustomerType ]);
    $row = $expiry->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $row
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