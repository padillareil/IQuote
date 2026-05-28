<?php
  session_start();
  require_once "../../../../config/local_db.php";

  $Admin        = $_SESSION['UserName'];
  $Customer     = $_POST['Customer'];

  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_customer = $conn->prepare("EXEC dbo.[FINDCUSTOMER_PROCEDURE] ?, ?");
    $fetch_customer->execute([ $Admin, $Customer ]);
    $get_customers = $fetch_customer->fetchAll(PDO::FETCH_ASSOC);

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
