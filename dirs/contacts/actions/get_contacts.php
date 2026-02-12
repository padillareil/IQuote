<?php
  require_once "../../../config/local_db.php";

  $TID     = $_POST['TID'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_contact = $conn->prepare("
      SELECT TID, Branch, Telephone, Mobile, Network
      FROM contacts 
      WHERE TID = ?
    ");
    $fetch_contact->execute([ $TID ]);
    $get_contact = $fetch_contact->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_contact
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

