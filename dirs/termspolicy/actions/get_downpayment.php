<?php
  require_once "../../../config/local_db.php";

  $DP_id     = $_POST['DP_id'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_downpayment = $conn->prepare("
      SELECT DPayment,DP_id
      FROM dwnpyment 
      WHERE DP_id = ?
    ");
    $fetch_downpayment->execute([ $DP_id ]);
    $get_dnwpayment = $fetch_downpayment->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_dnwpayment
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

