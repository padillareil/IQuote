<?php
  require_once "../../../../config/local_db.php";

  $Web_id     = $_POST['Web_id'];
  $response    = array();

try {
  $conn->beginTransaction();

    $web = $conn->prepare("
      SELECT Web_id, Web_url
      FROM WEBSITE_CONTROL
      WHERE Web_id = ?
    ");
    $web->execute([ $Web_id ]);
    $row = $web->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $row
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