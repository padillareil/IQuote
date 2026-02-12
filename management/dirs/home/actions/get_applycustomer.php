<?php
  require_once "../../../../config/local_db.php";

  $Customer     = $_POST['Customer'];
  $Company       = $_POST['Company'];

  $response    = array();

try { 
  $conn->beginTransaction();

    $fetch_customer = $conn->prepare("EXEC dbo.[CHOOSECUSTOMER_PROCEDURE] ?, ?");
    $fetch_customer->execute([ $Customer, $Company ]);
    $get_customers = $fetch_customer->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_customers
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
