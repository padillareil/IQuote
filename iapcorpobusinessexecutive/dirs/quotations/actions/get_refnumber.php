<?php
  require_once "../../../../config/local_db.php";

  $QNumber     = $_POST['QNumber'];
try {
  $conn->beginTransaction();

    $fetch_qnumber = $conn->prepare("
      SELECT QNumber, QSTATUS AS QStatus
      FROM QTATION 
      WHERE QNumber = ?
    ");
    $fetch_qnumber->execute([ $QNumber ]);
    $get_refnum = $fetch_qnumber->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_refnum
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