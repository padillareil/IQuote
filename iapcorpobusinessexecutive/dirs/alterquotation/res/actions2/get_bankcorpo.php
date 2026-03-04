<?php
  require_once "../../../../config/VIAC_QUOTATION.php";

  $Corpcode     = $_POST['Corpcode'];

  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_corpobank = $conn->prepare("
      EXEC GET_CORPOBANKACCOUNT @mCorpcode_ = ?
    ");
    $fetch_corpobank->execute([ $Corpcode ]);
    $get_bankcorpo = $fetch_corpobank->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_bankcorpo
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
