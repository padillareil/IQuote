<?php
  require_once "../../../config/local_db.php";

  $Pay_id     = $_POST['Pay_id'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_paymentterms = $conn->prepare("
      SELECT PayTerm, PayPeriod,Pay_id
      FROM instlment 
      WHERE Pay_id = ?
    ");
    $fetch_paymentterms->execute([ $Pay_id ]);
    $get_payterms = $fetch_paymentterms->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_payterms
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

