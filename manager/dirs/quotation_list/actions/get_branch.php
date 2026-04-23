<?php
  require_once "../../../../config/local_db.php";


try {
  $conn->beginTransaction();

    $fetch_iapbranches = $conn->prepare("EXEC dbo.[IAPBRANCHES]");
    $fetch_iapbranches->execute();
    $get_branch = $fetch_iapbranches->fetchAll(PDO::FETCH_ASSOC);

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