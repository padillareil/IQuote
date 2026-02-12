<?php
  require_once "../../../../config/local_db.php";


try {
  $conn->beginTransaction();

    $fetch_installment = $conn->prepare("
      SELECT PayTerm, PayPeriod
      FROM INSTLMENT
      ORDER BY Pay_id ASC
    ");
    $fetch_installment->execute();
    $get_instllment = $fetch_installment->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_instllment
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