<?php
  require_once "../../../../config/local_db.php";

  $QNUMBER     = $_POST['QNUMBER'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_quoteinfo = $conn->prepare("
      SELECT FEEDBACK, Comment, QSTATUS
      FROM qtation  
      WHERE QNumber =?
    ");
    $fetch_quoteinfo->execute([ $QNUMBER ]);
    $get_quoteinfo = $fetch_quoteinfo->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_quoteinfo
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