<?php
  require_once "../../../../config/local_db.php";

  $Branch     = $_POST['Branch'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_corpcode = $conn->prepare("
      SELECT CompanyCode
      FROM BRANCHES
      WHERE Branch =?
    ");
    $fetch_corpcode->execute([ $Branch ]);
    $get_branch = $fetch_corpcode->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_branch
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