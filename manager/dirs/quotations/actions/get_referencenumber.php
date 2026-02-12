<?php
  session_start();
  require_once "../../../../config/local_db.php";

  $QNumber     = $_POST['QNumber'];
  $response    = array();

try {
  $conn->beginTransaction();
    $fetch_link = $conn->prepare("
      SELECT QNumber
      FROM QTATION 
      WHERE QNumber = ?
    ");
    $fetch_link->execute([ $QNumber ]);
    $get_link = $fetch_link->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_link
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

