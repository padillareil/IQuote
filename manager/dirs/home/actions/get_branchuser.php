<?php
  session_start();
  require_once "../../../../config/local_db.php";

  $Admin     = $_SESSION['UserName'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_branch = $conn->prepare("
      SELECT Branch
      FROM usr 
      WHERE UserName = ?
    ");
    $fetch_branch->execute([ $Admin ]);
    $get_branch = $fetch_branch->fetchAll(PDO::FETCH_ASSOC);

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

