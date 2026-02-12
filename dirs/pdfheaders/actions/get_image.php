<?php
  require_once "../../../config/local_db.php";

  $Header_id     = $_POST['Header_id'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_header = $conn->prepare("
      SELECT ImageHeader, Header_id,Corpo
      FROM crpheader 
      WHERE Header_id = ?
    ");
    $fetch_header->execute([ $Header_id ]);
    $get_header = $fetch_header->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_header
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

