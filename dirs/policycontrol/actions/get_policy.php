<?php
  require_once "../../../config/local_db.php";

  $Termdid     = $_POST['Termdid'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_terms = $conn->prepare("
      SELECT Termdid, TRMSCON
      FROM trmscondition 
      WHERE Termdid = ?
    ");
    $fetch_terms->execute([ $Termdid ]);
    $get_termspolicy = $fetch_terms->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_termspolicy
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

