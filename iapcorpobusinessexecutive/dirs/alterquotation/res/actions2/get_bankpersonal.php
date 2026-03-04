<?php
  require_once "../../../../config/VIAC_QUOTATION.php";

  $Branch     = $_POST['Branch'];

  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_branchbank = $conn->prepare("
      EXEC GET_PERSONALBANKACCOUNT @mBranch_ = ?
    ");
    $fetch_branchbank->execute([ $Branch ]);
    $get_branchbank = $fetch_branchbank->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_branchbank
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
