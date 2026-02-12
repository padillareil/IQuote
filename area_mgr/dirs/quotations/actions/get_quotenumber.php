<?php
  require_once "../../../../config/local_db.php";

  $QNUMBER     = $_POST['QNUMBER'];
try {
  $conn->beginTransaction();

    $fetch_qnumber = $conn->prepare("
      SELECT QNumber
      FROM QTATION 
      WHERE QNumber = ?
    ");
    $fetch_qnumber->execute([ $QNUMBER ]);
    $get_qnumber = $fetch_qnumber->fetch(PDO::FETCH_ASSOC);
  $conn->commit();
  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_qnumber
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

