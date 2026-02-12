<?php
  require_once "../../../config/local_db.php";

  $Branch     = $_POST['Branch'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_bcode = $conn->prepare("
      SELECT BranchCode
      FROM branches 
      WHERE Branch = ?
    ");
    $fetch_bcode->execute([ $Branch ]);
    $get_branch = $fetch_bcode->fetch(PDO::FETCH_ASSOC);

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

