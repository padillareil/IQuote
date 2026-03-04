<?php
  require_once "../../../../config/local_db.php";

  $Username     = $_POST['Username'];

try {
  $conn->beginTransaction();

    $fetch_contact = $conn->prepare("
      SELECT Mobile, Email
      FROM USR 
      WHERE Username = ?
    ");
    $fetch_contact->execute([ $Username ]);
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