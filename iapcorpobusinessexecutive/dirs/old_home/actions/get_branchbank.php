<?php
  require_once "../../../../config/local_db.php";

try {
  $conn->beginTransaction();

    $fetch_branchbank = $conn->prepare("
      SELECT Bank, AccNumber, AccName
      FROM BNK 
    ");
    $fetch_branchbank->execute();
    $get_bank = $fetch_branchbank->fetchAll(PDO::FETCH_ASSOC);

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