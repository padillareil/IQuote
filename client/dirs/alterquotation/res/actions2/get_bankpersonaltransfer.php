<?php
  require_once "../../../../config/VIAC_QUOTATION.php";

  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_corpobanktrasnfer = $conn->prepare("
      EXEC [GET_PERSONALBANKACCOUNTTRANSFER]
    ");
    $fetch_corpobanktrasnfer->execute();
    $get_banktrasnfer = $fetch_corpobanktrasnfer->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_banktrasnfer
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
